<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:13 AM
 */

namespace Application\Cook\Filter;

use DateTime;

class CheckClosestUseBy implements FilterInterface
{
    use FilterAwareTrait;
    //protected $fridge;
    //protected $recipes;

    protected $itemUseBy =array();
    protected $diffDays = array();

    protected $today;

    public function __construct()
    {
        $this->today = new DateTime();
    }

    //public function setFridge($fridge) {
    //$this->fridge = $fridge;
    //}

    // public function setRecipes($recipes) {
    //$this->recipes = $recipes;
    // }

    public function run()
    {
        $recipes =$this->recipes->getRecipes();
        if (count($recipes) <= 1) {
            return $this->recipes;
        }

        $this->populateItemUseBy();
        $this->getClosestUseBy();
        $this->compareDiff();
    }

    protected function populateItemUseBy()
    {
        foreach($this->fridge->getItems() as $item) {
            $this->itemUseBy[$item->getName()] = $item->getUseBy();
        }

    }

    protected function getClosestUseBy()
    {
        foreach($this->recipes->getRecipes() as $recipe) {

            foreach($recipe->getIngredients() as $index=>$ingredient) {

              $useByDiff = $this->itemUseBy[$ingredient->item]->diff($this->today)->days;

              if ($index == 0) {
                  $closestUseBy = $useByDiff;
              } else {
                  if ($closestUseBy > $useByDiff) {
                      $closestUseBy = $useByDiff;
                  }
              }

            }
            $this->diffDays[] = $closestUseBy;
        }

    }

    protected function compareDiff()
    {
        asort($this->diffDays);
        $index = key($this->diffDays);

        $recipes = $this->recipes->getRecipes();
        $this->recipes->setRecipes(array($recipes[$index]));
    }
}