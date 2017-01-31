<?php

namespace Pizza\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class PizzaModel
{
    use ServiceLocatorAwareTrait;

    public $id;
    public $name;
    public $description;

    public function __construct($serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
    }

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->description  = (!empty($data['description'])) ? $data['description'] : null;
    }

    public function fetchAll()
    {
        $apiService = $this->serviceLocator->get('PizzaApiService');
        $results = $apiService->fetchAll('pizzas');

        return $results;

    }

    public function fetchAllToppings()
    {
        $apiService = $this->serviceLocator->get('PizzaApiService');
        $results = $apiService->fetchAll('toppings');

        return $results;

    }

    public function fetchPizzaToppings($pizzaId)
    {
        $apiService = $this->serviceLocator->get('PizzaApiService');

        $pizzaToppings = $apiService->getToppingsForPizza($pizzaId);

        $allPizzas = $apiService->fetchAll('pizzas',true);

        foreach($allPizzas as $key => $value){
            if($value['id'] == $pizzaId){
                $pizza = $allPizzas[$key];
            }
        }
        unset($allPizzas);

        $allToppings = $apiService->fetchAll('toppings',true);


        //TODO abstract to better
        foreach($allToppings as $key => $value){

            foreach($pizzaToppings as $k => $v){
                if($value['id'] == $v['topping_id']){
                    unset($allToppings[$key]);
                }
            }
        }

        $pizza['toppings'] = $pizzaToppings;

        $pizza['available_toppings'] = $allToppings;

        return $pizza;
    }

    public function savePizza()
    {
        $apiService = $this->serviceLocator->get('PizzaApiService');
        $result = $apiService->addPizza($this->name,$this->description);

        return $result;
    }

    public function addToppingToPizza($toppingId,$id)
    {
        $apiService = $this->serviceLocator->get('PizzaApiService');
        $result = $apiService->addToppingToPizza($toppingId,$id);

        return $result;
    }

    public function saveTopping()
    {
        $apiService = $this->serviceLocator->get('PizzaApiService');
        $result = $apiService->addTopping($this->name);

        return $result;
    }

    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter($type = null)
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();


            $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));
            if($type != 'topping') {
                $inputFilter->add(array(
                    'name' => 'description',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 100,
                            ),
                        ),
                    ),
                ));
            }

            $inputFilter->add(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }


}
