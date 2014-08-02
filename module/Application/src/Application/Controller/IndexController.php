<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function formAction()
    {


        $success = false;

        $uploadForm = $this->getServiceLocator()->get('FormElementManager')->get('UploadForm');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $uploadForm->setData($data);

            if ($uploadForm->isValid()) {



                $this->flashMessenger()->addSuccessMessage(
                    'Upload. thanks.'
                );

                $success = true;
                //$this->redirect()->refresh();
            }
        }

        if (file_exists('./data/fridge.csv')) {
            $csv = file_get_contents('./data/fridge.csv');
        } else {
            $csv = false;
        }

        if (file_exists('./data/recipes.json')) {
            $json = file_get_contents('./data/recipes.json');
        } else {
            $json = false;
        }

        $viewModel = new ViewModel(array(
            'uploadForm' => $uploadForm,
            'csv' => $csv,
            'json' => $json,
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
    }
}
