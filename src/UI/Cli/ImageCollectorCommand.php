<?php

declare(strict_types=1);

namespace App\UI\Cli;

use App\Domain\DomainException;
use App\Domain\Service\ImageDownloader;
use App\Infrastructure\InfrastructureException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImageCollectorCommand extends Command
{
    private ImageDownloader $imageDownloader;
    private LoggerInterface $logger;

    protected static $defaultName = 'img:download';

    public function __construct(ImageDownloader $imageDownloader, LoggerInterface $logger)
    {
        $this->imageDownloader = $imageDownloader;
        $this->logger = $logger;
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Download of the images has started!');

        try {
            $this->imageDownloader->download();
        } catch (DomainException | InfrastructureException $e) {
            $this->logger->error($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}