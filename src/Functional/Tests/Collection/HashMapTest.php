<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

namespace Functional\Tests\Collection;

use Functional\Collection\HashMap;
use Functional\Option\None;
use Functional\Option\Some;
use Functional\Collection\Set;

/**
 * Class HashMapTest
 * @package Tests\Collection
 */
class HashMapTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayAccess() {
        $hashMap = new HashMap(['a' => 1, 'b' => 2]);
        self::assertCount(2, $hashMap);

        $hashMap['c'] = 3;
        self::assertCount(3, $hashMap);

        unset($hashMap['a']);
        self::assertCount(2, $hashMap);

        self::assertInstanceOf(Some::class, $hashMap['c']);
        self::assertInstanceOf(None::class, $hashMap['d']);
    }

    public function testMap() {
        $m = new HashMap(['a' => 1, 'b' => 2]);
        $newMap = $m->map(function ($e) {
            return $e * 2;
        });

        self::assertCount(2, $newMap);
        self::assertEquals(4, $newMap["b"]->get());
    }

    public function testFilter() {
        $hashMap = new HashMap(["a" => 1, "b" => 2]);
        $filtered = $hashMap->filter(function ($e) {
            return $e > 1;
        });

        $this->assertCount(1, $filtered);
        $this->assertArrayHasKey("b", $filtered);
    }

    public function testKeySet() {
        $m = new HashMap(["a" => 1, "b" => 2]);
        $s = $m->keySet();
        $this->assertInstanceOf(Set::class, $s);
        $this->assertEquals("a", $s->head());
    }

    public function testReplaceKeys() {
        $m = new HashMap([1 => 1, 100 => 100]);
        $new = $m->replaceKeys(function ($k) {
            return $k * 2;
        });
        $this->assertArrayHasKey(2, $new);
        $this->assertArrayHasKey(200, $new);
    }

    public function testSort() {
        $m = new HashMap(["b" => 2, "a" => 1]);
        $this->assertEquals(1, $m->head());
    }
} 