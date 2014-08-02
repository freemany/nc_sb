<?php
/**
 * Created by PhpStorm.
 * User: freeman
 * Date: 8/1/14
 * Time: 4:22 PM
 */

namespace Application\Form\Element;


use Zend\Form\Element\File;
use Zend\InputFilter\InputProviderInterface;
use Zend\Filter\File\Rename;
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
            /*'filters' => array(
                new Rename(
                    array(
                        'target'    => './data/fridge.csv',
                        'overwrite' => true,
                    )
                )
            ),*/
            'validators' => array(
                new Extension(array(
                        'extension' => 'csv'
                    )
                )
            )
        );
    }
}