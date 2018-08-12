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
 * Dialog Conditioned-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface ConditionedInterface
{
    const RELATION_AND = 'and';
    const RELATION_OR  = 'or';


    /**
     * Adds the provided $condition to the Handler conditions.
     *
     * @param ConditionInterface $condition
     * @param string $relation
     *
     * @return HandlerInterface
     */
    public function addCondition(ConditionInterface $condition, $relation = 'and');

    /**
     * Returns the conditions of the Handler.
     *
     * @return array
     */
    public function getConditions();

    /**
     * If the provided $record will be handled by the Handler
     * then it retruns true, otherwise false.
     *
     * @param RecordInterface $record
     *
     * @return boolean
     */
    public function isHandling(RecordInterface $record);

    /**
     * Sets the conditions of the Handler.
     *
     * @param array $conditions
     *
     * @return HandlerInterface
     */
    public function setConditions(array $conditions);
}