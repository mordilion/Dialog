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

use Dialog\Formatter\Formattable;
use Dialog\Formatter\HtmlFormatter;
use Dialog\Formatter\LineFormatter;
use Dialog\Handler\Mailer\MailerInterface;
use Dialog\Handler\Mailer\MailMailer;
use Dialog\Record\RecordInterface;

/**
 * Dialog Mail-Handler-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class MailHandler extends HandlerAbstract
{
    /**
     * Use the following traits.
     */
    use Formattable;


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
     * Mailer to send the messages.
     *
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * Subject for the messages.
     *
     * @var string
     */
    protected $subject = '[%#datetime#%] [%#level|upper#%] %#message#%';

    /**
     * Recipient for the messages.
     *
     * @var string
     */
    protected $to;


    /**
     * {@inheritdoc}
     */
    public function __construct($configuration = null)
    {
        $this->setDefaultFormatter(HtmlFormatter::class);

        if ($configuration != null) {
            $this->setConfiguration(new Configuration($configuration));
        }
    }

    /**
     * Returns the BCC address.
     *
     * @return string|null
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Returns the CC address.
     *
     * @return string|null
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Returns the sender address.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Returns the sender address.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Returns the mailer.
     *
     * @return MailerInterface
     */
    public function getMailer()
    {
        if (!$this->mailer instanceof MailerInterface) {
            $this->setMailer(new MailMailer());
        }

        return $this->mailer;
    }

    /**
     * Returns the subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Returns the recipient address.
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

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

            $this->send($record);
        }
    }

    /**
     * Sets the BCC address.
     *
     * @param string|null $address
     *
     * @return MailHandler
     */
    public function setTo($address)
    {
        if ($address !== null) {
            // TODO add check for a comma delimitered list
            if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException('The provided email address is not a valid email address.');
            }
        }

        $this->bcc = $address;

        return $this;
    }

    /**
     * Sets the CC address.
     *
     * @param string|null $address
     *
     * @return MailHandler
     */
    public function setCc($address)
    {
        if ($address !== null) {
            // TODO add check for a comma delimitered list
            if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException('The provided email address is not a valid email address.');
            }
        }

        $this->cc = $address;

        return $this;
    }

    /**
     * Sets the sender address.
     *
     * @param string $address
     *
     * @return MailHandler
     */
    public function setFrom($address)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('The provided email address is not a valid email address.');
        }

        $this->from = $address;

        return $this;
    }

    /**
     * Sets the mailer.
     *
     * @param MailerInterface $mailer
     *
     * @return MailHandler
     */
    public function setMailer(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

        return $this;
    }

    /**
     * Sets the subject.
     *
     * @param string $subject
     *
     * @return MailHandler
     */
    public function setSubject($subject)
    {
        $this->subejct = (string)$subject;

        return $this;
    }

    /**
     * Sets the recipient address.
     *
     * @param string $address
     *
     * @return MailHandler
     */
    public function setTo($address)
    {
        // TODO add check for a comma delimitered list
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('The provided email address is not a valid email address.');
        }

        $this->to = $address;

        return $this;
    }

    /**
     * Triggers the sending process through the mailer to the condigured recipient address.
     *
     * @param RecordInterface $record
     *
     * @return MailHandler
     */
    protected function send(RecordInterface $record)
    {
        $subjectFormatter = new LineFormatter();
        $subjectFormatter->setFormat($this->getSubject());

        $subject = $subjectFormatter->format($record);

        $this->getMailer()->send($this->getFrom(), $this->getTo(), $this->getCc(), $this->getBcc(), $subject, $this->getFormatter()->format($record));

        return $this;
    }
}