<?php

use PHPUnit\Framework\TestCase;

use Dialog\Logger;
use Dialog\Handler\ArrayHandler;
use Dialog\Processor\RequestProcessor;
use Psr\Log\LogLevel;

class LoggerTest extends TestCase
{
    public function testCreatingObject()
    {
        $logger = new Logger();

        $this->assertInstanceOf(Logger::class, $logger);
    }

    public function testLogMethodWritesMessagesToTheHandler()
    {
        $logger  = new Logger();
        $handler = new ArrayHandler();

        $logger->addProcessor(new RequestProcessor());
        $logger->addHandler($handler);

        $logger->log(LogLevel::ERROR, 'ERROR');
        $logger->log(LogLevel::DEBUG, 'DEBUG');
        $logger->log(LogLevel::WARNING, 'WARNING');

        $data = $handler->getData();

        $this->assertEquals(count($data), 3);
        $this->assertTrue(strpos($data[0], 'ERROR') !== false);
        $this->assertTrue(strpos($data[1], 'DEBUG') !== false);
        $this->assertTrue(strpos($data[2], 'WARNING') !== false);
    }

    public function testSetTimezoneMethodInDifferentWays()
    {
        $logger = new Logger();

        $logger->setTimezone('Europe/Paris');
        $this->assertEquals($logger->getTimezone()->getName(), 'Europe/Paris');

        $logger->setTimezone(new \DateTimeZone('America/Chicago'));
        $this->assertEquals($logger->getTimezone()->getName(), 'America/Chicago');
    }

    public function testSetTimezoneThrowsInvalidArgumentExceptionIfInvalidTimezoneWasProvided()
    {
        $this->expectException(\InvalidArgumentException::class);

        $logger = new Logger();

        $logger->setTimezone(123456789);
    }
}
