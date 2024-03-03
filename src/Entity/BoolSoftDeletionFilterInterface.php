<?php

namespace App\Entity;

interface BoolSoftDeletionFilterInterface
{
    public function isGeloescht(): ?bool;
}