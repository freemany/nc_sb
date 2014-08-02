<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:12 AM
 */

namespace Application\Cook\Filter;


trait FilterAwareTrait
{
    protected $fridge;
    protected $recipes;

    public function setFridge($fridge) {
        $this->fridge = $fridge;
    }

    public function setRecipes($recipes) {
        $this->recipes = $recipes;
    }
}