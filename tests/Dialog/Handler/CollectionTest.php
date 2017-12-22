<?php

use PHPUnit\Framework\TestCase;

use Dialog\Handler\Collection;
use Dialog\Handler\NullHandler;

class HandlerCollectionTest extends TestCase
{
    public function testCollectionAddMethodAddsTheProvidedItemToTheItemsArray()
    {
        $items      = array();
        $handler    = new NullHandler();
        $handler2   = new NullHandler();
        $collection = new Collection();

        $items[] = $handler;
        $items[] = $handler2;

        $collection->add($handler);

        foreach ($collection as $index => $item) {
            $this->assertEquals($items[$index], $item);
        }

        $collection->add($handler2);

        foreach ($collection as $index => $item) {
            $this->assertEquals($items[$index], $item);
        }
    }

    public function testCollectionCountMethodReturnsTheCurrentCount()
    {
        $handler    = new NullHandler();
        $handler2   = new NullHandler();
        $collection = new Collection();

        $collection->add($handler);
        $this->assertEquals(count($collection), 1);

        $collection->add($handler2);
        $this->assertEquals(count($collection), 2);
    }
}