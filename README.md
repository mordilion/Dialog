## Basic Usagees
### Write everything into a file
```php
<?php

use Dialog\Logger;
use Dialog\Handler\StreamHandler;

$handler = new StreamHandler();
$handler->setUrl('/path/to/your/file.log');

$logger = new Logger();
$logger->addHandler($handler);

$logger->debug('This is a debug message!');
$logger->warning('This is a warning message!');
```

### Write only error messages into a file
```php
<?php

use Dialog\Logger;
use Dialog\Handler\StreamHandler;
use Dialog\Condition\LevelCondition;

$condition = new LevelCondition();
$condition->setValue(LogLevel::WARNING)
    ->setOperator(LevelCondition::OPERATOR_GREATER_EQUAL);

$handler = new StreamHandler();
$handler->setUrl('/path/to/your/file.log')
    ->addCondition($condition);

$logger = new Logger();
$logger->addHandler($handler);

$logger->debug('This is a debug message!'); // gets NOT written to the file
$logger->warning('This is a warning message!'); // gets written to the file
```