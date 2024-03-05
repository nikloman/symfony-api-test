<?php

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Kunde;
use App\Entity\VermittlerUser;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class KundenProcessor implements ProcessorInterface
{
    private Security $security;
    private UserInterface $user;
    private ProcessorInterface $persistProcessor;

    public function __construct(
        Security $security,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')] ProcessorInterface $persistProcessor)
    {
        $this->security = $security;
        $this->user = $this->security->getUser();
        $this->persistProcessor = $persistProcessor;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (!$operation instanceof Post) {
            return;
        }

        if (!$this->user instanceof VermittlerUser) {
            return;
        }

        if (!$data instanceof Kunde) {
            return;
        }

        $data->setVermittler($this->user->getVermittler());
        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}