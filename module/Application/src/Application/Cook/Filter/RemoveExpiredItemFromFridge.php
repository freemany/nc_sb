<?php

namespace Application\Cook\Filter;

use DateTime;

class RemoveExpiredItemFromFridge implements FilterInterface
{

    use FilterAwareTrait;

    protected $today;

    public function __construct()
    {
        $this->today = new DateTime();
    }

    public function run()
    {
        $this->removeExpiredItems();
    }

    protected function removeExpiredItems()
    {
        $items = $this->fridge->getItems();
        foreach($items as $index=>$item) {
            if ($item->getUseBy()<$this->today) {
                unset($items[$index]);
            }
        }
        $this->fridge->setItems($items);
    }
}