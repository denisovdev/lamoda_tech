<?php

namespace App\RequestValidator;

use Symfony\Component\Validator\Constraints as Assert;

class StorageGetRequestValidator extends BaseRequestValidator
{
    function validated($data): array
    {
        $data['id'] = is_numeric($data['id']) ? (int) $data['id'] : $data['id'];
        $data['page'] = is_numeric($data['page']) ? (int) $data['page'] : 1;

        $this->validate($data['id'], [
            new Assert\Type('integer', 'value should be of type integer'),
            new Assert\Range(notInRangeMessage: 'value should be between 1 and 2147483647', min: 1, max: 2147483647),
        ]);

        return $data;
    }
}