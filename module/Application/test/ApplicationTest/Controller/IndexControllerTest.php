<?php

namespace ApplicationTest\Controller;

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

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;
    protected $serviceManager;
    protected $config;

    protected function setUp()
    {
        @copy(__DIR__.'/../../../../../data/fridge.csv',
            __DIR__.'/../../../../../data/fridge_o.csv');

        @copy(__DIR__.'/../../../../../data/recipes.json',
            __DIR__.'/../../../../../data/recipes_o.json');


        @copy(__DIR__ . '/../../data/fridge.csv',
                __DIR__.'/../../../../../data/fridge.csv');

        @copy(__DIR__ . '/../../data/recipes.json',
                __DIR__.'/../../../../../data/recipes.json');


        $this->config = Bootstrap::getConfig();
        $loader = new ModuleLoader($this->config);
        $this->serviceManager = $loader->getServiceManager();

        $this->controller = new IndexController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();
        $config = $this->serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($this->serviceManager);

        $this->setApplicationConfig( include __DIR__ . '/../../../../../config/application.config.php' );

		parent::setUp();
    }

    public function testCookAnalyzerController()
    {
        $expectedResponse = array('result'=> 'salad sandwich');

        $this->dispatch('/api/index/cook-analyzer');
        $this->assertResponseStatusCode(200);
        $content = $this->getResponse()->getContent();
        $content = json_decode($content, true);

        $this->assertEquals($expectedResponse, $content);
    }


    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('application');
        $this->assertControllerName('application\controller\index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }

    protected function tearDown()
    {
        @rename(__DIR__.'/../../../../../data/fridge_o.csv',
            __DIR__.'/../../../../../data/fridge.csv');
        @rename(__DIR__.'/../../../../../data/recipes_o.json',
            __DIR__.'/../../../../../data/recipes.json');

        parent::tearDown();
    }

 }