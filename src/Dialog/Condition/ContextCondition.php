<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Condition;

use Dialog\Record\RecordInterface;

/**
 * Dialog Context-Condition-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class ContextCondition extends ConditionAbstract
{
    /**
     * Field of the Record-Context.
     *
     * @var string
     */
    protected $field;


    /**
     * {@inheritdoc}
     */
    public function evaluate(RecordInterface $record)
    {
        $operator = $this->getOperator();
        $value    = $this->getValue();
        $context  = $record->getContext();

        if (!isset($context[$this->field])) {
            return true;
        }

        $left  = $context[$this->field];
        $right = $value;

        return $this->evaluateOperation($left, $operator, $right);
    }

    /**
     * Returns the current field of the Record-Context.
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Sets the $field for the Record-Context value.
     *
     * @param string $field
     *
     * @throws InvalidArgumentException if the provided field is not a string
     *
     * @return DatetimeCondition
     */
    public function setField($field)
    {
        if (!is_string($field)) {
            throw new InvalidArgumentException('The provided field must be a string.');
        }

        $this->field = $field;

        return $this;
    }
}