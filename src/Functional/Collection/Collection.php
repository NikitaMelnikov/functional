<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Collection;

/**
 * Class Collection
 * @package Functional\Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    public function __construct(array $data = []) {
        parent::__construct(array_values($data));
    }

    /**
     * Добавление элемента в коллекцию
     * @param mixed $item
     * @return void
     */
    public function add($item) {
        $this->data[] = $item;
    }

    /**
     * Создание HashMap из коллекции
     * @param \Closure $f
     * @return HashMap
     */
    public function toHashMap($f) {
        return (new HashMap($this->data))->replaceKeys($f);
    }

    /**
     * @param \Closure $f
     * @return HashMap
     */
    public function groupBy(\Closure $f) {
        $acc = [];
        $this->each(function ($item) use ($f, &$acc) {
            $key = $f($item);
            if (!isset($acc[$key])) {
                $acc[$key] = [];
            }
            $acc[$key][] = $item;
        });
        return new HashMap($acc);
    }

    /**
     * @return Collection
     */
    public function dropKeys() {
        return new static(array_values($this->data));
    }
} 