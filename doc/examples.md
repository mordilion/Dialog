# Examples
## Write only error messages into a file
```php
<?php

use Dialog\Logger;
use Dialog\Handler\StreamHandler;
use Dialog\Condition\LevelCondition;
use Psr\Log\LogLevel;

{...}

$logger = new Logger();

$condition = new LevelCondition();
$condition->setValue(LogLevel::WARNING)
    ->setOperator(LevelCondition::OPERATOR_GREATER_EQUAL); // or ->setOperator('>=');

// Create a StreamHandler instance and add it to the logger instance
$handler = new StreamHandler();
$handler->setUrl('/path/to/your/file.log')
    ->addCondition($condition);

$logger->addHandler($handler);

{...}

$logger->debug('This is a debug message!'); // gets NOT written to the file
$logger->warning('This is a warning message!'); // gets written to the file
```

## Write all messages into a file and send only error messages to a specified email address
```php
<?php

use Dialog\Logger;
use Dialog\Handler\MailHandler;
use Dialog\Handler\StreamHandler;
use Dialog\Condition\LevelCondition;
use Psr\Log\LogLevel;

{...}

$logger = new Logger();

$condition = new LevelCondition();
$condition->setValue(LogLevel::WARNING)
    ->setOperator(LevelCondition::OPERATOR_GREATER_EQUAL); // or ->setOperator('>=');

// Create a StreamHandler instance and add it to the logger instance
$handler = new StreamHandler();
$handler->setUrl('/path/to/your/file.log');

$logger->addHandler($handler);

// Create a MailHandler instance and add it to the logger instance
$handler = new MailHandler();
$handler->addCondition($condition)
    ->getMailer()
    ->setTo('your.email@domain.invalid');

$logger->addHandler($handler);

{...}

$logger->debug('This is a debug message!'); // gets written to the file but NOT send as an email
$logger->warning('This is a warning message!'); // gets written to the file and send as an email
```
