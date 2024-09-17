<?php

use app\FileManager;
use app\Router;

chdir(__DIR__);

include_once 'autoloader.php';

try {
    $router = Router::getInstance($_GET['r'] ?? '');

    $fileManager = new FileManager('storage');
    $fileManager->cd(Router::getPath());

    echo $fileManager->pwd() . '<br>' . PHP_EOL;

    foreach ($fileManager->ls() as &$entry) {
        if ($entry->isDir()) {
            echo '<a href="?r=' . $router::to($entry->getFileName()) . '">' . $entry->getFileName() . '</a><br>' . PHP_EOL;
        } else {
            echo $entry->getFileName() . '<br>' . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
