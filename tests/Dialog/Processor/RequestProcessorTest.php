<?php

use PHPUnit\Framework\TestCase;

use Dialog\Processor\RequestProcessor;
use Dialog\Record\Record;

class RequestProcessorTest extends TestCase
{
    public function testRequestProcessWritesSpecificValuesToTheProvidedRecord()
    {
        $record    = new Record();
        $processor = new RequestProcessor();

        $processor->process($record);

        $additional = $record->getAdditional();

        $this->assertEquals($additional['Request']['IP'], 'X-IP');
        $this->assertEquals($additional['Request']['Server'], 'X-Server');
        $this->assertEquals($additional['Request']['Method'], 'X-Method');
        $this->assertEquals($additional['Request']['URI'], 'X-URI');
        $this->assertEquals($additional['Request']['Referer'], 'X-Referer');
        $this->assertEquals($additional['Request']['User-Agent'], 'X-User-Agent');
    }
}