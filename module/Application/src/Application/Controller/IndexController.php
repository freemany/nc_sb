<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $config = $this->getServiceLocator()->get('Config');

        return array(
            'baseUrl' => $config['domain']['url']
        );
    }

    /**
     * @return ViewModel
     */
    public function formAction()
    {

        $uploadForm = $this->getServiceLocator()->get('FormElementManager')->get('UploadForm');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $uploadForm->setData($data);

            if ($uploadForm->isValid()) {

               if (isset($_FILES['csv']))
                  move_uploaded_file($_FILES['csv']['tmp_name'], './data/fridge.csv');
                if (isset($_FILES['json']))
                move_uploaded_file($_FILES['json']['tmp_name'], './data/recipes.json');

            } else {
                $data['csv'] = null;
                $data['json'] = null;
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

    /**
     * @return JsonModel
     */
    public function deleteFilesAction()
    {
        @unlink('./data/fridge.csv');
        @unlink('./data/recipes.json');

        return new JsonModel(array(
            'result'=> 'success'
        ));
    }

    /**
     * @return JsonModel
     */
    public function cookAnalyzerAction()
    {
        $cookAnalyzer = $this->getServiceLocator()->get('CookAnalyzer');

        return new JsonModel(array(
            'result' => $cookAnalyzer->run()
        ));
    }
}
