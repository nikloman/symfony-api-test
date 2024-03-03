<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use App\Dto\AdresseDto;
use App\Provider\AdresseDtoProvider;
use App\Repository\AdresseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
#[ORM\Table(name: 'std.adresse')]
#[ApiResource(
    operations: [
        new GetCollection('/adressen', normalizationContext: ['groups' => 'adressen:read'], provider: AdresseDtoProvider::class),
        new Get('/adressen/{adresseId}', normalizationContext: ['groups' => 'adressen:read'], provider: AdresseDtoProvider::class),
        new Put('/adressen/{adresseId}', normalizationContext: ['groups' => 'adressen:read']),
        new Delete('/adressen/{adresseId}')
    ]
)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'adresse_id')]
    #[ApiProperty(identifier: true)]
    #[Groups(['adressen:read'])]
    private ?int $adresseId = null;

    #[ORM\OneToOne(mappedBy: 'adresse', targetEntity: KundeAdresse::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id', nullable: true)]
    private ?KundeAdresse $kundeAdresse = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['adressen:read', 'kunden:read'])]
    private ?string $strasse = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups(['adressen:read', 'kunden:read'])]
    private ?string $plz = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['adressen:read', 'kunden:read'])]
    private ?string $ort = null;

    #[ORM\OneToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'bundesland', referencedColumnName: 'kuerzel')]
    private ?Bundesland $bundesland = null;

    public function getAdresseId(): ?int
    {
        return $this->adresseId;
    }

    public function setAdresseId(int $adresseId): self
    {
        $this->adresseId = $adresseId;

        return $this;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(?string $strasse): self
    {
        $this->strasse = $strasse;

        return $this;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(?string $plz): self
    {
        $this->plz = $plz;

        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(?string $ort): self
    {
        $this->ort = $ort;

        return $this;
    }

    public function getBundesland(): ?Bundesland
    {
        return $this->bundesland;
    }

    #[Groups(['adressen:read', 'kunden:read'])]
    #[SerializedName('bundesland')]
    public function getBundesLandKuerzel(): ?string
    {
        return $this->bundesland?->getKuerzel();
    }

    public function setBundesland(?Bundesland $bundesland): self
    {
        $this->bundesland = $bundesland;

        return $this;
    }

    public function getKundeAdresse(): ?KundeAdresse
    {
        return $this->kundeAdresse;
    }

    public function setKundeAdresse(?KundeAdresse $kundeAdresse): void
    {
        $this->kundeAdresse = $kundeAdresse;
    }

    #[Groups(['kunden:read'])]
    #[SerializedName('details')]
    public function getDetails(): array
    {
        try {
            $kundenAddresse = $this->getKundeAdresse();
            return [
                'geschaeftlich' => $this->getKundeAdresse()?->isGeschaeftlich(),
                'rechnungsaddresse' => $this->getKundeAdresse()?->isRechnungsadresse()
            ];
        } catch (EntityNotFoundException $e) {
            return [
                'geschaeftlich' => null,
                'rechnungsaddresse' => null
            ];
        }

    }
}
