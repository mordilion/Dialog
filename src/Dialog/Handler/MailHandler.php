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
     * Mailer to send the messages.
     *
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * Subject-Format for the messages.
     *
     * @var string
     */
    protected $subjectFormat = '[%#datetime#%] [%#level|upper#%] %#message#%';


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
     * Returns the Subject-Format.
     *
     * @return string
     */
    public function getSubjectFormat()
    {
        return $this->subjectFormat;
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
     * Sets the Subject-Format.
     *
     * @param string $subject
     *
     * @return MailHandler
     */
    public function setSubjectFormat($format)
    {
        $this->subejctFormat = (string)$format;

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
        $subjectFormatter->setFormat($this->getSubjectFormat());

        $subject = $subjectFormatter->format($record);

        $this->getMailer()->send($subject, $this->getFormatter()->format($record));

        return $this;
    }
}