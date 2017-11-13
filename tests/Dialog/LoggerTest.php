<?php

require_once 'Dialog/Logger.php';

use PHPUnit\Framework\TestCase;

use Dialog\Logger;

class LoggerTest extends TestCase
{
    /**
     * Creating a new instance of the object without any parameters.
     */
    public function testCreatingObjectwithoutAnyParameters()
    {
        $logger = new Logger();

	$this->assertInstanceOf(Logger::class, $logger);
    }
}
