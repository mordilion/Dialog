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

use Dialog\Record\RecordInterface;

/**
 * Dialog Stream-Handler-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class StreamHandler extends HandlerAbstract
{
    /**
     * The URL (Uniform Resource Locator) for the stream.
     *
     * @var string
     */
    protected $url;

    /**
     * The stream resource.
     *
     * @var resource
     */
    protected $stream;

    /**
     * State of the stream locking.
     *
     * @var boolean
     */
    protected $locking = false;


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
     * Returns the current state for locking the stream.
     *
     * @return boolean
     */
    public function getLocking()
    {
        return $this->locking;
    }

    /**
     * Sets the URL (Uniform Resource Locator) for the stream.
     *
     * @param string $url
     *
     * @return StreamHandler
     */
    public function setUrl($url)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('The provided url must be a string.');
        }

        $this->url = $url;

        return $this;
    }

    /**
     * Sets the stream locking state.
     *
     * @param boolean $locking
     *
     * @return StreamHandler
     */
    public function setLocking($locking)
    {
        $this->locking = (boolean)$locking;

        return $this;
    }

    /**
     * Sets the stream.
     *
     * @param resource $stream
     *
     * @return StreamHandler
     */
    public function setStream($stream)
    {
        if (!is_resource($stream)) {
            throw new \InvalidArgumentException('The provided stream must be a resource.');
        }

        $this->stream = $stream;

        return $this;
    }

    /**
     * Checks the directory of the URL and create it if the directory doesn't exists.
     *
     * @throws \RuntimeExpection if the directory couldn't created
     *
     * @return void
     */
    private function checkDirectory()
    {
        $directory = dirname($this->url);

        if (strpos($directory, '://') !== false) {
            if (strtolower(substr($directory, 0, 7)) == 'file://') {
                $directory = substr($directory, 7);
            } else {
                $directory = null;
            }
        }

        if (!empty($directory) && !is_dir($directory)) {
            if (!mkdir($directory, 0777, true)) {
                throw new \RuntimeException('Couldn\'t create the directory "' . $directory . '".');
            }
        }
    }

    /**
     * Returns the current stream or opens the defined URL.
     *
     * @return resource
     */
    private function getStream()
    {
        if (!is_resource($this->stream)) {
            if (empty($this->url)) {
                throw new \LogicException('No stream url provided to create a stream.');
            }

            $this->checkDirectory();

            $this->stream = fopen($this->url, 'a');
        }

        return $this->stream;
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
        $stream = $this->getStream();

        if ($this->locking) {
            flock($stream, LOCK_EX);
        }

        $formatter = $this->getFormatter();
        $formatted = $formatter->format($record);

        fwrite($stream, (string)$formatted);

        if ($this->locking) {
            flock($stream, LOCK_UN);
        }
    }
}