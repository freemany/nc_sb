<?php
namespace Application\Cook\Filter;

use DateTime;

class CheckAvailability implements FilterInterface
{
    protected $fridge;
    protected $recipes;
    protected $today;

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

    public function __construct()
    {
        $this->today = new DateTime();
    }

    public function run()
    {
        $this->checkIngredientAvailable();
    }

    /**
     * @param $ingredient
     * @return bool
     */
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