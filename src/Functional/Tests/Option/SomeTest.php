<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Tests\Option;

use Functional\Option\Some;

/**
 * Class SomeTest
 * @package Tests\Option
 */
class SomeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Проверка получение именного того типа, который мы ожидаем
     * @return void
     */
    public function testGet() {
        $value = 123;
        self::assertEquals($value, (new Some($value))->get());
    }

    /**
     * Значение Some всегда не пустое
     * @return void
     */
    public function testIsEmpty() {
        self::assertFalse((new Some(123))->isEmpty());
    }
} 