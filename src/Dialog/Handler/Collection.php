<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Handler;

/**
 * Dialog Handler-Collection-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class Collection implements CollectionInterface
{
    /**
     * Items of the collection.
     *
     * @var array
     */
    protected $items = array();


    /**
     * {@inheritdoc}
     */
    public function add(HandlerInterface $item)
    {
        $this->items[] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}