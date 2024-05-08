<?php

namespace App\Validator;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraint;
class ConstraintExists extends Constraint
{
    public EntityRepository $repository;
    public string $column = 'id';
    public string $message = 'item does not exists.';

    public function __construct(
        EntityRepository $repository,
        ?string $column,
        ?string $message = null,
        ?array $groups = null,
        $payload = null
    ) {
        parent::__construct([], $groups, $payload);

        $this->repository = $repository;
        $this->column = $column ?? $this->column;
        $this->message = $message ?? $this->message;
    }
}