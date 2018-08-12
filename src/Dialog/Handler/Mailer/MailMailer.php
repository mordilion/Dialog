<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Handler\Mailer;

use Dialog\Handler\Mailer\MailerAbstract;

/**
 * Dialog Mail-Mailer.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class MailMailer extends MailerAbstract
{
    /**
     * {@inheritdoc}
     */
    public function send($subject, $content)
    {
        $header = '';

        $header .= 'MIME-Version: 1.0' . PHP_EOL;
        $header .= 'Content-Type: ' . $this->getContentType($content) . PHP_EOL;

        $header .= 'From: ' . $this->getFrom() . PHP_EOL;
        $header .= 'Cc: ' . $this->getCc() . PHP_EOL;
        $header .= 'Bcc: ' . $this->getBcc() . PHP_EOL;

        mail($this->getTo(), $subject, $content, $header);
    }

    /**
     * Returns the content type for the provided content.
     *
     * @param string $content
     *
     * @return string
     */
    private function getContentType($content)
    {
        if (substr(trim($content), 0, 1) == '<') {
            return 'text/html; charset=UTF-8';
        }

        return 'text/plain; charset=UTF-8';
    }
}