<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Processor;

/**
 * Dialog Processor-Collection-Class.
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
    public function add(ProcessorInterface $item)
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
    public function find(callable $condition)
    {
        foreach ($this as $key => $item) {
            if ($condition($item)) {
                return $key;
            }
        }

        return -1;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}