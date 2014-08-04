<?php

namespace ApplicationTest\Entity;

use Application\Entity\Hydrator\DateHydrator;
use Application\Entity\Item;
use ApplicationTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Application\Controller\IndexController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Stdlib\DateTime;
use Zend\Test\Util\ModuleLoader;

use Application\Cook\Analyzer;
use Application\Cook\Filter\CheckAvailability;
use Application\Cook\Filter\CheckClosestUseBy;
use Application\Cook\Filter\RemoveExpiredItemFromFridge;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class EntityTest extends AbstractHttpControllerTestCase
{

    public function testDateHydrator()
    {
        $dateStr = '23/01/2000';

        $hydrator = new DateHydrator();

        $dateObject = $hydrator($dateStr);

        $this->assertEquals($dateStr, $dateObject->format('d/m/Y'));

    }

    public function testItemEntity()
    {
      $name = 'bread';
      $amount = 100;
      $unit = 'slices';
      $useBy = '25/12/2004';

      $item = new Item(array('date' => new DateHydrator()));
      $item->setName($name);
      $item->setAmount($amount);
      $item->setUnit($unit);
      $item->setUseBy($useBy);

      $this->assertEquals($name, $item->getName());
      $this->assertEquals($amount, $item->getAmount());
      $this->assertEquals($unit, $item->getUnit());
      $this->assertEquals(new \DateTime('2004-12-25'), $item->getUseBy());
    }

 }