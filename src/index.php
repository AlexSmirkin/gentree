<?php

use Alks\Gentree\File\FileStorage;
use Alks\Gentree\Tree\Tree;

require_once __DIR__ . '/../vendor/autoload.php';

try {

    $inputFileName = __DIR__ . '/../files/input/input.csv';
    $outputFileName = __DIR__ . '/../files/output/output.json';
    $masterFileName = __DIR__ . '/../files/master/output.json';

    $tree = new Tree(new FileStorage($inputFileName, $outputFileName));

    $tree->complete();

} catch (Exception $e) {
    echo $e . PHP_EOL;
}

if (filesize($masterFileName) === filesize($outputFileName)
    && md5_file($masterFileName) === md5_file($outputFileName)
) {
    echo PHP_EOL . "Файлы идентичны." . PHP_EOL;
} else {
    echo PHP_EOL . "Файлы не идентичны!" . PHP_EOL;
}




