<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Handler;

use Dialog\Condition\ConditionedInterface;
use Dialog\Formatter\FormatterInterface;

/**
 * Dialog Handler-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface HandlerInterface extends ConditionedInterface
{
    /**
     * Returns the current formatter.
     *
     * @return FormatterInterface
     */
    public function getFormatter();

    /**
     * The Handler will handling all provided record objects.
     *
     * @param array|RecordInterface $records
     *
     * @return boolean
     */
    public function handle($records);

    /**
     * Sets the formatter to the provided $formatter.
     *
     * @param FormatterInterface $formatter
     *
     * @return HandlerInterface
     */
    public function setFormatter(FormatterInterface $formatter);
}