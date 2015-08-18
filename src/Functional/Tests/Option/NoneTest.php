<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Tests\Option;

use Functional\Exception\NoSuchElementException;
use Functional\Option\None;

/**
 * Class NoneTest
 * @package Tests\Option
 */
class NoneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * При попытке получение значения из None должно валиться исключение
     * @return void
     */
    public function testGet() {
        $this->setExpectedException(NoSuchElementException::class);
        (new None())->get();
    }

    /**
     * Значение None всегда пустое
     * @return void
     */
    public function testIsEmpty() {
        self::assertTrue((new None())->isEmpty());
    }
} 