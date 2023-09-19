<?php


use DevHelper\Lib\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testMake()
    {
        $collection = Collection::make([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $collection->all());
    }

    public function testMap()
    {
        $collection = Collection::make([1, 2, 3])->map(function ($item) {
            return $item * 2;
        });
        $this->assertEquals([2, 4, 6], $collection->all());
    }

    public function testFind()
    {
        $collection = Collection::make([1, 2, 3])->find(function ($item) {
            return $item > 1;
        });
        $this->assertEquals([2, 3], array_values($collection->all()));
    }

    public function testAll()
    {
        $collection = Collection::make([1, 2, 3])->all();
        $this->assertEquals([1, 2, 3], $collection);
    }

    public function testToArray()
    {
        $collection = Collection::make([1, 2, 3])->toArray();
        $this->assertEquals([1, 2, 3], $collection);
    }
}
