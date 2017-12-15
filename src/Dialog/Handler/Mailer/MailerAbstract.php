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
     * {@inheritdoc}
     */
    abstract public function send($subejct, $content);
}