<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:04 AM
 */

namespace Application\Entity;

class EntityAbstract
{
    protected $hydrators;

    public function __construct($hydrators)
    {
        $this->hydrators = $hydrators;
    }

} 