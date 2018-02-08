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
 * Dialog Memory-Processor-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class MemoryProcessor extends ProcessorAbstract
{
    /**
     * Boolean to define if the value should be formatted or not.
     *
     * @var boolean
     */
    private $formatMemory = true;

    /**
     * Boolean to use as parameter for the memory methods.
     *
     * @var boolean
     */
    private $realUsage = true;


    /**
     * {@inheritdoc}
     */
    public function process(RecordInterface &$record)
    {
        if ($this->isHandling($record)) {
            $record->addAdditional('Memory', array(
                'Usage' => $this->formatMemory(memory_get_usage($this->getRealUsage())),
                'Peak'  => $this->formatMemory(memory_get_peak_usage($this->getRealUsage()))
            ));
        }
    }

    /**
     * Returns the value of the formatMemory variable to indicate if the memory values should be formatted or not.
     *
     * @return boolean
     */
    public function getFormatMemory()
    {
        return $this->formatMemory;
    }

    /**
     * Returns the value of the realUsage variable for the memeory methods.
     *
     * @return boolean
     */
    public function getRealUsage()
    {
        return $this->realUsage;
    }

    /**
     * Sets the formatMemory variable to indicate if the memory values should be formatted or not.
     *
     * @param boolean $formatMemory
     *
     * @return MemoryProcessor
     */
    public function setFormatMemory($formatMemory)
    {
        $this->formatMemory = (boolean)$formatMemory;

        return $this;
    }

    /**
     * Sets the realUsage variable for the memory methods as parameter.
     *
     * @param boolean $realUsage
     *
     * @return MemoryProcessor
     */
    public function setRealUsage($realUsage)
    {
        $this->realUsage = (boolean)$realUsage;

        return $this;
    }

    /**
     * Returns the provided value of bytes in a formatted value with unit tag.
     *
     * @param integer $bytes
     *
     * @return string
     */
    protected function formatMemory($bytes)
    {
        $result = (string)$bytes;

        if ($this->getFormatMemory()) {
            $units  = array('Bytes', 'KB', 'MB', 'GB', 'TB');

            foreach ($units as $multiplier => $unit) {
                $pow = pow(1024, $multiplier);

                if ($bytes < $pow) {
                    break;
                }

                $result = round($bytes / $pow, 2) . ' ' . $unit;
            }
        }

        return $result;
    }
}