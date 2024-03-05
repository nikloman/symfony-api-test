<?php

namespace App\Doctrine;

use App\Entity\Interfaces\BoolSoftDeletionFilterInterface;
use App\Entity\Interfaces\IntSoftDeletionFilterInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class SoftDeletionFilter extends SQLFilter
{
    public const SOFT_DELETION_FILTER = 'soft_deletion_filter';
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($targetEntity->reflClass->implementsInterface(IntSoftDeletionFilterInterface::class)) {
            return $targetTableAlias.'.geloescht = 0';
        }

        if ($targetEntity->reflClass->implementsInterface(BoolSoftDeletionFilterInterface::class)) {
            return $targetTableAlias.'.geloescht = false';
        }
        return '';
    }
}