<?php

namespace Topping\Controller;

use Application\Log\LoggerTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\ViewModel;
use Topping\Form\ToppingForm as ToppingForm;


class ToppingController extends AbstractActionController
{

    public $modelName = 'PizzaModel';

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
        $toppings = $this->model->fetchAllToppings();
        $rsltCount = count($pizzas);

        $this->log(sprintf(__METHOD__ .' returned %d result%s',
            $rsltCount, (($rsltCount > 1) ? 's' : '')));

        return new ViewModel(['toppings' => $toppings]);
    }

    public function addAction()
    {
        $this->loadModel($this->modelName);
        $form = new ToppingForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($this->model->getInputFilter('topping'));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->model->exchangeArray($form->getData());
                $this->model->saveTopping();
                $flash = new FlashMessenger();
                $flash->addMessage('Saved New Topping: "' . $form->getData()['name'] . '"','success');
                // Redirect to list of pizzas
                return $this->redirect()->toRoute('topping');
            }
        }
        return array('form' => $form);
    }

    protected function loadModel($model = null)
    {
        //zf2 doesn't allow this operation in __construct
        //also doesn't supply a model module because 'business logic is up to you'
        $this->model = $this->serviceLocator->get($model);
    }
}
