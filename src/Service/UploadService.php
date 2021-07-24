<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class UploadService
{
    private $folder;

    private $logger;

    public function __construct(string $uploadDir, LoggerInterface $logger)
    {
        $this->folder = $uploadDir;
        $this->logger = $logger;
    }

    public function  upload(): string
    {
        $this->logger->info('<fg=#c0392b;bg=yellow;options=bold>Log vindo da class ' . __CLASS__ . '</>');
        return $this->folder;
    }
}