<?php

namespace App\Doctrine\Type;

use App\Model\Enum\Geschlecht;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class GeschlechtType extends Type
{
    public const SCHEMA = 'public';
    public const NAME = 'geschlecht';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return sprintf('%s.%s', self::SCHEMA, self::NAME);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Geschlecht
    {
        return Geschlecht::tryFrom($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!($value instanceof Geschlecht)) {
            throw new \InvalidArgumentException(sprintf('Expected %s', Geschlecht::class));
        }
        return $value->value;
    }

    public function getName(): string {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

}