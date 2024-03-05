<?php

namespace App\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\KundenAdresse;
use App\Repository\KundenAdressenRepository;
use App\Repository\KundenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\SecurityBundle\Security;

class AdressDetailsProvider implements ProviderInterface
{

    private KundenAdressenRepository $kundenAdressenRepository;
    private Security $security;

    public function __construct(KundenAdressenRepository $kundenAdressenRepository, Security $security)
    {
        $this->kundenAdressenRepository = $kundenAdressenRepository;
        $this->security = $security;
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $adresseId = $uriVariables['adresseId'];
        $id = $uriVariables['id'];
        $kundenAdressen = new ArrayCollection($this->kundenAdressenRepository->findBy(['kunde' => $id, 'adresse' => $adresseId]));
        $details = $kundenAdressen
            ->filter(fn(KundenAdresse $kundenAdresse) => $this->security->getUser()?->getUserIdentifier() === $kundenAdresse->getKunde()?->getVermittler()?->getVermittlerUser()?->getUserIdentifier())
            ->map(fn(KundenAdresse $kundenAdresse) => $kundenAdresse->getAdresse());
        return $details;
    }
}