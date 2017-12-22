<?php

use PHPUnit\Framework\TestCase;

use Dialog\Processor\NullProcessor;
use Dialog\Record\Record;

class NullProcessorTest extends TestCase
{
    public function testProcessProcessWritesSpecificValuesToTheProvidedRecord()
    {
        $record    = new Record();
        $processor = new NullProcessor();

        $processor->process($record);

        // nothing to test because it is the NullProcessor without any functionality
        $this->assertTrue($processor instanceof NullProcessor);
    }
}