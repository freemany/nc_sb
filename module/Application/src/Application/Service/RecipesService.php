<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:20 AM
 */

namespace Application\Service;


use Application\Entity\Recipes;
use Application\Entity\Recipe;

class RecipesService
{
    protected $source = './data/recipes.json';

    protected $recipes;

    public function __construct()
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