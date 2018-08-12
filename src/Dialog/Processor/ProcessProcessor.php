<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Processor;

use Dialog\Record\RecordInterface;

/**
 * Dialog Process-Processor-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class ProcessProcessor extends ProcessorAbstract
{
    /**
     * {@inheritdoc}
     */
    public function process(RecordInterface &$record)
    {
        if ($this->isHandling($record)) {
            $record->addAdditional('Process', array(
                'ID'    => getmypid(),
                'User'  => getmyuid(),
                'Group' => getmygid()
            ));
        }
    }
}