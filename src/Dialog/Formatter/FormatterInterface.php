<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Formatter;

use Dialog\Record\RecordInterface;

/**
 * Dialog Formatter-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface FormatterInterface
{
    /**
     * The Formatter will format the provided record object into a string.
     *
     * @param RecordInterface $record
     *
     * @return string
     */
    public function format(RecordInterface $record);
}