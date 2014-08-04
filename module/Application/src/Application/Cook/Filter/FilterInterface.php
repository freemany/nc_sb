<?php
namespace Application\Cook\Filter;


interface FilterInterface
{
    public function setFridge($fridge);

    public function setRecipes($recipes);

    public function run();

}