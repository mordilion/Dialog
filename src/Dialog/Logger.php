<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use Dialog\Record\Record;
use Dialog\Handler\HandlerInterface;
use Dialog\Handler\Collection as HandlerCollection;
use Dialog\Processor\ProcessorInterface;
use Dialog\Processor\Collection as ProcessorCollection;

/**
 * Dialog Logger-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class Logger extends AbstractLogger
{
    /**
     * Handler collection.
     *
     * @var HandlerCollection
     */
    protected $handlers;

    /**
     * Processor collection.
     *
     * @var ProcessorCollection
     */
    protected $processors;

    /**
     * Current Timezone.
     *
     * @var \DateTimeZone
     */
    protected $timezone;


    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->timezone = new \DateTimeZone(date_default_timezone_get());
        $this->handlers = new HandlerCollection();
        $this->processors = new ProcessorCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = array())
    {
        $record = new Record(array(
            'message'  => $message,
            'context'  => $context,
            'level'    => $level,
            'datetime' => new \DateTime('now', $this->timezone)
        ));

        foreach ($this->getProcessors() as $processor) {
            $processor->process($record);
        }

        foreach ($this->getHandlers() as $handler) {
            $handler->handle($record);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers->add($handler);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addProcessor(ProcessorInterface $processor)
    {
        $this->processors->add($processor);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessors()
    {
        return $this->processors;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * {@inheritdoc}
     */
    public function setHandlers(HandlerCollection $handlers)
    {
        unset($this->handlers);

        $this->handlers = $handlers;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setProcessors(ProcessorCollection $processors)
    {
        unset($this->processors);

        $this->processors = $processors;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimezone($timezone)
    {
        if (is_string($timezone)) {
            $this->timezone = new \DateTimeZone($timezone);
        } else if ($timezone instanceof \DateTimeZone) {
            $this->timezone = $timezone;
        } else {
            throw new \InvalidArgumentException('The provided timezone must be a string or an instance of \DateTimeZone.');
        }

        $this->timezone = $timezone;

        return $this;
    }
}