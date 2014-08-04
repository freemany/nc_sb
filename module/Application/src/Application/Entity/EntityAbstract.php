<?php
namespace Application\Entity;

class EntityAbstract
{
    protected $hydrators;

    /**
     * @param $hydrators
     */
    public function __construct($hydrators)
    {
        $this->hydrators = $hydrators;
    }

} 