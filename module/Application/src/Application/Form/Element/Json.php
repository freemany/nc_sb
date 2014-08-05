<?php

namespace Application\Form\Element;

use Zend\Form\Element\File;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator\File\Extension;

class Json extends File implements InputProviderInterface
{
    const NAME = 'json';

    protected $label = 'Recipes (*.json)';

    public function __construct($name = self::NAME, $options = array())
    {
        parent::__construct($name, $options);
    }

    public function getInputSpecification()
    {
        return array(
            'name' => $this->getName(),
            'required' => false,
            'validators' => array(
                new Extension(array(
                        'extension' => 'json'
                    )
                )
            )
        );
    }
}