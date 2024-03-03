<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
class PasswordPolicy extends Constraint
{
    public string $message = 'Das Passwort muss einen Groß- und Kleinbuchstaben, eine Zahl und ein Sonderzeichen enthalten.';
    public const PASSWORD_POLICY_ERROR = '48cca619-6fc0-4238-be4d-b40871e0d904';
    protected const ERROR_NAMES = [
        self::PASSWORD_POLICY_ERROR => 'PASSWORD_POLICY_ERROR',
    ];
    public function __construct(mixed $options = null, array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);
    }
}