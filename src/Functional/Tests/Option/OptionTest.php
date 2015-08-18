<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Tests\Option;

use Functional\Option\None;
use Functional\Option\Option;
use Functional\Option\Some;

/**
 * Class OptionTest
 * @package Tests\Option
 */
class OptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Тестирование получение либо значения, либо альтернативного значения
     *
     * @dataProvider getOrElseDataProvider
     *
     * @param Option $option
     * @param \Closure|integer $else
     * @param integer $result
     * @return void
     */
    public function testGetOrElse(Option $option, $else, $result) {
        self::assertEquals($result, $option->getOrElse($else));
    }

    /**
     * Проверка сопостовления с образцом
     * @return void
     */
    public function testMatch() {
        $o1 = new None();
        $o2 = new Some(1);

        $r = 0;

        $o1->match(null, function () use (&$r) {
            $r++;
        });
        $o2->match(function () use (&$r) {
            $r++;
        });

        self::assertEquals(2, $r);
    }

    /**
     * В случае, если значение отсутствует, то вернуться должен NULL
     * @return void
     */
    public function testOrNull() {
        self::assertNull((new None())->orNull());
        self::assertNotNull((new Some(123))->orNull());
    }

    /**
     * Проверка маппинга значения, если значение None, то оно и должно вернуться
     * @return void
     */
    public function testMap() {
        self::assertEquals(2, Option::apply(1)->map(function ($value) {
            return $value * 2;
        })->get());
        self::assertInstanceOf(None::class, Option::apply(null)->map(function () {
            return 123;
        }));
    }

    /**
     * В случае если присутствует значение, то должна выполниться вторая функция, иначе первая
     * @return void
     */
    public function testFold() {
        $none = false;
        $some = false;

        Option::apply(null)->fold(function () use (&$none) {
            $none = true;
        }, function () {
        });
        Option::apply(1)->fold(function () {
        }, function () use (&$some) {
            $some = true;
        });

        self::assertTrue($none);
        self::assertTrue($some);
    }

    /**
     * Тестирование возвращания нужного типа из маппинга
     * @return void
     */
    public function testFlatMap() {
        $value = 123;
        self::assertEquals($value, Option::apply($value)->flatMap(function ($v) {
            return $v;
        }));
    }

    /**
     * Тест применения фильтра к значению
     * @return void
     */
    public function testFilter() {
        self::assertInstanceOf(Some::class, Option::apply(1)->filter(function ($v) {
            return $v > 0;
        }));
        self::assertInstanceOf(None::class, Option::apply(1)->filter(function ($v) {
            return $v < 0;
        }));

        self::assertInstanceOf(Some::class, Option::apply(1)->filterNot(function ($v) {
            return $v < 0;
        }));
        self::assertInstanceOf(None::class, Option::apply(1)->filterNot(function ($v) {
            return $v > 0;
        }));
    }

    /**
     * Проверка конкретного значения, содержащегося в опции
     * @return void
     */
    public function testContains() {
        self::assertTrue(Option::apply(1)->contains(1));
        self::assertFalse(Option::apply(2)->contains(1));
        self::assertFalse(Option::apply(null)->contains(1));
    }

    /**
     * ПРименение функции к каждому элементу, без ожидание возвращения результата
     * @return void
     */
    public function testEach() {
        $value = 1;
        Option::apply(3)->each(function ($v) use (&$value) {
            $value *= $v;
        });
        self::assertEquals(3, $value);
    }

    /**
     * Тест получения альтернативного значения, если значение отсутствует
     * @return void
     */
    public function testOrElse() {
        self::assertEquals(1, Option::apply(null)->orElse(1));
    }

    /**
     * При конкретном значении итератор возвращается с 1 элементом, иначе возвращается пустой итератор
     * @return void
     */
    public function testGetIterator() {
        self::assertEquals(0, Option::apply(null)->iterator()->count());
        self::assertEquals(1, Option::apply(1)->iterator()->count());
    }

    /**
     * Провайдер данных для теста getOrElse
     * @return array
     */
    public function getOrElseDataProvider() {
        return [
            ['option' => Option::apply(1), 'else' => 2, 'result' => 1],
            ['option' => Option::apply(null), 'else' => 2, 'result' => 2],
            [
                'option' => Option::apply(null),
                'else' => function () {
                    return 3;
                },
                'result' => 3,
            ],
        ];
    }
} 