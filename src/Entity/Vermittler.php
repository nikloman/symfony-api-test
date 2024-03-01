<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VermittlerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VermittlerRepository::class)]
#[ORM\Table(name: 'std.vermittler')]
#[ApiResource]
class Vermittler
{
    #[ORM\Id]
    #[ORM\GeneratedValue('AUTO')]
    #[ORM\Column(nullable: false)]
    private ?int $id = null;

    #[ORM\Column(length: 36, nullable: false)]
    private ?string $nummer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vorname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nachname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firma = null;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private ?bool $geloescht = null;

    #[ORM\OneToOne(mappedBy: 'vermittler', cascade: ['persist', 'remove'])]
    private ?TblKunden $tblKunden = null;

    #[ORM\OneToOne(mappedBy: 'vermittlerId', cascade: ['persist', 'remove'])]
    private ?VermittlerUser $vermittlerUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNummer(): ?string
    {
        return $this->nummer;
    }

    public function setNummer(string $nummer): self
    {
        $this->nummer = $nummer;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(?string $nachname): self
    {
        $this->nachname = $nachname;

        return $this;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function isGel�oescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getTblKunden(): ?TblKunden
    {
        return $this->tblKunden;
    }

    public function setTblKunden(TblKunden $tblKunden): self
    {
        // set the owning side of the relation if necessary
        if ($tblKunden->getVermittler() !== $this) {
            $tblKunden->setVermittler($this);
        }

        $this->tblKunden = $tblKunden;

        return $this;
    }

    public function getVermittlerUser(): ?VermittlerUser
    {
        return $this->vermittlerUser;
    }

    public function setVermittlerUser(VermittlerUser $vermittlerUser): self
    {
        // set the owning side of the relation if necessary
        if ($vermittlerUser->getVermittlerId() !== $this) {
            $vermittlerUser->setVermittlerId($this);
        }

        $this->vermittlerUser = $vermittlerUser;

        return $this;
    }
}
