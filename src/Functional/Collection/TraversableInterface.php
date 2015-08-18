<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Collection;

use Functional\Option\Option;

/**
 * Interface TraversableInterface
 * @package Collection
 */
interface TraversableInterface extends \IteratorAggregate
{
    /**
     * Применение функции к каждому элементу в коллекции
     * @param \Closure $f
     * @return static
     */
    public function map($f);

    /**
     * Применение функции к каждому элементу в коллекции
     * @param \Closure $f
     * @return void
     */
    public function each($f);

    /**
     * Фильтрация данных по пользовательской функции
     * @param \Closure $f
     * @return static
     */
    public function filter($f);

    /**
     * @param \Closure $f
     * @return Option
     */
    public function find($f);
} 