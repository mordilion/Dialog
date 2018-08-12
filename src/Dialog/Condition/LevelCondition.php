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

use Psr\Log\LogLevel;
use Dialog\Record\RecordInterface;

/**
 * Dialog Level-Condition-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class LevelCondition extends ConditionAbstract
{
    /**
     * Priorities of the different logging levels.
     *
     * @var array
     */
    public static $levelPriorities = array(
        LogLevel::DEBUG     => 100,
        LogLevel::INFO      => 200,
        LogLevel::NOTICE    => 300,
        LogLevel::WARNING   => 400,
        LogLevel::ERROR     => 500,
        LogLevel::CRITICAL  => 600,
        LogLevel::ALERT     => 700,
        LogLevel::EMERGENCY => 800
    );


    /**
     * {@inheritdoc}
     */
    public function evaluate(RecordInterface $record)
    {
        $operator = $this->getOperator();
        $value    = $this->getValue();

        $left  = self::$levelPriorities[$record->getLevel()];

        if (is_array($value)) {
            $right = array();

            foreach ($value as $level) {
                $right[] = self::$levelPriorities[$level];
            }
        } else {
            $right = self::$levelPriorities[$value];
        }

        return $this->evaluateOperation($left, $operator, $right);
    }
}