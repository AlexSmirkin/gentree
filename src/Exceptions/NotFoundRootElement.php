<?php

namespace Alks\Gentree\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class NotFoundRootElement extends Exception
{
    #[Pure] public function __construct(public string $parentItemName)
    {
        parent::__construct();
    }

    public function __toString(): string
    {
        return 'Не найден родительский элемент для: ' . $this->parentItemName;
    }
}
