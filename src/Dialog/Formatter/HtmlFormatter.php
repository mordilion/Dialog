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

        $html .= '<div class="dialog">';
        $html .= '  ' . $this->getTitle($record->getLevel(), strtoupper($record->getLevel()));
        $html .= '  <table>';

        $html .= $this->getRow('Message', $data['message']);
        $html .= $this->getRow('Time', $data['datetime']);
        $html .= $this->getRow('Context', $this->normalizeArray($record->getContext(), true));
        $html .= $this->getRow('Additional', $this->normalizeArray($record->getAdditional(), true));

        $html .= '  </table>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Returns the default CSS for the HTML layout.
     *
     * @return string
     */
    public function getCss()
    {
        $color = isset($this->levelColors[$level]) ? $this->levelColors[$level] : '#cccccc';
        $css   = '.dialog { background-color: #ffffff; color: #000000; margin-bottom: 40px; } .dialog table th, .dialog table th { padding: 5px 8px; text-align: left; }';

        foreach ($this->levelColors as $level => $color) {
            $css .= '.dialog .dialog-title-' . $level . ' { background-color: ' . $color . '; color: #ffffff; padding: 5px 10px; }';
        }

        $css .= '.dialog .dialog-row-header { background-color: #ecf0f1; } .dialog .dialog-row-description { background-color: #ffffff; }';

        return $css;
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
        $title = htmlspecialchars($title, ENT_NOQUOTES, 'UTF-8');

        return '<h1 class="dialog-title-' . $level . '">' . $title . '</h1>';
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

        return '<tr class="dialog-row"><th class="dialog-row-header">' . $header . ':</th><td class="dialog-row-description">' . $description . '</td></tr>';
    }
}