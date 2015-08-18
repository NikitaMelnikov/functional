<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Tests\Collection;

use Functional\Collection\Set;


/**
 * Class SetTest
 * @package Tests\Collection
 */
class SetTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct() {
        $origin = [1, 2, 3, 1];
        self::assertCount(4, $origin);

        $s = new Set($origin);
        self::assertCount(3, $s);
    }
} 