<?php
namespace Application\Cook;

use Application\Cook\Filter\FilterInterface;

class Analyzer
{
    protected $filters;
    protected $fridge;
    protected $recipes;

    protected $result = null;

    const MESSAGE = 'Order Takeout';

    /**
     * @param $fridge
     */
    public function setFridge($fridge)
    {
        $this->fridge = clone $fridge;
    }

    /**
     * @return mixed
     */
    public function getFridge()
    {
        return $this->fridge;
    }

    /**
     * @param $recipes
     */
    public function setRecipes($recipes)
    {
        $this->recipes = clone $recipes;
    }

    /**
     * @return mixed
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @return string
     */
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