<?php

use PHPUnit\Framework\TestCase;

use Dialog\Processor\MemoryProcessor;
use Dialog\Record\Record;

class MemoryProcessorTest extends TestCase
{
    public function testMemoryProcessWritesSpecificValuesToTheProvidedRecordFormattedRealUsage()
    {
        $record    = new Record();
        $processor = new MemoryProcessor();

        $processor->process($record);

        $additional = $record->getAdditional();

        $this->assertRegExp('/\d+((\.|,)\d{2})? (TB|GB|MB|KB|Bytes)/', $additional['Memory']['Usage']);
        $this->assertRegExp('/\d+((\.|,)\d{2})? (TB|GB|MB|KB|Bytes)/', $additional['Memory']['Peak']);
    }

    public function testMemoryProcessWritesSpecificValuesToTheProvidedRecordUnformattedRealUsage()
    {
        $record    = new Record();
        $processor = new MemoryProcessor(array('formatMemory' => false));

        //$processor->setFormatMemory(false);

        $processor->process($record);

        $additional = $record->getAdditional();

        $this->assertRegExp('/^\d+$/', $additional['Memory']['Usage']);
        $this->assertRegExp('/^\d+$/', $additional['Memory']['Peak']);
    }

    public function testMemoryProcessWritesSpecificValuesToTheProvidedRecordFormattedNotRealUsage()
    {
        $record    = new Record();
        $processor = new MemoryProcessor();

        $processor->setRealUsage(false);

        $processor->process($record);

        $additional = $record->getAdditional();

        $this->assertRegExp('/\d+((\.|,)\d{2})? (TB|GB|MB|KB|Bytes)/', $additional['Memory']['Usage']);
        $this->assertRegExp('/\d+((\.|,)\d{2})? (TB|GB|MB|KB|Bytes)/', $additional['Memory']['Peak']);
    }

    public function testMemoryProcessWritesSpecificValuesToTheProvidedRecordUnformattedNotRealUsage()
    {
        $record    = new Record();
        $processor = new MemoryProcessor();

        $processor->setRealUsage(false);
        $processor->setFormatMemory(false);

        $processor->process($record);

        $additional = $record->getAdditional();

        $this->assertRegExp('/^\d+$/', $additional['Memory']['Usage']);
        $this->assertRegExp('/^\d+$/', $additional['Memory']['Peak']);
    }
}