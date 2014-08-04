<?php
namespace Application\Entity\Hydrator;

use DateTime;

class DateHydrator
{
    /**
     * @param $useBy
     * @return DateTime
     */
    public function __invoke($useBy)
    {
        $useBy = implode('-', array_reverse(explode('/',$useBy)));
        return new DateTime($useBy);
    }
}