<?php

namespace App\Provider;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProviderInterface;
use App\Dto\AdresseDto;
use App\Repository\AdressenRepository;
use App\Repository\KundenAdressenRepository;
use App\Repository\KundenRepository;
use Doctrine\ORM\EntityManagerInterface;

class AdressenProvider implements ProviderInterface
{
    private KundenRepository $kundenRepository;
    private EntityManagerInterface $entityManager;
    private AdressenRepository $adressenRepository;

    public function __construct(KundenRepository $kundenRepository, EntityManagerInterface $entityManager, AdressenRepository $adressenRepository)
    {
        $this->kundenRepository = $kundenRepository;
        $this->entityManager = $entityManager;
        $this->adressenRepository = $adressenRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof GetCollection) {
            $kundenForVermittler = $this->kundenRepository->findAll();
            $adressen = [];
            foreach ($kundenForVermittler as $kunde) {
                $adressen[] = [...$kunde->getAdressen()];
            }
            return $adressen;
        }
        if ($operation instanceof Get) {
            if (isset($uriVariables['adresseId'])) {
                return $this->adressenRepository->find($uriVariables['adresseId']);
            }
        }

        return [];
    }
}