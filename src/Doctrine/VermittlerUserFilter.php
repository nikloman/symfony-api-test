<?php

namespace App\Doctrine;

use App\Entity\Interfaces\VermittlerUserSpecificInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class VermittlerUserFilter extends SQLFilter
{
    public const VERMITTLER_USER_FILTER = 'vermittler_user_filter';
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($this->hasParameter(VermittlerUserFilter::VERMITTLER_USER_FILTER)) {
            $vermittler = $this->getParameter(VermittlerUserFilter::VERMITTLER_USER_FILTER);
            if ($targetEntity->reflClass->implementsInterface(VermittlerUserSpecificInterface::class)) {
                return $targetTableAlias.'.vermittler_id = '.$vermittler;
            }
        }
        return '';
    }
}