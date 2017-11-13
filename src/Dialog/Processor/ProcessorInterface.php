<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Processor;

use Dialog\Record\RecordInterface;

/**
 * Dialog Processor-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface ProcessorInterface
{
    const PROCESSORS_CONTEXT_KEY = 'processors';


    /**
     * The Processor will process operations and add some additional information to the $record.
     *
     * @param RecordInterface &$record
     *
     * @return string
     */
    public function process(RecordInterface &$record);
}