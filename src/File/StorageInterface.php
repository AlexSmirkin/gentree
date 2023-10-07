<?php

namespace Alks\Gentree\File;

interface StorageInterface
{
    public function getLine(): mixed;

    public function save(array $tree): void;
}
