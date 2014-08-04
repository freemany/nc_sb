<?php
namespace Application\Cook\Filter;

use DateTime;

class CheckAvailability implements FilterInterface
{
    use FilterAwareTrait;

    protected $today;

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