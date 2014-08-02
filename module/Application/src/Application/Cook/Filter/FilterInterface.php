<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:11 AM
 */

namespace Application\Cook\Filter;


interface FilterInterface
{
    public function setFridge($fridge);

    public function setRecipes($recipes);

    public function run();

}