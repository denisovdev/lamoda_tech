<?php
namespace App\RequestValidator;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use App\Validator\ConstraintExists;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationDeleteRequestValidator extends BaseRequestValidator
{

    public function __construct(protected readonly EntityManagerInterface $em)
    {
    }

    public function validated(array $data): array
    {
        $constraints = [
            'reservation_uid' => [
                new Assert\NotBlank(message: 'value should not be empty'),
                new ConstraintExists($this->em->getRepository(Reservation::class), 'uid'),
            ]
        ];

        if (@$data['item_id'] && count($data['item_id'])) {
            $constraints['item_id'] = [
                new Assert\Type('array', 'value should be of type array'),
                new Assert\All([
                    'constraints' => [
                        new Assert\NotBlank(message: 'value should not be empty'),
                        new ConstraintExists($this->em->getRepository(Reservation::class), 'item_id'),
                    ],
                ])
            ];
        }

        $constraints = new Assert\Collection($constraints);
        $this->validate($data, $constraints);
        return $data;
    }
}
