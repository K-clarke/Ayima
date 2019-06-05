<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\DomainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AyimaController extends AbstractController
{
    /** @var DomainRepository */
    private $domainRepository;

    /**
     * AyimaController constructor.
     */
    public function __construct(DomainRepository $domainRepository)
    {
        $this->domainRepository = $domainRepository;
    }

    /**
     * @Route("/marketintel/{domain}", name="ayima_domain")
     *
     * @param $domain
     */
    public function domainAction($domain): Response
    {
        $domainEntity = $this->domainRepository->findOneLikeName($domain);
        $scores = [];

        if (null === $domainEntity) {
            $message = sprintf('There Is No Data For The Domain %s', $domain);

            throw new NotFoundHttpException($message);
        }
        foreach ($domainEntity->getScores() as $score) {
            $scores[] = ['date' => $score->getDate()->format('d-m-Y'), 'score' => $score->getScore()];
        }

        return $this->render('ayima/index.html.twig', [
            'domain' => $domainEntity->getName(),
            'scores' => $scores,
        ]);
    }
}
