<?php

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Bloc;
use App\Validator\BlocValidator;
use Doctrine\ORM\EntityManagerInterface;

final class BlocProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): mixed {
        if (!$data instanceof Bloc) {
            return $data;
        }

        // 👉 VALIDATION MÉTIER
        BlocValidator::validate($data);

        $this->em->persist($data);
        $this->em->flush();

        return $data;
    }
}
