<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Dto\UserInputDto;
use App\Processor\UserInputDtoProcessor;
use App\Repository\UserRepository;
use App\Validator\PasswordPolicy;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'sec.user')]
#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: '/user'),
        new Get(uriTemplate: '/user/{id}'),
        new Delete(uriTemplate: '/user/{id}'),
        new Put(
            uriTemplate: '/user/{id}'),
        new Post(
            uriTemplate: '/user',
            input: UserInputDto::class,
            processor: UserInputDtoProcessor::class
        )
    ],
    normalizationContext: ['groups' => 'user:read'],
    validationContext: ['groups' => 'Default']
)]
#[ApiResource(
    uriTemplate: '/kunden/{id}/user',
    uriVariables: [
        'id' => new Link(fromClass: Kunde::class, fromProperty: 'user')
    ],
    normalizationContext: ['groups' => 'kunden:read']
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 200, nullable: true)]
    #[SerializedName('username')]
    #[Assert\Email]
    #[Groups('kunden:read')]
    private ?string $email = null;

    #[ORM\Column(length: 60, nullable: true)]
    #[Assert\Length(min: 8)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[PasswordPolicy]
    #[Ignore]
    private ?string $passwd = null;


    #[ORM\Column(nullable: true)]
    #[Groups(['kunden:read'])]
    private ?int $aktiv = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['kunden:read'])]
    private ?\DateTimeInterface $lastLogin = null;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Kunde::class)]
    #[ORM\JoinColumn(name: 'kundenid', referencedColumnName: 'id', nullable: true)]
    private ?Kunde $kunde = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(?string $passwd): self
    {
        $this->passwd = $passwd;

        return $this;
    }

    public function getAktiv(): ?int
    {
        return $this->aktiv;
    }

    public function setAktiv(?int $aktiv): self
    {
        $this->aktiv = $aktiv;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getKunde(): ?Kunde
    {
        return $this->kunde;
    }

    public function setKunde(?Kunde $kunde): void
    {
        $this->kunde = $kunde;
    }

    public function getPassword(): ?string
    {
        return $this->passwd;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials()
    {
        $this->passwd = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->getId();
    }
}
