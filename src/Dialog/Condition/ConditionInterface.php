<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Condition;

use Dialog\Record\RecordInterface;

/**
 * Dialog Condition-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface ConditionInterface
{
    const OPERATOR_EQUAL         = '=';
    const OPERATOR_UNEQUAL       = '!=';
    const OPERATOR_GREATER       = '>';
    const OPERATOR_LOWER         = '<';
    const OPERATOR_GREATER_EQUAL = '>=';
    const OPERATOR_LOWER_EQUAL   = '<=';
    const OPERATOR_IN            = 'in';

    /**
     * Constructor.
     *
     * The provided $configuration will configure the object.
     *
     * @param mixed $configuration
     *
     * @return void
     */
    //public function __construct($configuration = null);

    /**
     * Evaluate the condition with provided $record.
     *
     * @param Record $record
     *
     * @return boolean
     */
    public function evaluate(RecordInterface $record);

    /**
     * Returns the current operator of the Condition.
     *
     * @return string
     */
    public function getOperator();

    /**
     * Returns the current value of the Condition.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Sets the operator of the Condition.
     *
     * @param string $operator
     *
     * @throws InvalidArgumentException if the provided $operator is not valid
     *
     * @return ConditionInterface
     */
    public function setOperator($operator);

    /**
     * Sets the value of the Condition.
     *
     * @param mixed $value
     *
     * @return ConditionInterface
     */
    public function setValue($value);
}