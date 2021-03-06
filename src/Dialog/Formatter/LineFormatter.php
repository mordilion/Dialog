<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Formatter;

use Dialog\Record\RecordInterface;

/**
 * Dialog Line-Formatter-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class LineFormatter extends FormatterAbstract
{
    const MODIFIER_LOWER  = 'lower';
    const MODIFIER_UPPER  = 'upper';

    const FORMAT_DEFAULT  = "[%#datetime#%] [%#level|upper#%] %#message#% %#context#% %#additional#%" . PHP_EOL;
    const FORMAT_DETAILED = "[%#datetime#%] [%#level|upper#%] %#message#% " . PHP_EOL . "   - Context: %#context#%" . PHP_EOL . "   - Additional: %#additional#%" . PHP_EOL . "   - Backtrace: %#backtrace#%" . PHP_EOL . PHP_EOL;


    /**
     * Use the following traits.
     */
    use Normalizeable;


    /**
     * Format of the line.
     *
     * @var string
     */
    protected $format = self::FORMAT_DEFAULT;


    /**
     * {@inheritdoc}
     */
    public function format(RecordInterface $record)
    {
        $data = $this->normalize($record);
        $line = $this->getFormat();

        $this->replaceLine($line, $data);

        return $line;
    }

    /**
     * Returns the current format for the line.
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Sets the format for the line.
     *
     * @param string $format
     *
     * @return LineFormatter
     */
    public function setFormat($format)
    {
        $this->format = (string)$format;

        return $this;
    }

    /**
     * Modifies the provided $data based on the provided $modifier.
     *
     * @param mixed $modifier
     * @param mixed $data
     *
     * @return mixed
     */
    private function modify($modifier, $data)
    {
        if (is_string($data)) {
            switch ($modifier) {
                case self::MODIFIER_LOWER:
                    $data = strtolower($data);
                    break;

                case self::MODIFIER_UPPER:
                    $data = strtoupper($data);
                    break;
            }
        }

        return $data;
    }

    /**
     * Replaces all possible $match with data out of $data in the provided $line.
     *
     * @param string &$line
     * @param array $match
     * @param array $data
     *
     * @return void
     */
    private function replace(&$line, array $match, array $data)
    {
        $modifier = false;
        $parts    = array();

        if (preg_match('/([^\|]+)\|(.+)|(.+)/', $match[1], $segments)) {
            if (isset($segments[3])) {
                $parts = explode('.', $segments[3]);
            } else {
                $parts    = explode('.', $segments[1]);
                $modifier = !empty($segments[2]) ? $segments[2] : false;
            }
        }

        foreach ($parts as $part) {
            if (!is_array($data) || !isset($data[$part])) {
                $data = '';
                break;
            }

            $data = $data[$part];
        }

        if (is_array($data)) {
            $replacement = json_encode($data, JSON_UNESCAPED_UNICODE);
            $this->replaceLine($replacement, $data);
            $data = $replacement;
        }

        $line = str_replace($match[0], $this->modify($modifier, $data), $line);
    }

    /**
     * Replaces all placesholders in the provided $line with data out of $data.
     *
     * @param string &$line
     * @param array $data
     *
     * @return void
     */
    private function replaceLine(&$line, array $data)
    {
        if (preg_match_all('/\%\#([^\s]+)\#\%/', $line, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $this->replace($line, $match, $data);
            }
        }
    }
}