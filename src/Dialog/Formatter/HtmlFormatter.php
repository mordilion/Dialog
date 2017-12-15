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

use Psr\Log\LogLevel;
use Dialog\Record\RecordInterface;

/**
 * Dialog HTML-Formatter-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class HtmlFormatter extends FormatterAbstract
{
    /**
     * Use the following traits.
     */
    use Normalizeable;


    /**
     * LogLevel to Colors mapping.
     *
     * @var string
     */
    protected $levelColors = array(
        LogLevel::EMERGENCY => '#2c3e50',
        LogLevel::ALERT     => '#8e44ad',
        LogLevel::CRITICAL  => '#c0392b',
        LogLevel::ERROR     => '#d35400',
        LogLevel::WARNING   => '#f39c12',
        LogLevel::NOTICE    => '#2980b9',
        LogLevel::INFO      => '#27ae60',
        LogLevel::DEBUG     => '#bdc3c7'
    );


    /**
     * {@inheritdoc}
     */
    public function format(RecordInterface $record)
    {
        $data = $this->normalize($record);
        $html = '';

        $html .= '<div style="background-color: #ffffff; color: #000000; margin-bottom: 40px;">';
        $html .= '  ' . $this->getTitle($record->getLevel(), strtoupper($record->getLevel()));
        $html .= '  <table>';

        $html .= $this->getRow('Message', $data['message']);
        $html .= $this->getRow('Time', $data['datetime']);
        $html .= $this->getRow('Context', $this->normalizeArray($record->getContext(), true));
        $html .= $this->getRow('Additional', $this->normalizeArray($record->getAdditional(), true));
        $html .= $this->getRow('Backtrace', $this->normalizeArray($record->getBacktrace(), true));

        $html .= '  </table>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Returns the HTML code for a h1 title tag.
     *
     * @param string $level
     * @param string $title
     *
     * @return string
     */
    protected function getTitle($level, $title)
    {
        $color = isset($this->levelColors[$level]) ? $this->levelColors[$level] : '#eeeeee';
        $title = htmlspecialchars($title, ENT_NOQUOTES, 'UTF-8');

        return '<h1 style="background-color: ' . $color . '; color: #ffffff; padding: 5px 10px;">' . $title . '</h1>';
    }

    /**
     * Returns the HTML code for one table row.
     *
     * @param string $header
     * @param string $description
     * @param boolean $escapeDescription
     *
     * @return string
     */
    protected function getRow($header, $description, $escapeDescription = true)
    {
        $header = htmlspecialchars($header);

        if ($escapeDescription) {
            $description = htmlspecialchars($description);
        }

        return '<tr style="padding: 5px 8px;"><th style="background-color: #ecf0f1; text-align: left;">' . $header . ':</th><td style="background-color: #ffffff; text-align: left;"><pre>' . $description . '</pre></td></tr>';
    }
}