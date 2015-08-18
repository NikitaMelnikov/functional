<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Collection;

use Functional\Exception\NoSuchElementException;
use Functional\Option\None;
use Traversable;
use Functional\Option\Option;

/**
 * Class AbstractCollection
 * @package Functional\Collection
 */
abstract class AbstractCollection implements TraversableInterface, \Countable
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param array $data
     * @return static
     * @throws \InvalidArgumentException
     */
    public static function apply($data = []) {
        if (!is_array($data) && !($data instanceof Traversable)) {
            throw new \InvalidArgumentException('Cannot init Collection with ' . gettype($data));
        }
        return new static($data);
    }

    /**
     * @param array $data
     */
    public function __construct(array $data = []) {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->data;
    }

    /**
     * Пустая ли коллекция
     * @return boolean
     */
    public function isEmpty() {
        return $this->count() === 0;
    }

    /**
     * Получение первого элемента в коллекции
     * @return mixed
     * @throws NoSuchElementException
     */
    public function head() {
        $h = reset($this->data);
        if ($h !== false) {
            return $h;
        } else {
            throw new NoSuchElementException('EmptyCollection.head');
        }
    }

    /**
     * Получение первого элемента в списке в качестве опции
     * @return Option
     */
    public function headOption() {
        try {
            return Option::apply($this->head());
        } catch (NoSuchElementException $e) {
            return new None();
        }
    }

    /**
     * Получение хвоста коллекции
     * @return static
     */
    public function tail() {
        return new static(array_slice($this->data, 1));
    }

    /**
     * Получение N-количества элементов в коллекции
     * @param integer $n
     * @return static
     */
    public function take($n) {
        return new static(array_slice($this->data, 0, $n));
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count() {
        return count($this->data);
    }

    /**
     * Итеративно уменьшает массив к единственному значению, используя callback-функцию
     * @see array_reduce
     * @param \Closure $f
     * @param mixed $init Изначальное значение
     * @return mixed
     */
    public function foldLeft($f, $init) {
        return array_reduce($this->data, $f, $init);
    }

    /**
     * Итеративно уменьшает массив к единственному значению, используя callback-функцию
     * @see array_reduce
     * @param \Closure $f
     * @return mixed
     */
    public function reduce($f) {
        return $this->foldLeft($f, null);
    }

    /**
     * Применение функции к каждому элементу в коллекции
     * @param \Closure $f
     * @return static
     */
    public function map($f) {
        return new static(array_map($f, $this->data));
    }

    /**
     * Применение функции к каждому элементу в коллекции
     * @param \Closure $f
     * @return void
     */
    public function each($f) {
        $d = $this->data;
        array_walk($d, $f);
    }

    /**
     * Фильтрация данных по пользовательской функции
     * @param \Closure $f
     * @return static
     */
    public function filter($f) {
        return new static(array_filter($this->data, $f));
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator() {
        return new \ArrayIterator($this->data);
    }

    /**
     * @param \Closure $f
     * @return Option
     */
    public function find($f) {
        /**@var \Iterator $iterator */
        $iterator = $this->getIterator();
        while ($iterator->valid()) {
            if ($f($iterator->current())) {
                return Option::apply($iterator->current());
            }
            $iterator->next();
        }
        return new None();
    }

    /**
     * @param \Closure $f
     * @return static
     */
    public function sort($f) {
        $data = $this->data;
        uasort($data, $f);
        return static::apply($data);
    }

    /**
     * Создание строки из коллекции с разделителем
     * @param string $delimiter
     * @return string
     */
    public function mkString($delimiter = '') {
        return implode($delimiter, $this->data);
    }

    /**
     * @return number
     */
    public function sum() {
        return array_sum($this->data);
    }

    /**
     * @return static
     */
    public function unique() {
        return new static(array_unique($this->data));
    }

    /**
     * @return static
     */
    public function flatten() {
        $acc = [];

        foreach ($this->data as $list) {
            foreach ($list as $item) {
                $acc[] = $item;
            }
        }

        return new static($acc);
    }
} 
