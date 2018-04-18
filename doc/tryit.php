<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dialog\Logger;
use Dialog\Handler\StreamHandler;

$logger = new Logger();
$logger->addHandler((new StreamHandler())->setUrl(__DIR__ . '/tryit.log'));

$logger->info('Feel free to use this file to try Dialog and play a bit with it! :)');