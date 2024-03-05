<?php

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\AdressenInputDto;
use App\Entity\Adresse;
use App\Entity\Kunde;
use App\Entity\KundenAdresse;
use App\Entity\VermittlerUser;
use App\Repository\BundeslandRepository;
use App\Repository\KundenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Core\User\UserInterface;

class AdressenProcessor implements ProcessorInterface
{

    private KundenRepository $kundenRepository;
    private BundeslandRepository $bundeslandRepository;
    private EntityManagerInterface $entityManager;
    private ProcessorInterface $persistProcessor;

    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')] ProcessorInterface $persistProcessor,
        KundenRepository $kundenRepository,
        BundeslandRepository $bundeslandRepository,
        EntityManagerInterface $entityManager,
    )
    {
        $this->persistProcessor = $persistProcessor;
        $this->kundenRepository = $kundenRepository;
        $this->bundeslandRepository = $bundeslandRepository;
        $this->entityManager = $entityManager;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (!$operation instanceof Post) {
            return;
        }

        if (!$data instanceof AdressenInputDto) {
            return;
        }

        $adresse = new Adresse();
        $adresse = $this->mapDtoToEntity($data, $adresse);
        $adresse = $this->persistProcessor->process($adresse, $operation, $uriVariables, $context);

        $kundenAdresse = new KundenAdresse();
        $kunde = $this->kundenRepository->findOneBy(['id' => $data->kundenId]);
        $kundenAdresse->setKunde($kunde);
        $kundenAdresse->setAdresse($adresse);
        $this->entityManager->persist($kundenAdresse);
        $this->entityManager->flush();
        return $adresse;
    }

    private function mapDtoToEntity(AdressenInputDto $dto, Adresse $adresse): Adresse
    {
        $bundesland = $this->bundeslandRepository->find($dto->bundeslandKuerzel);
        $adresse->setBundesland($bundesland);
        $adresse->setOrt($dto->ort);
        $adresse->setStrasse($dto->strasse);
        $adresse->setPlz($dto->plz);
        return $adresse;
    }
}