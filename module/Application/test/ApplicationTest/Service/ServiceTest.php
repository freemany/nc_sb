<?php

namespace ApplicationTest\Service;

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

class ServiceTest extends AbstractHttpControllerTestCase
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

		parent::setUp();
    }


    public function testCookAnalyzerService()
    {
        $cookAnalyzer = $this->serviceManager->get('CookAnalyzer');
        $this->assertEquals('salad sandwich', $cookAnalyzer->run());
    }

    public function testCookAnalyzerServiceWithExpiredBread()
    {
        copy(__DIR__.'/../../data/fridge_with_expired_bread.csv',
             __DIR__.'/../../../../../data/fridge.csv');

        /** Generate new services for testing only as all existing services are singletons. **/
        $loader = new ModuleLoader($this->config);
        $serviceManager = $loader->getServiceManager();

        $cookAnalyzer = $serviceManager->get('CookAnalyzer');
        $this->assertEquals('Order Takeout', $cookAnalyzer->run());

    }

    protected function tearDown()
    {
        rename(__DIR__.'/../../../../../data/fridge_o.csv',
            __DIR__.'/../../../../../data/fridge.csv');
        parent::tearDown();
    }

 }