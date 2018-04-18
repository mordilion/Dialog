# Conditions
Condition-Clases getting used to limit the functionality of Formatters, Handlers and Processors based on specific criterias like Context content, Date and Time and Log-Level.

## Operators
Here is a list of all possible operators to be used in conditons.

```
- OPERATOR_EQUAL:         =
- OPERATOR_UNEQUAL:       !=
- OPERATOR_GREATER:       >
- OPERATOR_LOWER:         <
- OPERATOR_GREATER_EQUAL: >=
- OPERATOR_LOWER_EQUAL:   <=
- OPERATOR_IN:            in
```

## Context
```php
<?php

use Dialog\Condition\ContextCondition;

{...}

$condition = (new ContextCondition())
    ->setField('FieldIndex')
    ->setValue('some content')
    ->setOperator(ContextCondition::OPERATOR_EQUAL); // or ->setOperator('=');

{...}
```

## Datetime
```php
<?php

use Dialog\Condition\DatetimeCondition;

{...}

$condition = (new DatetimeCondition())
    ->setTimezone('America/Chicago')
    ->setValue('10:00AM')
    ->setOperator(DatetimeCondition::OPERATOR_GREATER_EQUAL); // or ->setOperator('>=');

{...}
```

## Level
```php
<?php

use Dialog\Condition\LevelCondition;
use Psr\Log\LogLevel;

{...}

$condition = (new LevelCondition())
    ->setTimezone('America/Chicago')
    ->setValue(array(LogLevel::WARNING, LogLevel::ERROR))
    ->setOperator(LevelCondition::OPERATOR_IN); // or ->setOperator('in');

{...}
```

## Factory