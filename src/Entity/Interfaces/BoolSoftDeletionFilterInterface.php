<?php

namespace App\Entity\Interfaces;

interface BoolSoftDeletionFilterInterface
{
    public function isGeloescht(): ?bool;
}