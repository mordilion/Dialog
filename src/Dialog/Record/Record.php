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

use Psr\Log\LogLevel;
use Mordilion\Configurable\Configurable;
use Mordilion\Configurable\Configuration\Configuration;

/**
 * Dialog Record-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class Record implements RecordInterface
{
    /**
     * Use the following traits.
     */
    use Configurable;


    /**
     * The data of the record.
     *
     * @var array
     */
    protected $defaults = array(
        self::ADDITIONAL => array(),
        self::BACKTRACE  => array(),
        self::CONTEXT    => array(),
        self::DATETIME   => null,
        self::LEVEL      => LogLevel::DEBUG,
        self::MESSAGE    => ''
    );


    /**
     * {@inheritdoc}
     */
    public function __construct($configuration = null)
    {
        $this->setConfiguration(new Configuration($this->defaults));

        if ($configuration != null) {
            $this->addConfiguration(new Configuration($configuration));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addAdditional($key, $data)
    {
        $additional = $this->getAdditional();

        $additional[$key] = $data;

        $this->setAdditional($additional);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdditional()
    {
        return $this->configuration->get(self::ADDITIONAL, $this->defaults[self::ADDITIONAL]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBacktrace()
    {
        return $this->configuration->get(self::BACKTRACE, $this->defaults[self::BACKTRACE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->configuration->get(self::CONTEXT, $this->defaults[self::CONTEXT]);
    }

    /**
     * {@inheritdoc}
     */
    public function getDatetime()
    {
        return $this->configuration->get(self::DATETIME, $this->defaults[self::DATETIME]);
    }

    /**
     * {@inheritdoc}
     */
    public function getLevel()
    {
        return $this->configuration->get(self::LEVEL, $this->defaults[self::LEVEL]);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->configuration->get(self::MESSAGE, $this->defaults[self::MESSAGE]);
    }

    /**
     * {@inheritdoc}
     */
    public function setAdditional(array $additional)
    {
        $this->configuration->set(self::ADDITIONAL, $additional);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBacktrace(array $backtrace)
    {
        $this->configuration->set(self::BACKTRACE, $backtrace);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(array $context)
    {
        $this->configuration->set(self::CONTEXT, $context);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDatetime($datetime)
    {
        if (!$datetime instanceof \DateTime) {
            $datetime = new \DateTime('now');
        }

        $this->configuration->set(self::DATETIME, $datetime);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLevel($level)
    {
        $this->configuration->set(self::LEVEL, $level);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        $this->configuration->set(self::MESSAGE, $message);

        return $this;
    }
}