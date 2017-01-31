<?php

namespace Pizza\Controller;

use Application\Log\LoggerTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\ViewModel;
use Pizza\Form\PizzaForm as PizzaForm;


class PizzaController extends AbstractActionController
{

    public $modelName = 'PizzaModel';

    public $model;

    use LoggerTrait;

    public function __construct($serviceLocator, $logger = null)
    {
        $this->setServiceLocator($serviceLocator);

        if(!is_null($logger)) {
            $this->setLogger($logger);
        }


    }

    public function indexAction()
    {
        $this->loadModel($this->modelName);
        $pizzas = $this->model->fetchAll();
        $rsltCount = count($pizzas);

        $this->log(sprintf(__METHOD__ .' returned %d result%s',
            $rsltCount, (($rsltCount > 1) ? 's' : '')));

        return new ViewModel(['pizzas' => $pizzas]);
    }

    public function addAction()
    {
        $this->loadModel($this->modelName);
        $form = new PizzaForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($this->model->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->model->exchangeArray($form->getData());
                $this->model->savePizza();
                // Redirect to list of pizzas
                $flash = new FlashMessenger();
                $flash->addMessage('Saved New Pizza: "' . $form->getData()['name'] . '"','success');
                return $this->redirect()->toRoute('pizza');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('pizza', array(
                'action' => 'add'
            ));
        }

        try {
            $this->loadModel($this->modelName);
            $pizza = $this->model->fetchPizzaToppings($id);

        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('pizza', array(
                'action' => 'index'
            ));
        }

        return new ViewModel(['pizza' => $pizza]);
    }

    public function addtAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);

        parse_str($_SERVER['QUERY_STRING'], $queryParams);

        $toppingId = $queryParams['topping_id'];

        try {
            $this->loadModel($this->modelName);
            $pizza = $this->model->addToppingToPizza($toppingId,$id);
            $flash = new FlashMessenger();
            $flash->addMessage('Added Topping Id:  "' . $pizza['object']['topping_id'] . '" to your Pizza!','success');
            return $this->redirect()->toRoute('pizza', array(
                'action' => 'edit','id' => $id
            ));

        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('pizza', array(
                'action' => 'index'
            ));
        }

    }

    protected function loadModel($model = null)
    {
        //zf2 doesn't allow this operation in __construct
        //also doesn't supply a model module because 'business logic is up to you'
        $this->model = $this->serviceLocator->get($model);
    }
}
