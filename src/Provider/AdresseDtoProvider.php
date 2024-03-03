<?php

namespace App\Provider;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProviderInterface;
use App\Dto\AdresseDto;
use App\Repository\AdresseRepository;
use App\Repository\KundeAdresseRepository;
use App\Repository\TblKundenRepository;
use Doctrine\ORM\EntityManagerInterface;

class AdresseDtoProvider implements ProviderInterface
{
    private TblKundenRepository $tblKundenRepository;
    private EntityManagerInterface $entityManager;
    private AdresseRepository $adresseRepository;

    public function __construct(TblKundenRepository $tblKundenRepository, EntityManagerInterface $entityManager, AdresseRepository $adresseRepository)
    {
        $this->tblKundenRepository = $tblKundenRepository;
        $this->entityManager = $entityManager;
        $this->adresseRepository = $adresseRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof GetCollection) {
            $kundenForVermittler = $this->tblKundenRepository->findAll();
            $adressen = [];
            foreach ($kundenForVermittler as $kunde) {
                $adressen[] = [...$kunde->getAdressen()->toArray()];
            }
            return $adressen;
        }
        if ($operation instanceof Get) {
            if (isset($uriVariables['adresseId'])) {
                return $this->adresseRepository->find($uriVariables['adresseId']);
            }
        }

        return [];
    }
}