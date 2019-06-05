<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Domain;
use App\Entity\Score;
use App\Repository\DomainRepository;
use App\Repository\ScoreRepository;
use App\Validator\AyimaApiResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MarketIntelManager
{
    private $entityManager;

    /** @var DomainRepository */
    private $domainRepository;
    /** @var ScoreRepository */
    private $scoreRepository;
    /** @var ValidatorInterface */
    private $validator;

    /**
     * MarketIntelManager constructor.
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        DomainRepository $domainRepository,
        ScoreRepository $scoreRepository
    ) {
        $this->entityManager = $entityManager;
        $this->domainRepository = $domainRepository;
        $this->scoreRepository = $scoreRepository;
        $this->validator = $validator;
    }

    public function persistResponse($response)
    {
        $constraintViolations = $this->validator->validate($response, new AyimaApiResponse());
        $marketIntel = json_decode($response, true);

        if (count($constraintViolations) > 0) {
            throw new \Exception('Invalid Response Data');
        }

        $marketInfo = $marketIntel['marketIntel'];

        foreach ($marketInfo as $mark) {
            $domain = $this->domainRepository->findOneBy(['name' => $mark['domain']]);

            if (null === $domain) {
                $domain = new Domain();
                $domain->setName($mark['domain']);
            }

            foreach ($mark['scores'] as $date => $score) {
                $date = new \DateTime($date);
                $scoreEntity = $this->scoreRepository->findOneBy(['date' => $date, 'domain' => $domain]);

                if (null == $scoreEntity) {
                    $scoreEntity = new Score();
                    $scoreEntity->setScore($score);
                    $scoreEntity->setDate($date);
                    $domain->addScore($scoreEntity);
                }
            }

            $this->entityManager->persist($domain);
        }

        $this->entityManager->flush();
    }
}
