<?php

namespace ApplicationTest\Entity;

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

class EntityTest extends AbstractHttpControllerTestCase
{

    protected $serviceManager;

    protected function setUp()
    {
        $this->serviceManager = Bootstrap::getServiceManager();

        $this->setApplicationConfig( include __DIR__ . '/../../../../../config/application.config.php' );

        copy(__DIR__.'/../../../../../data/fridge.csv',
            __DIR__.'/../../../../../data/fridge_o.csv');

		parent::setUp();
    }


    public function testItemEntity()
    {

    }


    protected function tearDown()
    {
        rename(__DIR__.'/../../../../../data/fridge_o.csv',
            __DIR__.'/../../../../../data/fridge.csv');
        parent::tearDown();
    }
 }