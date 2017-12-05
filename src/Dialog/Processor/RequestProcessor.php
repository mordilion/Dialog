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
 * Dialog Request-Processor-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class RequestProcessor extends ProcessorAbstract
{
    /**
     * {@inheritdoc}
     */
    public function process(RecordInterface &$record)
    {
        if ($this->isHandling($record)) {
            $record->addAdditional('REQUEST', array(
                'IP'         => $this->getValue('REMOTE_ADDR'),
                'SERVER'     => $this->getValue('SERVER_NAME'),
                'METHOD'     => $this->getValue('REQUEST_METHOD'),
                'URI'        => $this->getValue('REQUEST_URI'),
                'REFERER'    => $this->getValue('HTTP_REFERER'),
                'USER-AGENT' => $this->getValue('HTTP_USER_AGENT')
            ));
        }
    }

    /**
     * Returns the value of the provided key if exists, otherwise it returns null.
     *
     * @param string $key
     *
     * @return mixed
     */
    private function getValue($key)
    {
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return null;
    }
}