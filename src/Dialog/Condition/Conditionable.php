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
 * Dialog Conditionable-Trait.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
trait Conditionable
{
    /**
     * Available relations for conditions.
     *
     * @var array
     */
    public static $availableRelations = array(
        ConditionedInterface::RELATION_AND,
        ConditionedInterface::RELATION_OR
    );

    /**
     * Conditions of the Formatter.
     *
     * @var array
     */
    protected $conditions = array();


    /**
     * Adds the provided $condition to the condition stack.
     *
     * @param ConditionInterface $condition
     * @param string $relation
     *
     * @return object
     */
    public function addCondition(ConditionInterface $condition, $relation = ConditionedInterface::RELATION_AND)
    {
        $relation = strtolower($relation);

        if (!in_array($relation, self::$availableRelations)) {
            $relation = seConditionedInterfacelf::RELATION_AND;
        }

        $this->conditions[] = array(
            'relation' => $relation,
            'condition' => $condition
        );

        return $this;
    }

    /**
     * Returns the condition stack.
     *
     * @return array
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Returns true if all conditions are matching to the provided $record, otherwise false.
     *
     * @param RecordInterface $record
     *
     * @return boolean
     */
    public function isHandling(RecordInterface $record)
    {
        $result = true;

        foreach ($this->conditions as $condition) {
            if ($condition['relation'] == ConditionedInterface::RELATION_AND) {
                $result = $result && $condition['condition']->evaluate($record);
            } else if ($condition['relation'] == ConditionedInterface::RELATION_OR) {
                $result = $result || $condition['condition']->evaluate($record);
            }
        }

        return $result;
    }

    /**
     * Sets the whole conditions stack with the provided $conditions array.
     *
     * @param array $conditions
     *
     * @return object
     */
    public function setConditions(array $conditions)
    {
        $this->conditions = array();

        foreach ($conditions as $condition) {
            if (!is_array($condition)) {
                $this->conditions[] = array(
                    'relation'  => ConditionedInterface::RELATION_AND,
                    'condition' => $condition
                );
            } else {
                $this->conditions[] = $condition;
            }
        }

        return $this;
    }
}