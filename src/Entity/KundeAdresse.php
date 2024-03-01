<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\KundeAdresseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KundeAdresseRepository::class)]
#[ORM\Table(name: 'std.kunde_addresse')]
class KundeAdresse
{

    #[ORM\Column(length: 36, nullable: false)]
    private ?string $kundeId = null;

    #[ORM\Column(nullable: false)]
    private ?int $adresseId = null;

    #[ORM\Column(nullable: true, options: ['default' => false])]
    private ?bool $geschaeftlich = null;

    #[ORM\Column(nullable: true)]
    private ?bool $rechnungsadresse = null;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private ?bool $geloescht = null;

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
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }
}
