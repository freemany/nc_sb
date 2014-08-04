<?php
namespace Application\Entity;


class Recipe
{
    protected $name;
    protected $ingredients = array();

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $ingredient
     * @return $this
     */
    public function addIngredient($ingredient)
    {
        $this->ingredients[] = $ingredient;
        return $this;
    }

    /**
     * @param $ingredients
     * @return $this
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    /**
     * @return array
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
}