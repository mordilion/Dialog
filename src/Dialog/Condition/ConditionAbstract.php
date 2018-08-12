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

use Mordilion\Configurable\Configurable;
use Mordilion\Configurable\Configuration\Configuration;
use Dialog\Record\RecordInterface;

/**
 * Dialog Condition-Abstract-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
abstract class ConditionAbstract implements ConditionInterface
{
    /**
     * Use the following traits.
     */
    use Configurable;


    /**
     * Available operators.
     *
     * @var array
     */
    public static $availableOperators = array(
        self::OPERATOR_EQUAL,
        self::OPERATOR_UNEQUAL,
        self::OPERATOR_GREATER,
        self::OPERATOR_LOWER,
        self::OPERATOR_GREATER_EQUAL,
        self::OPERATOR_LOWER_EQUAL,
        self::OPERATOR_IN
    );

    /**
     * The comparison operator for the condition.
     *
     * In the middle of the comparison.
     *
     * @var string
     */
    protected $operator;

    /**
     * The comparison value for the condition.
     *
     * Right side of the comparison.
     *
     * @var string
     */
    protected $value;


    /**
     * {@inheritdoc}
     */
    public function __construct($configuration = null)
    {
        if ($configuration != null) {
            $this->setConfiguration(new Configuration($configuration));
        }
    }

    /**
     * {@inheritdoc}
     */
    abstract public function evaluate(RecordInterface $record);

    /**
     * {@inheritdoc}
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setOperator($operator)
    {
        if (!in_array($operator, self::$availableOperators)) {
            throw new InvalidArgumentException('The operator must be one of (' . implode(',', self::$availableOperators) . ').');
        }

        $this->operator = $operator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Evaluates the provided operation and returns the result of it.
     *
     * @param mixed $left
     * @param string $operator
     * @param mixed $right
     *
     * @return boolean
     */
    protected function evaluateOperation($left, $operator, $right)
    {
        switch ($operator) {
            case self::OPERATOR_EQUAL:
                return $left == $right;
                break;

            case self::OPERATOR_UNEQUAL:
                return $left != $right;
                break;

            case self::OPERATOR_GREATER:
                return $left > $right;
                break;

            case self::OPERATOR_LOWER:
                return $left < $right;
                break;

            case self::OPERATOR_GREATER_EQUAL:
                return $left >= $right;
                break;

            case self::OPERATOR_LOWER_EQUAL:
                return $left <= $right;
                break;

            case self::OPERATOR_IN:
                if (is_array($right)) {
                    return in_array($left, $right);
                }
                break;
        }

        return false;
    }
}