<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Option;

/**
 * Class Option
 * @package Option
 * @link https://github.com/scala/scala
 */
abstract class Option
{
    /**
     * Returns the option's value.
     * @return mixed
     */
    abstract public function get();

    /**
     * Returns true if the option is None, false otherwise.
     * @return boolean
     */
    abstract public function isEmpty();

    /**
     * @param mixed $value
     * @param boolean $useEmpty Использовать ли проверку на пустоту (empty())
     * @return Option
     */
    public static function apply($value = null, $useEmpty = false) {
        if ($value === null || ($useEmpty && empty($value))) {
            return new None();
        } else {
            return new Some($value);
        }
    }

    /**
     * Выполнение функций в зависимости от типа опции
     * @param \Closure|null $some Функция в качестве аргумента может принимать исходный объект Some
     * @param \Closure|null $none
     * @return void
     */
    public function match($some = null, $none = null) {
        if ($this instanceof Some && $some !== null) {
            $some($this->get());
        } elseif ($none !== null) {
            $none();
        }
    }

    /**
     * Returns the option's value if the option is nonempty, otherwise
     * @param \Closure|mixed $default
     * @return mixed
     */
    public function getOrElse($default) {
        if ($this->isEmpty()) {
            return is_callable($default) ? $default() : $default;
        } else {
            return $this->get();
        }
    }

    /**
     * Returns the option's value if it is nonempty,
     * or `null` if it is empty.
     * @return mixed|null
     */
    public function orNull() {
        return $this->getOrElse(null);
    }

    /**
     * Returns a $some containing the result of applying $f to this $option's
     * value if this $option is nonempty.
     * Otherwise return $none.
     * @note This is similar to `flatMap` except here,
     * $f does not need to wrap its result in an $option.
     * @param \Closure $f
     * @return Option
     */
    public function map($f) {
        return $this->isEmpty() ? new None() : Option::apply($f($this->get()));
    }

    /**
     * Returns the result of applying $f to this $option's
     * value if the $option is nonempty.  Otherwise, evaluates
     * expression `ifEmpty`.
     * @note This is equivalent to `$option map f getOrElse ifEmpty`.
     * @param \Closure $ifEmpty
     * @param \Closure $f
     * @return mixed
     */
    public function fold($ifEmpty, $f) {
        return $this->isEmpty() ? $ifEmpty() : $f($this->get());
    }

    /**
     * Returns the result of applying $f to this $option's value if
     * this $option is nonempty.
     * Returns $none if this $option is empty.
     * Slightly different from `map` in that $f is expected to
     * return an $option (which could be $none).
     * @param \Closure $f
     * @return None
     */
    public function flatMap($f) {
        return $this->isEmpty() ? new None() : $f($this->get());
    }

    /**
     * Returns this $option if it is nonempty '''and''' applying the predicate $p to
     * this $option's value returns true. Otherwise, return $none.
     * @param \Closure $p the predicate used for testing.
     * @return Option
     */
    public function filter($p) {
        return $this->isEmpty() || $p($this->get()) ? $this : new None();
    }

    /**
     * Returns this $option if it is nonempty '''and''' applying the predicate $p to
     * this $option's value returns false. Otherwise, return $none.
     * @param \Closure $p
     * @return Option
     */
    public function filterNot($p) {
        return $this->isEmpty() || !$p($this->get()) ? $this : new None();
    }

    /**
     * Tests whether the option contains a given value as an element.
     * @param mixed $elem the element to test.
     * @return boolean
     */
    public function contains($elem) {
        return !$this->isEmpty() && $this->get() === $elem;
    }

    /**
     * Apply the given procedure $f to the option's value,
     * if it is nonempty. Otherwise, do nothing.
     * @param \Closure $f
     * @return void
     */
    public function each($f) {
        if (!$this->isEmpty()) {
            $f($this->get());
        }
    }

    /**
     * Returns this $option if it is nonempty,
     * otherwise return the result of evaluating `alternative`.
     * @param Option|mixed $alternative
     * @return Option
     */
    public function orElse($alternative) {
        return $this->isEmpty() ? $alternative : $this;
    }

    /**
     * Returns a singleton iterator returning the $option's value
     * if it is nonempty, or an empty iterator if the option is empty.
     * @return \ArrayIterator
     */
    public function iterator() {
        return $this->isEmpty() ? new \ArrayIterator([]) : new \ArrayIterator([$this->get()]);
    }
}