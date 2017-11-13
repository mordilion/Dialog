<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Handler;

use Mordilion\Configurable\Configurable;
use Mordilion\Configurable\Configuration\Configuration;
use Dialog\Condition\ConditionedTrait;
use Dialog\Condition\Conditionable;
use Dialog\Record\RecordInterface;
use Dialog\Formatter\FormatterInterface;
use Dialog\Formatter\LineFormatter;
use Dialog\Formatter\Collection as FormatterCollection;

/**
 * Dialog Handler-Abstract-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
abstract class HandlerAbstract implements HandlerInterface
{
    /**
     * Use the following traits.
     */
    use Configurable, Conditionable;


    /**
     * Formatter collection.
     *
     * @var FormatterInterface
     */
    protected $formatter;


    /**
     * Constructor.
     *
     * The provided $configuration will configure the object.
     *
     * @param mixed $configuration
     *
     * @return void
     */
    public function __construct($configuration = null)
    {
        $this->formatters = new FormatterCollection();

        if ($configuration != null) {
            $this->setConfiguration(new Configuration($configuration));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFormatter()
    {
        if (!$this->formatter instanceof FormatterInterface) {
            $this->setFormatter(new LineFormatter());
        }

        return $this->formatter;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function handle($records);

    /**
     * {@inheritdoc}
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        unset($this->formatter);

        $this->formatter = $formatter;

        return $this;
    }

    /**
     * Returns a filtered array with all records.
     *
     * @param array|RecordInterface
     *
     * @return array
     */
    protected function filterRecords($records)
    {
        if ($records instanceof RecordInterface) {
            $records = array($records);
        }

        foreach ($records as $key => $record) {
            if (!$record instanceof RecordInterface) {
                unset($records[$key]);
            }
        }

        return $records;
    }
}