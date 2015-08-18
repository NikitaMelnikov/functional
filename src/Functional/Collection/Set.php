<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Collection;

/**
 * Class Set
 * @package Functional\Collection
 * Для определения уникальности для объектов необходимо использовать Object::__toString()
 */
class Set extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    public function __construct(array $data = []) {
        parent::__construct(array_values(array_unique($data)));
    }

    /**
     * @param mixed $e
     * @return void
     */
    public function add($e) {
        $this->data[] = $e;
        $this->data = array_unique($this->data, SORT_REGULAR);
    }
}