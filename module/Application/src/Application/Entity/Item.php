<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:05 AM
 */

namespace Application\Entity;

class Item extends EntityAbstract
{
    protected $name;
    protected $amount;
    protected $unit;
    protected $useBy;

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setUnit($unit)
    {
        $this->unit = $unit;
        return $this;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function setUseBy($useBy)
    {
        $hydrator = $this->hydrators['date'];
        $this->useBy = $hydrator($useBy);
        return $this;
    }

    public function getUseBy()
    {
        return $this->useBy;
    }
}

