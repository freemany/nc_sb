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
            /*'filters' => array(
                new Rename(
                    array(
                        'target'    => './data/recipes.json',
                        'overwrite' => true,
                    )
                )
            ),*/
            'validators' => array(
                new Extension(array(
                        'extension' => 'json'
                    )
                )
            )
        );
    }
}