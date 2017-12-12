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

use Dialog\Formatter\Formattable;
use Dialog\Record\RecordInterface;

/**
 * Dialog Array-Handler-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class ArrayHandler extends HandlerAbstract
{
    /**
     * Use the following traits.
     */
    use Formattable;


    /**
     * The array for the data.
     *
     * @var array
     */
    protected $data = array();


    /**
     * {@inheritdoc}
     */
    public function handle($records)
    {
        $records = $this->filterRecords($records);

        foreach ($records as $record) {
            if (!$this->isHandling($record)) {
                continue;
            }

            $this->write($record);
        }
    }

    /**
     * Returns the current data of the handler.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Writes the provided record in the stream.
     *
     * @param RecordInterface $record
     *
     * @return void
     */
    private function write(RecordInterface $record)
    {
        $formatter = $this->getFormatter();
        $formatted = $formatter->format($record);

        $this->data[] = (string)$formatted;
    }
}