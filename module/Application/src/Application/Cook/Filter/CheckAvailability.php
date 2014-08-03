<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:17 AM
 */

namespace Application\Cook\Filter;

use DateTime;

class CheckAvailability implements FilterInterface
{
    use FilterAwareTrait;
    //protected $fridge;
    //protected $recipes;

    protected $today;

    public function __construct()
    {
        $this->today = new DateTime();
    }

    //public function setFridge($fridge) {
    //$this->fridge = $fridge;
    //}

    //public function setRecipes($recipes) {
    //$this->recipes = $recipes;
    //}

    public function run()
    {
        //$this->removeExpiredItems();
        $this->checkIngredientAvailable();
    }

    /*protected function removeExpiredItems()
    {
        $items = $this->fridge->getItems();
        foreach($items as $index=>$item) {
            if ($item->getUseBy()<$this->today) {
                unset($items[$index]);
            }
        }
        $this->fridge->setItems($items);

    }*/

    protected function checkAvailable($ingredient) {
        foreach($this->fridge->getItems() as $item) {

            if ($item->getName() == $ingredient->item && $item->getAmount()>= $ingredient->amount && $item->getUnit() == $ingredient->unit) {
                $ingredient->useBy = $item->getUseBy();
                return true;
            }
        }

        return false;
    }

    protected function checkIngredientAvailable()
    {
        $recipes = $this->recipes->getRecipes();
        foreach($recipes as $index=>$recipe) {
            $available = true;
            foreach($recipe->getIngredients() as $ingredient) {

                if (!$this->checkAvailable($ingredient)) {
                    $available = false;
                    break;
                }
            }
            if ($available == false) {
                unset($recipes[$index]);

            }
        }

        $this->recipes->setRecipes($recipes);
    }
}