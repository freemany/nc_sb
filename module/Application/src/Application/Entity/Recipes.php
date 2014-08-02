<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:09 AM
 */

namespace Application\Entity;

class Recipes
{

    protected $recipes = array();

    public function addRecipe($recipe)
    {
        $this->recipes[] = $recipe;
        return $this;
    }

    public function setRecipes($recipes)
    {
        $this->recipes = $recipes;
    }

    public function getRecipes()
    {
        return $this->recipes;
    }
}