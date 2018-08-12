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
 * Dialog Null-Processor-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class NullProcessor extends ProcessorAbstract
{
    /**
     * {@inheritdoc}
     */
    public function process(RecordInterface &$record)
    {
        // nothing to process
    }
}