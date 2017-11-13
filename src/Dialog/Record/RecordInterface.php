<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Record;

/**
 * Dialog Record-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface RecordInterface
{
    const ADDITIONAL = 'additional';
    const CONTEXT    = 'context';
    const DATETIME   = 'datetime';
    const LEVEL      = 'level';
    const MESSAGE    = 'message';


    /**
     * Constructor.
     *
     * The provided $configuration will configure the object.
     *
     * @param mixed $configuration
     *
     * @return void
     */
    public function __construct($configuration = null);

    /**
     * Adds the provided $key and $data combination to the current stack of additional stuff.
     *
     * @param
     * @param mixed $data
     *
     * @return RecordInterface
     */
    public function addAdditional($key, $data);

    /**
     * Returns the additional stuff of the record.
     *
     * @return array
     */
    public function getAdditional();

    /**
     * Returns the context of the record.
     *
     * @return array
     */
    public function getContext();

    /**
     * Returns the datetime of the record.
     *
     * @return \DateTime
     */
    public function getDatetime();

    /**
     * Returns the level of the record.
     *
     * @return string
     */
    public function getLevel();

    /**
     * Returns the message of the record.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Sets the additional stuff of the record.
     *
     * @param array $additional
     *
     * @return RecordInterface
     */
    public function setAdditional(array $additional);

    /**
     * Sets the context of the record.
     *
     * @param array $context
     *
     * @return RecordInterface
     */
    public function setContext(array $context);

    /**
     * Sets the datetime of the record.
     *
     * @param \DateTime|null $datetime
     *
     * @return RecordInterface
     */
    public function setDatetime($datetime);

    /**
     * Sets the level of the record.
     *
     * @param string $level
     *
     * @return RecordInterface
     */
    public function setLevel($level);

    /**
     * Sets the message of the record.
     *
     * @param string $message
     *
     * @return RecordInterface
     */
    public function setMessage($message);
}