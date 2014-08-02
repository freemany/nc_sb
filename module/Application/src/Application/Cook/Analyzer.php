<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:18 AM
 */

namespace Application\Cook;

use Application\Cook\Filter\FilterInterface;

class Analyzer
{
    protected $filters;
    protected $fridge;
    protected $recipes;

    protected $result = null;

    const MESSAGE = 'Order Takeout';

    public function __construct()
    {

    }

    public function setFridge($fridge)
    {
        $this->fridge = clone $fridge;
    }

    public function setRecipes($recipes)
    {
        $this->recipes = clone $recipes;
    }

    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    public function run() //run filter chain
    {
        if ($this->filters) {

            foreach($this->filters as $filter) {

                $filter->setFridge($this->fridge);
                $filter->setRecipes($this->recipes);
                $filter->run();
            }

            if ($result = $this->recipes->getRecipes()) {
                return $result[0]->getName();
            } else {
                return self::MESSAGE;
            }

        }
    }
}