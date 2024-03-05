<?php

namespace App\Doctrine\Type;

use App\Model\Enum\Geschlecht;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class GeschlechtType extends Type
{
    public const NAME = 'geschlecht';

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return sprintf(
            'ENUM(%s)',
            implode(', ', array_map(
                fn($value) => "'{$value}'",
                array_column(Geschlecht::cases(), 'value')))
        );
    }

    #[\Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Geschlecht
    {
        return Geschlecht::tryFrom($value);
    }

    #[\Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!($value instanceof Geschlecht)) {
            throw new \InvalidArgumentException(sprintf('Expected %s', Geschlecht::class));
        }
        return $value->value;
    }

    #[\Override]
    public function getName(): string {
        return self::NAME;
    }

    #[\Override]
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

}