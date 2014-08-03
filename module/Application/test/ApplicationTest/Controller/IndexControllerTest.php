<?php

namespace ApplicationTest\Controller;

use ApplicationTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Application\Controller\IndexController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new IndexController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);

        $this->setApplicationConfig( include __DIR__ . '/../../../../../config/application.config.php' );

		parent::setUp();
    }
	
	/*public function testIndexActionCanBeAccessed()
   {
    $this->routeMatch->setParam('action', 'index');

    $result   = $this->controller->dispatch($this->request);
    $response = $this->controller->getResponse();

    $this->assertEquals(200, $response->getStatusCode());
   }
   
   public function testGetParameterCanBeGot()
   {
     $this->dispatch('/?name=freeman&age=30');
	 $name = $this->getRequest()->getQuery('name');
	  $age = $this->getRequest()->getQuery('age');
	 
	 $this->assertNotEquals($name, 'freemanyam not equals');
	 $this->assertEquals($age, 30, 'age equals');
   }*/

    public function testCookAnalyzerService()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $cookAnalyzer = $serviceManager->get('CookAnalyzer');
        $this->assertEquals('salad sandwich', $cookAnalyzer->run());
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
   
 }