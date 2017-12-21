# Dialog - A PSR-3 based logger interface for PHP

[![Total Downloads](https://img.shields.io/packagist/dt/mordilion/dialog.svg)](https://packagist.org/packages/mordilion/dialog)

The Dialog library implements the [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) interface and is fully configurable with INI, JSON, YAML, XML or PHP-Arrays. All Handlers, Processors and Formatters can be limit with conditions for DateTime, Level and Context-Content of a Record.

## Installation
Install the latest version of Dialog with:
```bash
$ composer require mordilion/dialog
```

## Basic usage
```php
<?php

use Dialog\Logger;
use Dialog\Handler\StreamHandler;

{...}

$logger = new Logger();
$logger->addHandler((new StreamHandler())->setUrl('/path/to/your/file.log')));

{...}

$logger->debug('This is a debug message!');
$logger->warning('This is a warning message!');
```

## Documentation

## About
### Author
Henning Huncke - <mordilion@gmx.de> - <https://twitter.com/Mordilion>

### License
Dialog is licensed under the MIT License - see the `LICENSE` file for details.

### Acknowledgements
This library is inspired by [Monolog](https://github.com/Seldaek/monolog) library.