<?php

require_once __DIR__ . '/../vendor/autoload.php';


use Dialog\Logger;
use Dialog\Handler\StreamHandler;
use Dialog\Condition\DatetimeCondition;


$logger = new Logger();
$logger->addHandler((new StreamHandler())->setUrl(__DIR__ . '/tryit.log'));
$logger->addHandler(
    (new StreamHandler())->setUrl(__DIR__ . '/tryit-with-conditions.log')
        ->addCondition((new DatetimeCondition())->setTimezone('America/Chicago')->setValue('01:00AM')->setOperator('>='))
);


$logger->info('Feel free to use this file to try Dialog and play a bit with it! :)');