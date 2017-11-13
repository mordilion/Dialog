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
 * Dialog Datetime-Condition-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class DatetimeCondition extends ConditionAbstract
{
    /**
     * Timezone of the DateTime value.
     *
     * @var \DateTimeZone
     */
    protected $timezone;


    /**
     * {@inheritdoc}
     */
    public function evaluate(RecordInterface $record)
    {
        $operator = $this->getOperator();
        $value    = $this->getValue();

        $left  = $record->getDatetime();

        if (is_array($value)) {
            $right = array();

            foreach ($value as $datetime) {
                $right[] = new \DateTime($datetime, $this->timezone);
            }
        } else {
            $right = new \DateTime($value, $this->timezone);
        }

        return $this->evaluateOperation($left, $operator, $right);
    }

    /**
     * Returns the current timezone.
     *
     * @return \DateTimeZone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Sets the $timezone for the \DateTime value.
     *
     * @param string|\DateTimeZone|null $timezone
     *
     * @throws InvalidArgumentException if the provided timezone is not a string, null or a \DateTimeZone
     *
     * @return DatetimeCondition
     */
    public function setTimezone($timezone)
    {
        if (is_string($timezone)) {
            $timezone = new \DateTimeZone($timezone);
        }

        if (!$timezone instanceof \DateTimeZone && $timezone !== null) {
            throw new InvalidArgumentException('The provided timezone must be a string, null or an instance of \DateTimeZone.');
        }

        $this->timezone = $timezone;

        return $this;
    }
}