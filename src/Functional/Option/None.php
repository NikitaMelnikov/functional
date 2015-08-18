<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Option;

use Functional\Exception\NoSuchElementException;

/**
 * Class None
 * @package Option
 */
class None extends Option
{
    /**
     * Returns the option's value.
     * @return mixed
     * @throws NoSuchElementException
     */
    public function get() {
        throw new NoSuchElementException('None.get');
    }

    /**
     * Returns true if the option is None, false otherwise.
     * @return boolean
     */
    public function isEmpty() {
        return true;
    }
} 