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
     * Returns the BCC address.
     *
     * @return string|null
     */
    public function getBcc();

    /**
     * Returns the CC address.
     *
     * @return string|null
     */
    public function getCc();

    /**
     * Returns the sender address.
     *
     * @return string
     */
    public function getFrom();

    /**
     * Returns the recipient address.
     *
     * @throws \RuntimeException if no recipient is configured
     *
     * @return string
     */
    public function getTo();

    /**
     * Sends an email with the provided subject and content.
     *
     * @param string $subject
     * @param string $content
     *
     * @return boolean
     */
    public function send($subject, $content);


    /**
     * Sets the BCC address.
     *
     * @param string|null $address
     *
     * @return MailerInterface
     */
    public function setBcc($address);

    /**
     * Sets the CC address.
     *
     * @param string|null $address
     *
     * @return MailerInterface
     */
    public function setCc($address);

    /**
     * Sets the sender address.
     *
     * @param string $address
     *
     * @return MailerInterface
     */
    public function setFrom($address);

    /**
     * Sets the recipient address.
     *
     * @param string $address
     *
     * @return MailerInterface
     */
    public function setTo($address);
}