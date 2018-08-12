<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Processor;

use Dialog\Processor\ProcessorInterface;

/**
 * Dialog Processor-Collection-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface CollectionInterface extends \IteratorAggregate, \Countable
{
    /**
     * Adds the provided $item to the collection.
     *
     * @param ProcessorInterface $item
     *
     * @return void
     */
    public function add(ProcessorInterface $item);

    /**
     * {@inheritdoc}
     */
    public function count();

    /**
     * {@inheritdoc}
     */
    public function getIterator();
}