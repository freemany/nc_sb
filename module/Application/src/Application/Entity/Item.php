<?php
namespace Application\Entity;

class Item extends EntityAbstract
{
    protected $name;
    protected $amount;
    protected $unit;
    protected $useBy;

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $unit
     * @return $this
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param $useBy
     * @return $this
     */
    public function setUseBy($useBy)
    {
        $hydrator = $this->hydrators['date'];
        $this->useBy = $hydrator($useBy);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUseBy()
    {
        return $this->useBy;
    }
}

