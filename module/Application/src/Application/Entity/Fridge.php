<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:07 AM
 */

namespace Application\Entity;


class Fridge
{
    protected $items = array();

    public function setItem(Item $item)
    {
        $this->items[] = $item;
        return $this;
    }

    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }
}