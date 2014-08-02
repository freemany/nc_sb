<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/3/14
 * Time: 12:09 AM
 */

namespace Application\Entity\Hydrator;

use DateTime;

class DateHydrator
{
    public function __invoke($useBy)
    {
        $useBy = implode('-', array_reverse(explode('/',$useBy)));
        return new DateTime($useBy);
    }
}