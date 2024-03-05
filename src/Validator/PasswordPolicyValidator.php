<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use UnexpectedValueException;

class PasswordPolicyValidator extends ConstraintValidator
{

    public function validate(#[\SensitiveParameter] mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PasswordPolicy) {
            throw new UnexpectedTypeException($constraint, PasswordPolicy::class);
        }

        if (null === $value) {
            return;
        }

        if (!\is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
        $password = count_chars($value, 1);
        $chars = \count($password);

        $control = $hasDigit = $hasUpper = $hasLower = $hasSymbol = $ignore = false;
        foreach ($password as $chr => $count) {

            match (true) {
                $chr < 32 || 127 === $chr => $ignore = true, // control characters
                48 <= $chr && $chr <= 57 => $hasDigit = true,
                65 <= $chr && $chr <= 90 => $hasUpper = true,
                97 <= $chr && $chr <= 122 => $hasLower = true,
                default => $hasSymbol = true,
            };
        }
        match (false) {
            $hasDigit, $hasUpper, $hasLower, $hasSymbol => $this->context->buildViolation($constraint->message)->setCode(PasswordPolicy::PASSWORD_POLICY_ERROR)->addViolation(),
            default => null
        };
    }
}