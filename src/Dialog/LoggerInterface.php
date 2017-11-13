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

use Dialog\Handler\HandlerInterface;
use Dialog\Handler\Collection as HandlerCollection;
use Dialog\Processor\ProcessorInterface;
use Dialog\Processor\Collection as ProcessorCollection;

/**
 * Dialog Logger-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface LoggerInterface
{
    /**
     * Adds a handler into the existing collection.
     *
     * @param HandlerInterface $handler
     *
     * @return LoggerInterface
     */
    public function addHandler(HandlerInterface $handler);

    /**
     * Adds a processor into the existing collection.
     *
     * @param ProcessorInterface $handler
     *
     * @return LoggerInterface
     */
    public function addProcessor(ProcessorInterface $processor);

    /**
     * Returns the collection of the handlers.
     *
     * @return HandlerCollection
     */
    public function getHandlers();

    /**
     * Returns the collection of the processors.
     *
     * @return ProcessorCollection
     */
    public function getProcessors();

    /**
     * Returns the current configured timezone.
     *
     * @return string
     */
    public function getTimezone();

    /**
     * Sets the handlers to the provided $handlers.
     *
     * @param HandlerColelction $handlers
     *
     * @return LoggerInterface
     */
    public function setHandlers(HandlerCollection $handlers);

    /**
     * Sets the processors to the provided $processors.
     *
     * @param ProcessorColelction $handlers
     *
     * @return LoggerInterface
     */
    public function setProcessors(ProcessorCollection $processors);

    /**
     * Sets the timezone to the provided $timezone.
     *
     * @param string|\DateTimeZone|null $timezone
     *
     * @throws InvalidArgumentException if the provided timezone is not a valid type
     *
     * @return LoggerInterface
     */
    public function setTimezone($timezone);
}