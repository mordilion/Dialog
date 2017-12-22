<?php

use PHPUnit\Framework\TestCase;

use Dialog\Processor\ProcessProcessor;
use Dialog\Record\Record;

class ProcessProcessorTest extends TestCase
{
    public function testProcessProcessWritesSpecificValuesToTheProvidedRecord()
    {
        $record    = new Record();
        $processor = new ProcessProcessor();

        $processor->process($record);

        $additional = $record->getAdditional();

        $this->assertEquals($additional['Process']['ID'], getmypid());
        $this->assertEquals($additional['Process']['User'], getmyuid());
        $this->assertEquals($additional['Process']['Group'], getmygid());
    }
}