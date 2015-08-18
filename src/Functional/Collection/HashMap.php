<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Collection;

use Functional\Option\Option;


/**
 * Class HashMap
 * @package Functional\Collection
 */
class HashMap extends AbstractCollection implements \ArrayAccess
{
    /**
     * @inheritdoc
     */
    public function __construct(array $data = []) {
        ksort($data);
        parent::__construct($data);
    }

    /**
     * Применение функции на значение и ключ элемента коллекции
     * для создания нового ключа, по которому будет находится этот элемент
     * @param \Closure $f
     * @return static
     */
    public function replaceKeys($f) {
        $d = [];
        foreach ($this->data as $key => $value) {
            $d[$f($value, $key)] = $value;
        }
        return new static($d);
    }

    /**
     * Возвращает список с ключами коллекции
     * @return Set
     */
    public function keySet() {
        return new Set(array_keys($this->data));
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset) {
        return array_key_exists($offset, $this->data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return Option Can return all value types.
     */
    public function offsetGet($offset) {
        return Option::apply(array_key_exists($offset, $this->data) ? $this->data[$offset] : null);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value) {
        $this->data[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }
} 