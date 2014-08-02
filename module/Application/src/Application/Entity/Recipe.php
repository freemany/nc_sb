<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:08 AM
 */

namespace Application\Entity;


class Recipe
{
    protected $name;
    protected $ingredients = array();


    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addIngredient($ingredient)
    {
        $this->ingredients[] = $ingredient;
        return $this;
    }

    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }
}