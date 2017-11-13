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
    private $mapping = array(
        'REMOTE_ADDR'     => 'IP',
        'SERVER_NAME'     => 'SERVER',
        'REQUEST_METHOD'  => 'METHOD',
        'REQUEST_URI'     => 'URI',
        'HTTP_REFERER'    => 'REFERER',
        'HTTP_USER_AGENT' => 'USER-AGENT'
    );

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

    public function getMapping()
    {
        return $this->mapping;
    }

    public function getServerData()
    {
        if (!is_array($this->serverData)) {
            $this->serverData = &$_SERVER;
        }

        return $this->serverData;
    }

    public function setMapping(array $mapping)
    {
        $this->mapping = $mapping;

        return $this;
    }

    public function setServerData(array $serverData)
    {
        $this->serverData = $serverData;

        return $this;
    }

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