<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Tests\Option;

use Functional\Option\Option;
use Functional\Option\Some;

/**
 * Class OptionApplyTest
 * @package Tests\Option
 */
class OptionApplyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Проверка создания конкретного типа данных из Option::apply()
     *
     * @dataProvider valuesDataProvider
     *
     * @param string $class
     * @param mixed $value
     * @param boolean $useEmpty
     * @return void
     */
    public function testApply($class, $value, $useEmpty) {
        self::assertInstanceOf($class, Option::apply($value, $useEmpty));
    }

    /**
     * @return array
     */
    public function valuesDataProvider() {
        return [
            ['class' => Some::class, 'value' => true, 'useEmpty' => false],
            ['class' => Some::class, 'value' => true, 'useEmpty' => true],
            ['class' => Option::class, 'value' => null, 'useEmpty' => false],
            ['class' => Option::class, 'value' => false, 'useEmpty' => true],
        ];
    }
} 