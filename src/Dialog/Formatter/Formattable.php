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

use Dialog\Record\RecordInterface;

/**
 * Dialog Formattable-Trait.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
trait Formattable
{
    /**
     * Formatter collection.
     *
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * Default-Formatter-Class which gets used if nothing else was set.
     *
     * @var string|FormatterInterface
     */
    protected $defaultFormatter = LineFormatter::class;


    /**
     * Returns the Default-Formatter.
     *
     * @return string|FormatterInterface
     */
    public function getDefaultFormatter()
    {
        return $this->defaultFormatter;
    }

    /**
     * Returns the Formatter.
     *
     * @return FormatterInterface
     */
    public function getFormatter()
    {
        if (!$this->formatter instanceof FormatterInterface) {
            $formatter = $this->getDefaultFormatter();

            if (!is_object($formatter)) {
                $formatter = new $formatter;
            }

            $this->setFormatter(new $formatter);
        }

        return $this->formatter;
    }

    /**
     * Sets the Default-Formatter to the provided class name or FormatterInterface instance.
     *
     * @param string|FormatterInterface $formatter
     *
     * @return object
     */
    public function setDefaultFormatter($formatter)
    {
        if (is_subclass_of($formatter, FormatterInterface::class)) {
            $this->defaultFormatter = $formatter;
        }

        return $this;
    }

    /**
     * Sets the Formatter to the provided FormatterInterface instance.
     *
     * @param FormatterInterface $formatter
     *
     * @return object
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        unset($this->formatter);

        $this->formatter = $formatter;

        return $this;
    }
}