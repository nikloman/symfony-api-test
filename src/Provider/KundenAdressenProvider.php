<?php

namespace App\Provider;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\KundenRepository;

class KundenAdressenProvider implements ProviderInterface
{
    private KundenRepository $kundenRepository;

    public function __construct(KundenRepository $kundenRepository)
    {
        $this->kundenRepository = $kundenRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->kundenRepository->find($uriVariables['id'])->getAdressen();
    }
}