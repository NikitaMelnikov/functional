<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Option;

/**
 * Class Some
 * @package Option
 */
class Some extends Option
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value) {
        $this->value = $value;
    }

    /**
     * Returns the option's value.
     * @return mixed
     */
    public function get() {
        return $this->value;
    }

    /**
     * Returns true if the option is None, false otherwise.
     * @return boolean
     */
    public function isEmpty() {
        return false;
    }
}