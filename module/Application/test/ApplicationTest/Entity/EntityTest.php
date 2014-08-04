<?php

namespace ApplicationTest\Entity;

use Application\Entity\Fridge;
use Application\Entity\Hydrator\DateHydrator;
use Application\Entity\Item;
use Application\Entity\Recipe;
use Application\Entity\Recipes;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class EntityTest extends AbstractHttpControllerTestCase
{

    public function testDateHydrator()
    {
        $dateStr = '23/01/2000';

        $hydrator = new DateHydrator();

        $dateObject = $hydrator($dateStr);

        $this->assertEquals($dateStr, $dateObject->format('d/m/Y'));

    }

    public function testItemAndFridgeEntity()
    {
      $name = 'bread';
      $amount = 100;
      $unit = 'slices';
      $useBy = '25/12/2004';

      $item = new Item(array('date' => new DateHydrator()));
      $item->setName($name);
      $item->setAmount($amount);
      $item->setUnit($unit);
      $item->setUseBy($useBy);

      $this->assertEquals($name, $item->getName());
      $this->assertEquals($amount, $item->getAmount());
      $this->assertEquals($unit, $item->getUnit());
      $this->assertEquals(new \DateTime('2004-12-25'), $item->getUseBy());

      $fridge = new Fridge();
      $fridge->setItem($item);
      $items = $fridge->getItems();

      $this->assertEquals(1, count($items));
      $this->assertEquals($name, $items[0]->getName());
    }

    public function testRecipeAndRecipesEntity()
    {
        $ingredientName = 'bread';

        $ingredient = new \stdClass();
        $ingredient->item = $ingredientName;
        $ingredient->amount = 2;
        $ingredient->unit = 'slices';

        $ingredients = array($ingredient);

        $name = 'salad sandwich';

        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setIngredients($ingredients);

        $recipes = new Recipes();
        $recipes->addRecipe($recipe);

        $recipesCollection = $recipes->getRecipes();

        $recipeItem = $recipesCollection[0];

        $ingredientsCollection = $recipeItem->getIngredients();

        $this->assertEquals(1, count($recipesCollection));
        $this->assertEquals(1, count($ingredientsCollection));
        $this->assertEquals($name, $recipeItem->getName());
        $this->assertEquals($ingredientName, $ingredientsCollection[0]->item);
    }

 }