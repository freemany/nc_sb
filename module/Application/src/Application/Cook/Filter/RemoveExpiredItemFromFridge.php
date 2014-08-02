<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:15 AM
 */

namespace Application\Cook\Filter;

use DateTime;

class RemoveExpiredItemFromFridge implements FilterInterface
{
    //protected $fridge;
    //protected $recipes;
    use FilterAwareTrait;

    protected $today;

    public function __construct()
    {
        $this->today = new DateTime();
    }

    /*public function setFridge($fridge) {
       $this->fridge = $fridge;
    }

    public function setRecipes($recipes) {
       $this->recipes = $recipes;
    }*/

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