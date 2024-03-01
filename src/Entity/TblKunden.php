<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TblKundenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TblKundenRepository::class)]
#[ORM\Table(name: 'std.tlb_kunden')]
#[ApiResource]
class TblKunden
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    //id varchar (36) NOT NULL default (upper(left(gen_random_uuid()::text, 8))) PRIMARY KEY,
    private ?string $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vorname = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $firma = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $geburtsdatum = null;

    #[ORM\Column(nullable: true)]
    private ?int $geloescht = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $geschlecht = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $email = null;

    #[ORM\OneToOne(inversedBy: 'tblKunden', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vermittler $vermittler = null;

    #[ORM\OneToOne(mappedBy: 'kundenid', cascade: ['persist', 'remove'])]
    private ?User $securityUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function getGeburtsdatum(): ?\DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?\DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    public function getGeloescht(): ?int
    {
        return $this->geloescht;
    }

    public function setGeloescht(?int $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getGeschlecht(): ?string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?string $geschlecht): self
    {
        $this->geschlecht = $geschlecht;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVermittler(): ?Vermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(Vermittler $vermittler): self
    {
        $this->vermittler = $vermittler;

        return $this;
    }

    public function getSecurityUser(): ?User
    {
        return $this->securityUser;
    }

    public function setSecurityUser(?User $securityUser): self
    {
        // unset the owning side of the relation if necessary
        if ($securityUser === null && $this->securityUser !== null) {
            $this->securityUser->setKundenid(null);
        }

        // set the owning side of the relation if necessary
        if ($securityUser !== null && $securityUser->getKundenid() !== $this) {
            $securityUser->setKundenid($this);
        }

        $this->securityUser = $securityUser;

        return $this;
    }
}
