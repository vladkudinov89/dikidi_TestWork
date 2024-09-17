<?php

namespace app;

/**
 * File entry
 */
class Entry
{
    private string $fileName;
    private bool $isDir;

    public function __construct($fileName, $isDir)
    {
        $this->fileName = $fileName;
        $this->isDir = $isDir;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function isDir(): bool
    {
        return $this->isDir;
    }
}
