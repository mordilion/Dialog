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
     * Adds a address to the BCC list.
     *
     * @param string $address
     * @param string|null $name
     *
     * @throws \InvalidArgumentException if the provided $address is not a valid email address
     *
     * @return MailerInterface
     */
    public function addBcc($address, $name = null);

    /**
     * Adds a address to the CC list.
     *
     * @param string $address
     * @param string|null $name
     *
     * @throws \InvalidArgumentException if the provided $address is not a valid email address
     *
     * @return MailerInterface
     */
    public function addCc($address, $name = null);

    /**
     * Adds a address to the From list.
     *
     * @param string $address
     * @param string|null $name
     *
     * @throws \InvalidArgumentException if the provided $address is not a valid email address
     *
     * @return MailerInterface
     */
    public function addFrom($address, $name = null);

    /**
     * Adds a address to the To list.
     *
     * @param string $address
     * @param string|null $name
     *
     * @throws \InvalidArgumentException if the provided $address is not a valid email address
     *
     * @return MailerInterface
     */
    public function addTo($address, $name = null);

    /**
     * Returns the BCC addresses.
     *
     * @param booelan $asArray
     *
     * @return array|string
     */
    public function getBcc($asArray = false);

    /**
     * Returns the CC addresses.
     *
     * @param booelan $asArray
     *
     * @return array|string
     */
    public function getCc($asArray = false);

    /**
     * Returns the sender addresses.
     *
     * @param booelan $asArray
     *
     * @return array|string
     */
    public function getFrom($asArray = false);

    /**
     * Returns the recipient addresses.
     *
     * @param booelan $asArray
     *
     * @return array|string
     */
    public function getTo($asArray = false);

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
     * Sets the BCC addresses.
     *
     * @param array $addresses
     *
     * @return MailerInterface
     */
    public function setBcc(array $addresses);

    /**
     * Sets the CC addresses.
     *
     * @param array $addresses
     *
     * @return MailerInterface
     */
    public function setCc(array $addresses);

    /**
     * Sets the sender addressse.
     *
     * @param array $addresses
     *
     * @return MailerInterface
     */
    public function setFrom(array $addresses);

    /**
     * Sets the recipient addresses.
     *
     * @param array $addresses
     *
     * @return MailerInterface
     */
    public function setTo(array $addresses);
}