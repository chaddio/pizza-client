<?php

namespace Application\Service;

use Application\Log\LoggerTrait;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Db\ResultSet\ResultSet; //KEEP
use Zend\Stdlib\Exception\InvalidArgumentException;

class PizzaApiService
{
    use ServiceLocatorAwareTrait;
    use LoggerTrait;

    protected $serviceUrl = 'https://localhost';

    
    public function __construct($serviceLocator, $logger = null)
    {
        $this->setServiceLocator($serviceLocator);

        if(!is_null($logger)) {
            $this->setLogger($logger);
        }
    }

    public function fetchAll($uri,$assoc = false)
    {
        $request=new Request();
        $requestBody="";

        $request->getHeaders()->addHeaders([
            'Content-Type: application/json',
            'Accept: application/json'
        ]);


        $request->setMethod(Request::METHOD_GET);

        $request->setUri($this->serviceUrl . '/' . $uri);
        $request->setContent($requestBody);


        $httpClient = new Client();
        $response = $httpClient->send($request);
        $responseBody=$response->getBody();

        $response = json_decode($responseBody,$assoc);
        return $response;
    }

    public function getToppingsForPizza($id)
    {
        $request=new Request();
        $requestBody="";

        $request->getHeaders()->addHeaders([
            'Content-Type: application/json',
            'Accept: application/json'
        ]);


        $request->setMethod(Request::METHOD_GET);

        $request->setUri($this->serviceUrl . '/pizzas/' . $id . '/toppings');
        $request->setContent($requestBody);


        $httpClient = new Client();
        $response = $httpClient->send($request);
        $responseBody=$response->getBody();

        $response = json_decode($responseBody,true);

        return $response;
    }

    public function addPizza($name,$description)
    {
        // print_r($params);
        $request=new Request();
        $requestBody = '{"pizza" : {"name" : "' . $name . '", "description" : "' . $description . '"}}';

        $request->getHeaders()->addHeaders([
            'Content-Type: application/json',
            'Accept: application/json'
        ]);


        $request->setMethod(Request::METHOD_POST);

        $request->setUri($this->serviceUrl . '/pizzas');
        $request->setContent($requestBody);


        $httpClient = new Client();
        $response = $httpClient->send($request);
        $responseBody=$response->getBody();

        $response = json_decode($responseBody);
        return $response;
    }

    public function addTopping($name)
    {
        // print_r($params);
        $request=new Request();
        $requestBody = '{"topping" : {"name" : "' . $name . '"}}';

        $request->getHeaders()->addHeaders([
            'Content-Type: application/json',
            'Accept: application/json'
        ]);


        $request->setMethod(Request::METHOD_POST);

        $request->setUri($this->serviceUrl . '/toppings');
        $request->setContent($requestBody);


        $httpClient = new Client();
        $response = $httpClient->send($request);
        $responseBody=$response->getBody();

        $response = json_decode($responseBody);
        return $response;
    }

    public function addToppingToPizza($toppingId,$pizzaId)
    {
        // print_r($params);
        $request=new Request();
        $requestBody = '{"topping_id" : "' . $toppingId . '"}';

        $request->getHeaders()->addHeaders([
            'Content-Type: application/json',
            'Accept: application/json'
        ]);


        $request->setMethod(Request::METHOD_POST);

        $request->setUri($this->serviceUrl . '/pizzas/' . $pizzaId . '/toppings');
        $request->setContent($requestBody);


        $httpClient = new Client();
        $response = $httpClient->send($request);
        $responseBody=$response->getBody();

        $response = json_decode($responseBody,true);

        return $response;
    }

}