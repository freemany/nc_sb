<?php
namespace Application\Cook\Factory;

use Application\Cook\Analyzer;
use Application\Cook\Filter\CheckAvailability;
use Application\Cook\Filter\CheckClosestUseBy;
use Application\Cook\Filter\RemoveExpiredItemFromFridge;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AnalyzerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Analyzer|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fridge = $serviceLocator->get('FridgeService')->getFridge();
        $recipes = $serviceLocator->get('RecipesService')->getRecipes();

        $analyzer = new Analyzer();
        $analyzer->setFridge($fridge);
        $analyzer->setRecipes($recipes);

        $analyzer->addFilter(new RemoveExpiredItemFromFridge());
        $analyzer->addFilter(new CheckAvailability());
        $analyzer->addFilter(new CheckClosestUseBy());

        return $analyzer;
    }
} 