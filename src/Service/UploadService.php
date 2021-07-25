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
            $newFiles = [];
            foreach ($files as $file) {
                $newFiles[] =  $this->move($file, $targetFolder);
            }
            return $newFiles;
        } else {
           return $this->move($files, $targetFolder);
        }

    }

    private function move($file, $targetFolder)
    {
        $newFileName = $this->makeNewName($file);
        $file->move(
            $this->folder . '/' .  $targetFolder,
            $newFileName
        );
        return $newFileName;
    }

    private function  makeNewName($file): string
    {
        return sha1($file->getClientOriginalName()) . uniqid() . '.' . $file->getClientOriginalExtension();
    }
}