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

use Mordilion\Configurable\Configurable;
use Mordilion\Configurable\Configuration;
use Dialog\Condition\Conditionable;
use Dialog\Condition\ConditionInterface;
use Dialog\Record\RecordInterface;

/**
 * Dialog Request-Processor-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class RequestProcessor extends ProcessorAbstract
{
    /**
     * Server-Data to labels mapping.
     *
     * @var array
     */
    private $mapping = array(
        'REMOTE_ADDR'     => 'IP',
        'SERVER_NAME'     => 'SERVER',
        'REQUEST_METHOD'  => 'METHOD',
        'REQUEST_URI'     => 'URI',
        'HTTP_REFERER'    => 'REFERER',
        'HTTP_USER_AGENT' => 'USER-AGENT'
    );

    /**
     * Array with Server-Data.
     *
     * @var array
     */
    private $serverData;


    /**
     * {@inheritdoc}
     */
    public function process(RecordInterface &$record)
    {
        if ($this->isHandling($record)) {
            $request = $this->getRequest();
            $record->addAdditional(__CLASS__, $request);
        }
    }

    /**
     * Returns the mapping of the Server-Data to labels.
     *
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * Returns the Server-Data.
     *
     * @return array
     */
    public function getServerData()
    {
        if (!is_array($this->serverData)) {
            $this->setServerData($_SERVER);
        }

        return $this->serverData;
    }

    /**
     * Sets the mapping of the Server-Data to labels.
     *
     * @param array $mapping
     *
     * @return RequestProcessor
     */
    public function setMapping(array $mapping)
    {
        $this->mapping = $mapping;

        return $this;
    }

    /**
     * Sets the Server-Data.
     *
     * @param array $serverData
     *
     * @return RequestProcessor
     */
    public function setServerData(array $serverData)
    {
        $this->serverData = $serverData;

        return $this;
    }

    /**
     * Returns the mapped Server-Data as an array.
     *
     * @return array
     */
    private function getRequest()
    {
        $request    = array();
        $serverData = $this->getServerData();

        foreach ($this->getMapping() as $serverName => $name) {
            $request[$name] = isset($serverData[$serverName]) ? $serverData[$serverName] : null;
        }

        return $request;
    }
}