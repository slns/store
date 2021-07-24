<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class UploadService
{
    /**
     * @var string
     */
    private $folder;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(string $uploadDir, LoggerInterface $logger)
    {
        $this->folder = $uploadDir;
        $this->logger = $logger;
    }

    public function  upload($files, $targetFolder)
    {
        $this->logger->info('<fg=#c0392b;bg=yellow;options=bold>Log vindo da class ' . __CLASS__ . '</>');

        if (is_array($files)) {
            foreach ($files as $file) {
                $this->move($file, $targetFolder);
            }
        } else {
            $this->move($files, $targetFolder);
        }

    }

    private function move($file, $targetFolder)
    {
        $file->move(
            $this->folder . '/' .  $targetFolder,
            $this->makeNewName($file)
        );
    }

    private function  makeNewName($file): string
    {
        return sha1($file->getClientOriginalName()) . uniqid() . '.' . $file->getClientOriginalExtension();
    }
}