<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\StorageItem;
use App\Entity\UidGenerator;
use App\RequestValidator\ReservationDeleteRequestValidator;
use App\RequestValidator\ReservationPostRequestValidator;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ReservationController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * @throws Exception
     */
    #[Route('/reservation', methods: ['POST'])]
    public function handlePostReservation(Request $request): JsonResponse
    {
        $data = (new ReservationPostRequestValidator($this->em))->validated($request->toArray());

        $si = $this->em->getRepository(StorageItem::class);

        $conn = $this->em->getConnection();
        $conn->setAutoCommit(false);
        $conn->beginTransaction();

        try {
            $uid = (new UidGenerator())->generateUid($this->em, Reservation::class, 'uid');
            foreach ($data as $item) {
                [$require, $item_id] = [$item['require'], $item['item_id']];
                $amount = $si->getItemAmount($item_id);

                if ($amount < $require) {
                    $conn->rollBack();
                    return new JsonResponse(["message" => "required amount is not in stock."], 200);
                }

                $storageItems = $si->findStoragesWithItem($item_id);

                foreach ($storageItems as $storageItem) {
                    $amount = $storageItem->getAmount();

                    $reservation = new Reservation();
                    $reservation->setUid($uid);
                    $reservation->setStorageId($storageItem->getStorageId());
                    $reservation->setItemId($item_id);
                    $reservation->setStatusCreated();

                    if ($require > 0 && $amount <= $require) {
                        $reservation->setAmount($amount);
                        $require -= $amount;
                        $storageItem->setAmount(0);
                    }
                    elseif ($require > 0) {
                        $storageItem->setAmount($amount - $require);
                        $reservation->setAmount($require);
                        $require = 0;
                    }

                    $this->em->persist($reservation);
                    $this->em->persist($storageItem);
                    $this->em->flush();
                }
            }
            $conn->commit();
            return new JsonResponse(['reservation_id' => $uid]);
        } catch (\Exception $e) {
            $conn->rollBack();
            $this->em->clear();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    #[Route('/reservation', methods: ['DELETE'])]
    public function handleDeleteReservation(Request $request): JsonResponse
    {
        $data = (new ReservationDeleteRequestValidator($this->em))->validated($request->toArray());
        $r = $this->em->getRepository(Reservation::class);
        $si = $this->em->getRepository(StorageItem::class);

        $conn = $this->em->getConnection();
        $conn->setAutoCommit(false);

        $reservations = [];
        if (@$data['item_id']) {
            foreach ($data['item_id'] as $itemId) {
                $cur_reservations = $r->findReservationsByUidAndItemId($data['reservation_uid'], $itemId);

                if (!$cur_reservations) {
                    return new JsonResponse(["error" => "reservation with provided parameters was already cancelled or does not exist."], 400);
                }

                $reservations = array_merge($reservations, $cur_reservations);
            }
        }
        else {
            $reservations = $r->findReservationsByUid($data['reservation_uid']);

            if (!$reservations) {
                return new JsonResponse(["error" => "reservation with provided parameters was already cancelled or does not exist."], 400);
            }
        }

        $conn->beginTransaction();
        try {
            foreach ($reservations as $reservation) {
                $reservation->setStatusCancelled();

                $storageItem = $si->findByStorageIdAndItemId($reservation->getStorageId(), $reservation->getItemId());
                $storageItem->increaseAmount($reservation->getAmount());

                $this->em->persist($reservation);
                $this->em->persist($storageItem);
                $this->em->flush();
            }
            $conn->commit();
            return new JsonResponse(['message' => "Successfully cancelled reservation."]);
        } catch (\Exception $e) {
            $conn->rollBack();
            $this->em->clear();
            throw $e;
        }
    }
}
