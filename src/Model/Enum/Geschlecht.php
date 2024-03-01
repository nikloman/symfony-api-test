<?php

namespace App\Model\Enum;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

enum Geschlecht: string {
    case Maennlich = 'männlich';
    case Weiblich = 'weiblich';
    case Divers = 'divers';
}