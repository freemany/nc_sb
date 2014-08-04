<?php

namespace ApplicationTest\Cook;

use ApplicationTest\Bootstrap;
use Zend\Http\Response;
use Zend\Test\Util\ModuleLoader;

use Application\Cook\Filter\CheckAvailability;
use Application\Cook\Filter\CheckClosestUseBy;
use Application\Cook\Filter\RemoveExpiredItemFromFridge;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class FilterTest extends AbstractHttpControllerTestCase
{

    protected $serviceManager;

    protected $config;

    protected $testSource = array(
        array('csv'=> '/../../data/fridge_with_expired_bread.csv',
              'json' => '/../../data/recipes.json'),
        array('csv' => '/../../data/fridge.csv',
              'json'=>'/../../data/recipes_with_item_unavailable.json'),
        array('csv' => '/../../data/fridge_with_cheese_closest_useby.csv',
            'json' => '/../../data/recipes.json'),
    );

    protected static $i = 0;

    protected function setUp()
    {
        copy(__DIR__.'/../../../../../data/fridge.csv',
            __DIR__.'/../../../../../data/fridge_o.csv');

        copy(__DIR__.'/../../../../../data/recipes.json',
            __DIR__.'/../../../../../data/recipes_o.json');

        if ($this->testSource[self::$i]['csv']) {
            copy(__DIR__ . $this->testSource[self::$i]['csv'],
                __DIR__.'/../../../../../data/fridge.csv');
        }

        if ($this->testSource[self::$i]['json']) {
            copy(__DIR__ . $this->testSource[self::$i]['json'],
                __DIR__.'/../../../../../data/recipes.json');
        }

        self::$i ++;


        $this->config = Bootstrap::getConfig();
        $loader = new ModuleLoader($this->config);
        $this->serviceManager = $loader->getServiceManager();

        $this->setApplicationConfig( include __DIR__ . '/../../../../../config/application.config.php' );

        parent::setUp();
    }


    public function testRemoveExpiredItemFromFridge()
    {

        $fridge = $this->serviceManager->get('FridgeService')->getFridge();

        $originalNum = count($fridge->getItems());

        $filter = new RemoveExpiredItemFromFridge();
        $filter->setFridge($fridge);
        $filter->run();
        $fridge = $filter->getFridge();

        $this->assertEquals(count($fridge->getItems()), $originalNum - 1);

    }

    public function testCheckAvailability()
    {

        $fridge = $this->serviceManager->get('FridgeService')->getFridge();
        $recipes = $this->serviceManager->get('RecipesService')->getRecipes();

        $originalNum = count($recipes->getRecipes());

        $filter = new CheckAvailability();
        $filter->setFridge($fridge);
        $filter->setRecipes($recipes);
        $filter->run();

        $this->assertEquals(count($recipes->getRecipes()), $originalNum - 1);
    }

    public function testClosestUseBy()
    {

        $fridge = $this->serviceManager->get('FridgeService')->getFridge();
        $recipes = $this->serviceManager->get('RecipesService')->getRecipes();

        $filter = new CheckClosestUseBy();
        $filter->setFridge($fridge);
        $filter->setRecipes($recipes);
        $filter->run();

        $recipesCollection = $recipes->getRecipes();

        $this->assertEquals('grilled cheese on toast', $recipesCollection[0]->getName());
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