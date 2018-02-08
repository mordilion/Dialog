<?php

use PHPUnit\Framework\TestCase;

use Dialog\Record\Record;
use Psr\Log\LogLevel;

class RecordTest extends TestCase
{
    public function testRecordConstructor()
    {
        $data = array(
            Record::ADDITIONAL => array('additional' => 'test'),
            Record::BACKTRACE  => array('Line 1', 'Line 2', 'Line 3'),
            Record::CONTEXT    => array('context' => 'whatever'),
            Record::DATETIME   => new \DateTime('now'),
            Record::LEVEL      => LogLevel::WARNING,
            Record::MESSAGE    => 'Dude, Where\'s My Car?'
        );

        $record = new Record($data);

        $this->assertInstanceOf(Record::class, $record);
        $this->assertEquals($record->getAdditional(), $data[Record::ADDITIONAL]);
        $this->assertEquals($record->getBacktrace(), $data[Record::BACKTRACE]);
        $this->assertEquals($record->getContext(), $data[Record::CONTEXT]);
        $this->assertEquals($record->getDatetime(), $data[Record::DATETIME]);
        $this->assertEquals($record->getLevel(), $data[Record::LEVEL]);
        $this->assertEquals($record->getMessage(), $data[Record::MESSAGE]);
    }

    public function testAddAdditionalOverwritesExistingKeys()
    {
        $data = array(
            Record::ADDITIONAL => array('additional' => 'test', 'additional2' => 'test too')
        );

        $record = new Record($data);
        $record->addAdditional('additional', 'foobar');

        $additional = $record->getAdditional();

        $this->assertInstanceOf(Record::class, $record);
        $this->assertEquals(count($additional), 2);
        $this->assertEquals($additional['additional'], 'foobar');
        $this->assertEquals($additional['additional2'], 'test too');
    }
}