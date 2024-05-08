<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ConstraintExistsValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ConstraintExists) {
            throw new UnexpectedTypeException($constraint, ConstraintExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            $this->context->buildViolation('value should be of type string')->addViolation();
            return;
        }

        if (!$constraint->repository->count([$constraint->column => $value])) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}