<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Handler\Mailer;

/**
 * Dialog Mailer-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface MailerInterface
{
    /**
     * Sends an email with the provided information.
     *
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $content
     *
     * @return boolean
     */
    public function send($from, $to, $subject, $content);
}