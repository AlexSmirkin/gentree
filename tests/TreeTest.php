<?php

declare(strict_types=1);

use Alks\Gentree\File\FileStorage;
use Alks\Gentree\Tree\Node;
use Alks\Gentree\Tree\Tree;
use PHPUnit\Framework\TestCase;

final class TreeTest extends TestCase
{
    public function testParent(): void
    {
        $tree = new Tree(new FileStorage('', ''));

        $tree->rootNode->addChild(new Node('node1'));
        $tree->add('node2', 'node1');

        $tree->find('node2', found: $found);

        $this->assertEquals('node1', $found->parent);
    }

    public function testChild(): void
    {
        $tree = new Tree(new FileStorage('', ''));

        $tree->rootNode->addChild(new Node('node1'));
        $tree->add('node2', 'node1');
        $tree->add('node3', 'node1');

        $tree->find('node1', found: $found);

        $this->assertCount(2, $found->children);
    }
}
