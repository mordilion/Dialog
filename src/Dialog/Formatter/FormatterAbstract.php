<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Formatter;

use Mordilion\Configurable\Configurable;
use Mordilion\Configurable\Configuration;
use Dialog\Condition\Conditionable;
use Dialog\Condition\ConditionInterface;
use Dialog\Record\RecordInterface;

/**
 * Dialog Formatter-Abstract-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
abstract class FormatterAbstract implements FormatterInterface
{
    /**
     * Use the following traits.
     */
    use Configurable, Conditionable;


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
        if ($configuration != null) {
            $this->setConfiguration(new Configuration($configuration));
        }
    }

    /**
     * {@inheritdoc}
     */
    abstract public function format(RecordInterface $record);
}