<?php

namespace ApplicationTest\Cook;

use ApplicationTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Application\Controller\IndexController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\Util\ModuleLoader;

use Application\Cook\Analyzer;
use Application\Cook\Filter\CheckAvailability;
use Application\Cook\Filter\CheckClosestUseBy;
use Application\Cook\Filter\RemoveExpiredItemFromFridge;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class FilterTest extends AbstractHttpControllerTestCase
{

    protected $serviceManager;

    protected $config;

    protected function setUp()
    {
        $this->serviceManager = Bootstrap::getServiceManager();
        $this->config = Bootstrap::getConfig();

        $this->setApplicationConfig( include __DIR__ . '/../../../../../config/application.config.php' );

        copy(__DIR__.'/../../../../../data/fridge.csv',
            __DIR__.'/../../../../../data/fridge_o.csv');
        copy(__DIR__.'/../../../../../data/recipes.json',
            __DIR__.'/../../../../../data/recipes_o.json');

		parent::setUp();
    }


    public function testRemoveExpiredItemFromFridge()
    {
        copy(__DIR__.'/../../data/fridge_with_expired_bread.csv',
            __DIR__.'/../../../../../data/fridge.csv');

        /** Generate new services for testing only as all existing services are singletons. **/
        $loader = new ModuleLoader($this->config);
        $serviceLocator = $loader->getServiceManager();

        $fridge = $serviceLocator->get('FridgeService')->getFridge();

        $originalNum = count($fridge->getItems());

        $filter = new RemoveExpiredItemFromFridge();
        $filter->setFridge($fridge);
        $filter->run();
        $fridge = $filter->getFridge();

        $this->assertEquals(count($fridge->getItems()), $originalNum - 1);

    }

    public function testCheckAvailability()
    {
        copy(__DIR__.'/../../data/recipes_with_item_unavailable.json',
            __DIR__.'/../../../../../data/recipes.json');


        $loader = new ModuleLoader($this->config);
        $serviceLocator = $loader->getServiceManager();

        $fridge = $serviceLocator->get('FridgeService')->getFridge();
        $recipes = $serviceLocator->get('RecipesService')->getRecipes();

        $originalNum = count($recipes->getRecipes());

        $filter = new CheckAvailability();
        $filter->setFridge($fridge);
        $filter->setRecipes($recipes);
        $filter->run();

        $this->assertEquals(count($recipes->getRecipes()), $originalNum - 1);
    }

    protected function tearDown()
    {
        rename(__DIR__.'/../../../../../data/fridge_o.csv',
            __DIR__.'/../../../../../data/fridge.csv');
        rename(__DIR__.'/../../../../../data/recipes_o.json',
            __DIR__.'/../../../../../data/recipes.json');

        parent::tearDown();
    }
 }