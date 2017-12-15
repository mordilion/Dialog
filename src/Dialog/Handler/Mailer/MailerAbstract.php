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

use Dialog\Handler\Mailer\MailerInterface;

/**
 * Dialog Mailer-Abstract-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
abstract class MailerAbstract implements MailerInterface
{
    /**
     * BCC for the messages.
     *
     *@var array
     */
    protected $bcc = array();

    /**
     * CC for the messages.
     *
     *@var array
     */
    protected $cc = array();

    /**
     * Sender for the messages.
     *
     * @var array
     */
    protected $from = array('noreply@dialog.invalid');

    /**
     * Recipient for the messages.
     *
     * @var array
     */
    protected $to = array();


    /**
     * {@inheritdoc}
     */
    public function addBcc($address, $name = null)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('The provided email address "' . $address . '" is not a valid email address.');
        }

        $this->bcc[$address] = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addCc($address, $name = null)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('The provided email address "' . $address . '" is not a valid email address.');
        }

        $this->cc[$address] = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addFrom($address, $name = null)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('The provided email address "' . $address . '" is not a valid email address.');
        }

        $this->from[$address] = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTo($address, $name = null)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('The provided email address "' . $address . '" is not a valid email address.');
        }

        $this->to[$address] = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBcc($asArray = false)
    {
        $result = $this->bcc;

        if (!$asArray) {
            $result = $this->implodeAddresses($result);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getCc($asArray = false)
    {
        $result = $this->cc;

        if (!$asArray) {
            $result = $this->implodeAddresses($result);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom($asArray = false)
    {
        $result = $this->from;

        if (!$asArray) {
            $result = $this->implodeAddresses($result);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getTo($asArray = false)
    {
        $result = $this->to;

        if (!$asArray) {
            $result = $this->implodeAddresses($result);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function send($subject, $content);

    /**
     * {@inheritdoc}
     */
    public function setBcc(array $addresses)
    {
        $this->bcc = array();

        foreach ($addresses as $address => $name) {
            if (!is_string($address)) {
                $this->addBcc($name);
            } else {
                $this->addBcc($address, $name);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCc(array $addresses)
    {
        $this->cc = array();

        foreach ($addresses as $address => $name) {
            if (!is_string($address)) {
                $this->addCc($name);
            } else {
                $this->addCc($address, $name);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom(array $addresses)
    {
        $this->from = array();

        foreach ($addresses as $address => $name) {
            if (!is_string($address)) {
                $this->addFrom($name);
            } else {
                $this->addFrom($address, $name);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTo(array $addresses)
    {
        $this->to = array();

        foreach ($addresses as $address => $name) {
            if (!is_string($address)) {
                $this->addTo($name);
            } else {
                $this->addTo($address, $name);
            }
        }

        return $this;
    }

    /**
     * Returns the provided addresses array as a concated string.
     *
     * @param array $addresses
     *
     * @return string
     */
    protected function implodeAddresses(array $addresses)
    {
        $result = array();

        foreach ($addresses as $address => $name) {
            $result[] = !empty($name) && is_string($name) ? $name . '<' . $address . '>' : $address;
        }

        return implode(',', $result);
    }
}