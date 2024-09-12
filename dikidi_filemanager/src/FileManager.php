<?php

namespace app;

use Exception;

include_once 'Entry.php';

/**
 * File manager
 * @property array $allowedFiles
 * @property string $root
 * @property string $path
 */
class FileManager
{
    private array $allowedFiles;

    private string $root;

    private string $path = '/';

    /**
     * @throws Exception
     */
    public function __construct(string $root = ".", array $allowedFiles = ['png', 'jpg'])
    {
        if (!is_dir($root)) {
            throw new Exception("$root должен быть директорией");
        }
        $this->root = realpath($root);
        $this->allowedFiles = $allowedFiles;
    }

    /**
     * Get current path
     *
     * @return string
     */
    public function pwd(): string
    {
        return $this->path;
    }

    /**
     * List files
     *
     * @return array
     * @throws Exception
     */
    public function ls(): array
    {
        if (!is_dir($this->getFullPath())) {
            throw new Exception($this->getFullPath($this->path) . ' не является директорией');
        }

        $directory = dir($this->getFullPath());

        $entries = [];

        while (($entry = $directory->read()) !== false) {
            if ($this->skip($entry)) {
                continue;
            }
            $entries[] = new Entry($entry, is_dir($this->getFullPath($entry)));
        }
        $directory->close();
        return $entries;
    }

    /**
     * @param string $path
     * @return void
     * @throws Exception
     */
    public function cd(string $path): void
    {
        $this->path = $this->getNewPath($path);
    }

    /**
     * @param string|null $path
     * @return string
     */
    public function getFullPath(string $path = null): string
    {
        return realpath($this->root . DIRECTORY_SEPARATOR . $this->path . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * @param string $path
     * @return string
     * @throws Exception
     */
    private function getNewPath(string $path): string
    {
        $newFullPath = $this->getFullPath($path);

        if (!file_exists($newFullPath)) {
            throw new Exception($newFullPath . ' не существует');
        } elseif (!is_dir($newFullPath)) {
            throw new Exception($newFullPath . ' не является директорией');
        }

        $rootLength = mb_strlen($this->root);

        if (
            $rootLength > mb_strlen($newFullPath) ||
            mb_substr($newFullPath, 0, $rootLength) !== $this->root
        ) {
            throw new Exception('Неверно указан путь ' . $path);
        }

        return DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @param $path
     * @return bool
     */
    private function skip($path): bool
    {
        if ($path === '.') {
            return true;
        }

        $fullPath = $this->getFullPath($path);
        $pathParts = pathinfo($fullPath);

        if ($path === '..' && $this->getFullPath() === $this->root) {
            return true;
        }

        if (
            is_dir($fullPath) === false
            && !in_array($pathParts['extension'], $this->allowedFiles)
        ) {
            return true;
        }
        return false;
    }
}
