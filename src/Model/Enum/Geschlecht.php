<?php

namespace App\Model\Enum;


enum Geschlecht: string {
    case Maennlich = 'männlich';
    case Weiblich = 'weiblich';
    case Divers = 'divers';
}