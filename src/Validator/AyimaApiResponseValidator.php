<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AyimaApiResponseValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $decodedResponse = json_decode($value, true);

        if (null === $value || !array_key_exists('marketIntel', $decodedResponse)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
