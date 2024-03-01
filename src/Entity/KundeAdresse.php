<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\KundeAdresseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KundeAdresseRepository::class)]
#[ORM\Table(name: 'std.kunde_addresse')]
#[ApiResource]
class KundeAdresse
{

    #[ORM\Column(length: 36)]
    private ?string $kundeId = null;

    #[ORM\Column]
    private ?int $adresseId = null;

    #[ORM\Column(nullable: true)]
    private ?bool $geschaeftlich = null;

    #[ORM\Column(nullable: true)]
    private ?bool $rechnungsadresse = null;

    #[ORM\Column]
    private ?bool $gekoescht = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKundeId(): ?string
    {
        return $this->kundeId;
    }

    public function setKundeId(string $kundeId): self
    {
        $this->kundeId = $kundeId;

        return $this;
    }

    public function getAdresseId(): ?int
    {
        return $this->adresseId;
    }

    public function setAdresseId(int $adresseId): self
    {
        $this->adresseId = $adresseId;

        return $this;
    }

    public function isGeschaeftlich(): ?bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(?bool $geschaeftlich): self
    {
        $this->geschaeftlich = $geschaeftlich;

        return $this;
    }

    public function isRechnungsadresse(): ?bool
    {
        return $this->rechnungsadresse;
    }

    public function setRechnungsadresse(?bool $rechnungsadresse): self
    {
        $this->rechnungsadresse = $rechnungsadresse;

        return $this;
    }

    public function isGekoescht(): ?bool
    {
        return $this->gekoescht;
    }

    public function setGekoescht(bool $gekoescht): self
    {
        $this->gekoescht = $gekoescht;

        return $this;
    }
}
