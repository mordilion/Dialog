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

/**
 * Dialog Null-Handler-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class NullHandler extends HandlerAbstract
{
    /**
     * {@inheritdoc}
     */
    public function handle($records)
    {
        // nothing to handle
    }
}