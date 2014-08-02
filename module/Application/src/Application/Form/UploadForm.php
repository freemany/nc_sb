<?php
namespace Application\Form;

use Application\Form\Element\Csv;
use Application\Form\Element\Json;
use Zend\Form\Form;

class UploadForm extends Form
{
    const NAME = 'Upload';

    public function __construct($name = self::NAME)
    {
        parent::__construct($name);

        $this->add(new Csv());
        $this->add(new Json());

    }
}