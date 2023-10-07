<?php

namespace Alks\Gentree\Tree;

class Node
{
    public function __construct(public $itemName = null, public $parent = null, public array $children = [])
    {
        if ($parent === '') {
            $this->parent = null;
        }
    }

    public function addChild(Node $child): void
    {
        $this->children[] = $child;
    }
}
