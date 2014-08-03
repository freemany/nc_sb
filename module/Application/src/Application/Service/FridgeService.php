<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:20 AM
 */

namespace Application\Service;


use Application\Entity\Fridge;
use Application\Entity\Item;
use Application\Entity\Hydrator\DateHydrator;

class FridgeService
{
    protected $fridge;
    protected $source;

    public function __construct($source = null)
    {
        $this->source = $source ? $source : __DIR__ . '/../../../../../data/fridge.csv';

        $this->fridge = new Fridge();

        $file = fopen($this->source,"r");

        while(! feof($file))
        {
            $row = fgetcsv($file);

            $item=  new Item(array('date'=>new DateHydrator()));
            $item->setName($row[0]);
            $item->setAmount($row[1]);
            $item->setUnit($row[2]);
            $item->setUseBy($row[3]);

            $this->fridge->setItem($item);
        }
        fclose($file);
    }

    public function getFridge()
    {
        return $this->fridge;
    }
} 