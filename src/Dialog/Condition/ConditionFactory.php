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
 * Dialog Condition-Factory-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class ConditionFactory
{
    const TYPE_CONTEXT  = 'context';
    const TYPE_DATETIME = 'datetime';
    const TYPE_LEVEL    = 'level';


    /**
     * Creates and returns a condition with the provided parameters.
     *
     * @param string $type
     * @param array $parameters
     * @param string $relation
     * @param boolean $asArray
     *
     * @return array
     */
    public static function create($type, array $parameters = array(), $relation = ConditionedInterface::RELATION_AND, $asArray = false)
    {
        $condition = null;

        switch ($type) {
            case self::TYPE_CONTEXT:
                $condition = new ContextCondition($parameters);
                break;

            case self::TYPE_DATETIME:
                $condition = new DatetimeCondition($parameters);
                break;

            case self::TYPE_LEVEL:
                $condition = new LevelCondition($parameters);
                break;

            default: /* it's maybe a class? */
                if (class_exists($type) && is_subclass_of($type, ConditionAbstract::class)) {
                    $condition = new $type($parameters);
                } else {
                    return array();
                }

                break;
        }

        return self::wrapCondition($condition, $relation, $asArray);
    }

    /**
     * Wraps the provided condition with the given parameters and returns it.
     *
     * @param ConditionAbstract $condition
     * @param string $relation
     * @param boolean $asArray
     *
     * @return array
     */
    private static function wrapCondition(ConditionAbstract $condition, $relation, $asArray)
    {
        if (!in_array($relation, Conditionable::$availableRelations)) {
            $relation = ConditionedInterface::RELATION_AND;
        }

        $result = array(
            'relation'  => $relation,
            'condition' => $condition
        );

        if ($asArray) {
            $result = array($result);
        }

        return $result;
    }
}