<?php

namespace Application\Service;

use Application\Entity\Recipes;
use Application\Entity\Recipe;

class RecipesService
{
    protected $recipes;
    protected $source;

    public function __construct($source = null)
    {
        $this->source = $source ? $source : __DIR__ . '/../../../../../data/recipes.json';
        $this->mapSource();
    }

    protected function mapSource()
    {
        $recipesArr = json_decode(file_get_contents($this->source));

        $this->recipes = new Recipes();

        foreach($recipesArr as $item) {
            $recipe = new Recipe();
            $recipe->setName($item->name);
            $recipe->setIngredients($item->ingredients);
            $this->recipes->addRecipe($recipe);
        }

    }

    public function getRecipes()
    {
        return $this->recipes;
    }
} 