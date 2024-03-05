<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\NotExposed;
use App\Entity\Interfaces\BoolSoftDeletionFilterInterface;
use App\Repository\KundenAdressenRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: KundenAdressenRepository::class)]
#[ORM\Table(name: 'std.kunde_adresse')]
#[ApiResource]
#[NotExposed]
class KundenAdresse implements BoolSoftDeletionFilterInterface
{

    #[ManyToOne(targetEntity: Kunde::class, inversedBy: 'kundenAdressen')]
    #[JoinColumn(name: 'kunde_id', referencedColumnName: 'id', nullable: true)]
    private ?Kunde $kunde = null;


    #[ORM\Id()]
    #[ORM\OneToOne(inversedBy: 'kundenAdresse', targetEntity: Adresse::class)]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id', nullable: true)]
    #[Groups(['kunden:read'])]
    private ?Adresse $adresse = null;

    #[ORM\Column(nullable: true, options: ['default' => false])]
    private ?bool $geschaeftlich = null;

    #[ORM\Column(nullable: true)]
    private ?bool $rechnungsadresse = null;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private ?bool $geloescht = false;

    public function getKunde(): ?Kunde
    {
        return $this->kunde;
    }

    public function setKunde(?Kunde $kunde): self
    {
        $this->kunde = $kunde;

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

    public function isGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): void
    {
        $this->adresse = $adresse;
    }
}
