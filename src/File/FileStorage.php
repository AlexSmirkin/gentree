<?php

namespace Alks\Gentree\File;

use Alks\Gentree\Exceptions\InputFileNotFound;
use Alks\Gentree\Exceptions\OutputFileNotFound;
use JsonException;

class FileStorage implements StorageInterface
{
    public const DELIMITER = ';';

    public function __construct(protected $inputFilePath, protected $outputFilePath)
    {
    }

    /**
     * Получение строки из файла
     *
     * @throws InputFileNotFound
     */
    public function getLine(): \Generator
    {
        $firstRow = true;
        $inputFile = fopen($this->inputFilePath, 'rb');
        if($inputFile === false){
            throw new InputFileNotFound($this->inputFilePath);
        }
        while (($line = fgetcsv($inputFile, 0, self::DELIMITER)) !== false) {
            if ($firstRow) {
                $firstRow = false;
                continue;
            }
            yield $line;
        }
        fclose($inputFile);
    }


    /**
     * Сохранение дерева в файл
     *
     * @throws OutputFileNotFound|JsonException
     */
    public function save(array $tree): void
    {
        //количество пробельных отступов как в output.json
        $json = preg_replace_callback('/^ +/m', static function ($m) {
            return str_repeat(' ', strlen($m[0]) / 2);
        }, json_encode($tree, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        if (file_put_contents($this->outputFilePath, $json)) {
            echo "JSON файл успешно сохранен в " . $this->outputFilePath . PHP_EOL;
        } else {
            throw new OutputFileNotFound($this->outputFilePath);
        }
    }
}
