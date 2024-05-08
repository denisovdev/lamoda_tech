<?php
namespace App\RequestValidator;

use App\Entity\StorageItem;
use App\Validator\ConstraintExists;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationPostRequestValidator extends BaseRequestValidator
{

    public function __construct(protected readonly EntityManagerInterface $em)
    {
    }

    public function validated(array $data): array
    {

        $constraints = new Assert\Collection([
            'item_id' => [
                new Assert\NotBlank(message: 'value should not be empty'),
                new ConstraintExists($this->em->getRepository(StorageItem::class), 'item_id'),
            ],
            'require' => [
                new Assert\NotBlank(message: 'value should not be empty'),
                new Assert\Type('integer', 'value should be of type integer'),
                new Assert\Range(notInRangeMessage: 'value should be between 1 and 2147483647', min: 1, max: 2147483647),
            ]
        ]);
        $itemIds = [];
        foreach ($data as $item)
        {
            $this->validate($item, $constraints);
            if (in_array($item['item_id'], $itemIds)) {
                (new JsonResponse([
                    'errors' => [
                        'property' => 'item_id',
                        'value' => $item['item_id'],
                        'message' => 'value is not unique in the sent request.',
                    ]
                    ], 400))->send();
                exit;
            }
            $itemIds[] = $item['item_id'];
        }

        return $data;
    }
}
