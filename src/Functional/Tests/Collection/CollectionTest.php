<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Tests\Collection;

use Functional\Collection\Collection;

/**
 * Class CollectionTest
 * @package Tests\Collection
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd() {
        $c = new Collection();
        $c->add(1);
        $c->add(1);

        self::assertCount(2, $c);
    }

    public function testToHashMap() {
        $c = new Collection(['a', 'b', 'c']);
        $map = $c->toHashMap(function ($e) {
            return $e;
        });
        $s = $map->keySet();
        self::assertEquals('a', $s->head());
    }

    public function testHeadTail() {
        $collection = new Collection([1, 2, 3, 4]);
        self::assertEquals(1, $collection->head());
        self::assertCount(3, $collection->tail());
    }

    public function testTake() {
        $collection = new Collection([1, 2, 3, 4]);
        self::assertCount(2, $collection->take(2));
    }

    public function testEach() {
        $i = 0;
        $collection = new Collection(range(1, 4));
        $collection->each(function ($e) use (&$i) {
            $i += $e;
        });
        self::assertEquals(10, $i);
    }

    public function testIsEmpty() {
        $c = new Collection();
        self::assertTrue($c->isEmpty());
    }

    public function testGetIterator() {
        $c = new Collection();
        self::assertInstanceOf(\Iterator::class, $c->getIterator());
    }
} 