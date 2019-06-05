<?php

declare(strict_types=1);

namespace App\Command;

use App\Client\AyimaClient;
use App\Service\MarketIntelManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MarketIntelPersistCommand extends Command
{
    public const MAX_REQUEST_ATTEMPTS = 3;

    protected static $defaultName = 'ayima:marketintel:persist';
    /** @var AyimaClient */
    private $ayimaClient;
    /** @var MarketIntelManager */
    private $apiManager;

    /**
     * MarketIntelPersistCommand constructor.
     */
    public function __construct(AyimaClient $ayimaClient, MarketIntelManager $apiManager)
    {
        parent::__construct();
        $this->ayimaClient = $ayimaClient;
        $this->apiManager = $apiManager;
    }

    protected function configure(): void
    {
        $this->setDescription('This Command Gets Data From The Ayima API And Persists It To The Database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        for ($i = 0; $i < self::MAX_REQUEST_ATTEMPTS; ++$i) {
            $response = $this->ayimaClient->getScores();

            if (null !== $response) {
                continue;
            }
        }

        if (null === $response) {
            $io->error('Reached max api tries');
        } else {
            $this->apiManager->persistResponse($response);
            $io = new SymfonyStyle($input, $output);
            $io->success('data has successfully been persisted');
        }
    }
}
