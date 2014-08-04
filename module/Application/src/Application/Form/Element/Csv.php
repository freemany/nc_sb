<?php
namespace Application\Form\Element;

use Zend\Form\Element\File;
use Zend\InputFilter\InputProviderInterface;
use Application\Validator\File\Extension;



class Csv extends File implements InputProviderInterface
{
    const NAME = 'csv';

    protected $label = 'Fridge (*.csv)';

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
                        'extension' => 'csv'
                    )
                )
            )
        );
    }
}