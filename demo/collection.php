<?php
/**
 * @author Nikita Melnikov <melnikovnikita@icloud.com>
 * @date 11.11.14
 */

require_once './../vendor/autoload.php';

use \Functional\Collection\Collection;

function dataProvider() {
    return [
        [
            'a' => 1,
            'b' => 2,
        ],
        [
            'a' => 2,
            'b' => 3,
        ],
        [
            'a' => 3,
            'b' => 4,
        ],
        [
            'a' => 4,
            'b' => 5,
        ],
        [
            'a' => 5,
            'b' => 6,
        ],
    ];
}

//----------------------------------------------------------------------
// Create and map
$collection = (new Collection(dataProvider()))->map(function (array $attributes) {
    $c = new stdClass();
    $c->a = $attributes['a'];
    $c->b = $attributes['b'];
    return $c;
});

//----------------------------------------------------------------------
echo 'Filter and iterate:', PHP_EOL;
// Filter and show object.a value
$collection->filter(function (stdClass $c) {
    return $c->b > 2;
})->each(function (stdClass $c) {
    echo $c->a, PHP_EOL;
});

//----------------------------------------------------------------------
echo 'Reduce:', PHP_EOL;
// reduce data with start = 100
echo (new Collection([1, 2, 3, 4, 5, 6]))->foldLeft(function ($e1, $e2) {
    return $e1 + $e2;
}, 100), PHP_EOL;

//----------------------------------------------------------------------
// Recursion
echo 'Recursion:', PHP_EOL;

/**
 * @param Collection $xs
 * @param integer $result
 * @param \Closure $f
 * @return integer
 */
function iterateCollection(Collection $xs, $result, $f) {
    if (!$xs->isEmpty()) {
        return iterateCollection($xs->tail(), $f($xs->head()) + $result, $f);
    } else {
        return $result;
    }
}

$f1 = function ($a) {
    return $a * 2;
};

$f2 = function ($a) {
    return $a * 3;
};

echo iterateCollection(new Collection(range(1, 4)), 0, $f1), PHP_EOL;
echo iterateCollection(new Collection(range(1, 4)), 0, $f2), PHP_EOL;

//----------------------------------------------------------------------
// Call stack
function lambdaDataProvider() {
    return (new Collection(range(1, 10)))->map(function ($e) {
        return function ($element) use (&$e) {
            return $element * $e;
        };
    })->toArray();
}

echo 'Callstack:', PHP_EOL;
$result = 1;
(new Collection(lambdaDataProvider()))->each(function ($f) use (&$result) {
    printf("%d\n", $result);
    $result += $f($result);
});
echo $result, PHP_EOL;