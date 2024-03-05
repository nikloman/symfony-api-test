<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\BundeslandRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BundeslandRepository::class)]
#[ORM\Table(name: 'public.bundesland')]
class Bundesland
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING ,length: 2, options: ['fixed' => true])]
    private ?string $kuerzel = null;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private ?string $name = null;

    public function getKuerzel(): ?string
    {
        return $this->kuerzel;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

}
