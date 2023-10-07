<?php

namespace Alks\Gentree\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class OutputFileNotFound extends Exception
{
    #[Pure] public function __construct(public string $inputFilePath)
    {
        parent::__construct();
    }

    public function __toString(): string
    {
        return 'Ошибка сохранения файла: ' . $this->inputFilePath;
    }
}
