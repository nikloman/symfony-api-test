<?php

namespace App\Doctrine;

use App\Entity\SoftDeletionFilterInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class SoftDeletionFilter extends SQLFilter
{
    public const SOFT_DELETION_FILTER = 'soft_deletion_filter';
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($targetEntity->reflClass->implementsInterface(SoftDeletionFilterInterface::class)) {
            return $targetTableAlias.'.geloescht = 0';
        }
        return '';
    }
}