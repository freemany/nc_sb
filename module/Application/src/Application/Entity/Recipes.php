<?php
namespace Application\Entity;

class Recipes
{

    protected $recipes = array();

    /**
     * @param $recipe
     * @return $this
     */
    public function addRecipe($recipe)
    {
        $this->recipes[] = $recipe;
        return $this;
    }

    /**
     * @param $recipes
     */
    public function setRecipes($recipes)
    {
        $this->recipes = $recipes;
    }

    /**
     * @return array
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
}