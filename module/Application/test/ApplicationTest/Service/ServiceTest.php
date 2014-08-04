<?php

namespace ApplicationTest\Service;

use ApplicationTest\Bootstrap;
use Zend\Http\Response;
use Zend\Test\Util\ModuleLoader;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ServiceTest extends AbstractHttpControllerTestCase
{

    protected $serviceManager;

    protected $config;

    protected $testSource = array(
        array('csv'=> '', 'json' => ''),
        array('csv' => '/../../data/fridge_with_expired_bread.csv', 'json'=>''),
        array('csv' => '', 'json'=>'/../../data/recipes_with_item_amount_insufficient.json'),
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


    public function testCookAnalyzerService()
    {
        $cookAnalyzer = $this->serviceManager->get('CookAnalyzer');
        $this->assertEquals('salad sandwich', $cookAnalyzer->run());
    }

    public function testCookAnalyzerServiceWithExpiredBread()
    {

        $cookAnalyzer = $this->serviceManager->get('CookAnalyzer');
        $this->assertEquals('Order Takeout', $cookAnalyzer->run());

    }

    public function testCookAnalyzerServiceWithItemAmountInsufficient()
    {
        $cookAnalyzer = $this->serviceManager->get('CookAnalyzer');
        $this->assertEquals('grilled cheese on toast', $cookAnalyzer->run());
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