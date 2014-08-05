<?php

namespace Application\Cook\Filter;

use DateTime;

class RemoveExpiredItemFromFridge implements FilterInterface
{

    protected $fridge;
    protected $recipes;

    public function setFridge($fridge) {
        $this->fridge = $fridge;
    }

    public function getFridge() {
        return $this->fridge;
    }

    public function setRecipes($recipes) {
        $this->recipes = $recipes;
    }

    public function getRecipes() {
        return $this->recipes;
    }

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