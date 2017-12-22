<?php

use PHPUnit\Framework\TestCase;

use Dialog\Processor\Collection;
use Dialog\Processor\NullProcessor;
use Dialog\Processor\ProcessProcessor;

class ProcessorCollectionTest extends TestCase
{
    public function testCollectionAddMethodAddsTheProvidedItemToTheItemsArray()
    {
        $items      = array();
        $processor  = new NullProcessor();
        $processor2 = new NullProcessor();
        $collection = new Collection();

        $items[] = $processor;
        $items[] = $processor2;

        $collection->add($processor);

        foreach ($collection as $index => $item) {
            $this->assertEquals($items[$index], $item);
        }

        $collection->add($processor2);

        foreach ($collection as $index => $item) {
            $this->assertEquals($items[$index], $item);
        }
    }

    public function testCollectionCountMethodReturnsTheCurrentCount()
    {
        $processor  = new NullProcessor();
        $processor2 = new NullProcessor();
        $collection = new Collection();

        $collection->add($processor);
        $this->assertEquals(count($collection), 1);

        $collection->add($processor2);
        $this->assertEquals(count($collection), 2);
    }
}