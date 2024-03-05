<?php

namespace App\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Uuid;

class ShortenedUuidGenerator extends AbstractIdGenerator
{
    #[\Override]
    public function generate(EntityManager $em, $entity)
    {
        return strtoupper(substr(Uuid::v4()->toRfc4122(), 0, 8));
    }
}