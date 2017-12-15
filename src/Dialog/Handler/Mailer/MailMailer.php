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

use Dialog\Handler\Mailer\MailerAbstract;

/**
 * Dialog Mail-Mailer.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class MailMailer extends MailerAbstract
{
    /**
     * BCC for the messages.
     *
     *@var string|null
     */
    protected $bcc;

    /**
     * CC for the messages.
     *
     *@var string|null
     */
    protected $cc;

    /**
     * Sender for the messages.
     *
     * @var string
     */
    protected $from = 'noreply@dialog.invalid';

    /**
     * Recipient for the messages.
     *
     * @var string
     */
    protected $to;


    /**
     * {@inheritdoc}
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * {@inheritdoc}
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * {@inheritdoc}
     */
    public function getTo()
    {
        if (empty($this->to)) {
            throw new \RuntimeException('There is no recipient configured.');
        }

        return $this->to;
    }

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
     * {@inheritdoc}
     */
    public function setBcc($address)
    {
        if ($address !== null) {
            $addresses = explode(',', $address);

            foreach ($addresses as $addr) {
                if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
                    throw new \InvalidArgumentException('The provided email address "' . $addr . '" is not a valid email address.');
                }
            }
        }

        $this->bcc = $address;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCc($address)
    {
        if ($address !== null) {
            $addresses = explode(',', $address);

            foreach ($addresses as $addr) {
                if (!filter_var($addr, FILTER_VALIDATE_EMAIL)) {
                    throw new \InvalidArgumentException('The provided email address "' . $addr . '" is not a valid email address.');
                }
            }
        }

        $this->cc = $address;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom($address)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('The provided email address "' . $address . '" is not a valid email address.');
        }

        $this->from = $address;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTo($address)
    {
        $addresses = explode(',', $address);

        foreach ($addresses as $addr) {
            if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException('The provided email address "' . $addr . '" is not a valid email address.');
            }
        }

        $this->to = $address;

        return $this;
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