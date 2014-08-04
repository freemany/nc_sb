<?php
namespace Application\Entity;


class Fridge
{
    protected $items = array();

    /**
     * @param Item $item
     * @return $this
     */
    public function setItem(Item $item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}