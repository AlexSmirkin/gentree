<?php

namespace Alks\Gentree\Tree;

use Alks\Gentree\Exceptions\NotFoundRootElement;
use Alks\Gentree\File\StorageInterface;
use JetBrains\PhpStorm\Pure;

class Tree
{
    public Node $rootNode;
    public array $relations;

    #[Pure]
    public function __construct(protected StorageInterface $storage)
    {
        $this->rootNode = new Node();
    }

    //Обработка файла
    public function complete(): void
    {
        $this->loadTree();
        $this->addRelation();
        $this->save();
    }

    /**
     * Добавление элемента в дерево
     *
     * @throws NotFoundRootElement
     */
    public function add(string $itemName, string $parentItemName): void
    {
        $found = false;
        $this->find($parentItemName, found: $found);
        if ($found) {
            $found->addChild(new Node($itemName, $parentItemName));
        } else {
            throw new NotFoundRootElement($parentItemName);
        }
    }

    //Добавление поддерева в дерево
    public function addNode(string $itemName, Node $node): void
    {
        $this->find($itemName, found: $found);
        if ($found) {
            foreach ($node->children as $child) {
                $copy = clone $child;
                $copy->parent = $found->itemName;
                $found->addChild($copy);
            }
        }
    }

    //Поиск элемента $itemName в дереве или поддереве $node
    public function find(string $itemName, Node $node = null, Node|bool &$found = null): void
    {
        $node = $node ?? $this->rootNode;

        if ($node->itemName === $itemName) {
            $found = $node;
        }

        foreach ($node->children as $child) {
            $this->find($itemName, $child, $found);
        }
    }

    //Заполнение дерева и массива связей relations
    public function loadTree(): void
    {
        foreach ($this->storage->getLine() as $row) {
            if ($row[2] === '') {
                $node = new Node($row[0], $row[2]);
                $this->rootNode->addChild($node);
            } else {
                $this->add($row[0], $row[2]);
                //если есть связь в колонке 'Relation', то сохраняем в массив
                if ($row[3]) {
                    $this->relations[$row[0]] = $row[3];
                }
            }
        }
    }

    //Добавление поддеревьев с полем Relation
    public function addRelation(): void
    {
        foreach ($this->relations as $itemName => $relation) {
            $this->find($relation, found: $found);
            $this->addNode($itemName, $found);
        }
    }

    //Сохранение дерева в хранилище
    public function save(): void
    {
        $tree = (array)$this;
        unset($tree['hasRelation']);

        $this->storage->save($tree['rootNode']->children);
    }
}
