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

use Dialog\Handler\HandlerInterface;

/**
 * Dialog Handler-Collection-Interface.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
interface CollectionInterface extends \IteratorAggregate, \Countable
{
    /**
     * Adds the provided $item to the collection.
     *
     * @param HandlerInterface $item
     *
     * @return void
     */
    public function add(HandlerInterface $item);

    /**
     * {@inheritdoc}
     */
    public function count();

    /**
     * If it finds an item with the provided $condition
     * then it returns the index, otherwise -1;
     *
     * @param callable $condition
     *
     * @return integer
     */
    public function find(callable $condition);

    /**
     * {@inheritdoc}
     */
    public function getIterator();
}