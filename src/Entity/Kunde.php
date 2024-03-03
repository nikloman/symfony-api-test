<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use App\Doctrine\Type\GeschlechtType;
use App\Entity\Interfaces\IntSoftDeletionFilterInterface;
use App\Entity\Interfaces\VermittlerUserSpecificInterface;
use App\Model\Enum\Geschlecht;
use App\Provider\AdressDetailsProvider;
use App\Provider\KundenAdressenProvider;
use App\Repository\KundenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: KundenRepository::class)]
#[ORM\Table(name: 'std.tbl_kunden')]
#[ApiResource(
    operations: [
        new Get(uriTemplate: '/kunden/{id}'),
        new Put(uriTemplate: '/kunden/{id}'),
        new GetCollection(uriTemplate: '/kunden'),
        new Delete(uriTemplate: '/kunden/{id}'),
    ],
    normalizationContext: ['groups' => 'kunden:read'],
    denormalizationContext: ['groups' => 'kunden:read'],
)]
class Kunde implements VermittlerUserSpecificInterface, IntSoftDeletionFilterInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::STRING, length: 36)]
    #[Groups(['kunden:read'])]
    #[ApiProperty(identifier: true)]
    private ?string $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['kunden:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['kunden:read'])]
    private ?string $vorname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $firma = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['kunden:read'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    private ?\DateTimeInterface $geburtsdatum = null;

    #[ORM\Column(nullable: true)]
    private ?int $geloescht = null;

    #[ORM\Column(type: GeschlechtType::NAME, length: 255, nullable: true)]
    #[Groups(['kunden:read'])]
    private ?Geschlecht $geschlecht = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['kunden:read'])]
    private ?string $email = null;

    #[ORM\OneToOne(inversedBy: 'tblKunden', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vermittler $vermittler = null;

    #[ORM\OneToOne(mappedBy: 'kunde', targetEntity: User::class)]
    #[Groups(['kunden:read'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'kunde', targetEntity: KundenAdresse::class)]
    private Collection $kundenAdressen;

    public function __construct()
    {
        $this->kundenAdressen = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
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

    public function getGeschlecht(): ?Geschlecht
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?Geschlecht $geschlecht): void
    {
        $this->geschlecht = $geschlecht;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    #[Groups(['kunden:read'])]
    #[SerializedName('adressen')]
    public function getAdressen(): array
    {
        return $this->kundenAdressen->map(fn (KundenAdresse $a) => $a->getAdresse())->toArray();
    }

    #[Groups(['kunden:read'])]
    #[SerializedName('vermittlerId')]
    public function getVermittlerId(): ?int
    {
        return $this->vermittler?->getId();
    }

    public function getkundenAdressen(): Collection
    {
        return $this->kundenAdressen;
    }

    public function setkundenAdressen(Collection $kundenAdressen): void
    {
        $this->kundenAdressen = $kundenAdressen;
    }

}
