<?php

namespace AppBundle\Service;
use Symfony\Component\HttpFoundation\Response;
use USPS\ServiceDeliveryCalculator;
use USPS\AddressVerify;
/**
 * Class UspsShippingHandler
 * @package AppBundle\Service
 */
class UspsShippingHandler
{
    /**
     * @var userID , testMode
     */
    private  $userID;
    private  $testMode;
    public   $message;
    /**
     * UspsShippingHandler constructor.
     * @param bool $testMode
     * @param $userID
     */
    public function __construct($testMode = false , $userID)
    {
        $this->userID = $userID;
        $this->testMode = $testMode;
    }

    /**
     * Function for get rate of shapping
     * @param $func_params
     * @return string
     */
    public function GetRate($func_params , $auth_params){
        try {

            if (!isset($func_params)) {
                return "An exception ocurred, Parameteres array can't be empty.";
            } else {
                if (!isset($func_params["zipCode"]) && empty($func_params["state"])) {
                    return "An exception ocurred, Shipping Service can't be empty.";
                }
            }
            // Initiate and set the username provided from usps
            $delivery = new ServiceDeliveryCalculator($this->testMode);
            // During test mode this seems not to always work as expected
            $delivery->setTestMode($this->testMode);
            // Add the zip code we want to lookup the city and state
            $delivery->addRoute(3,$func_params["zipCode"], $func_params["state"]);

            $this->message['Rete'] =  $delivery->getServiceDeliveryCalculation();

        }catch (Exception $e) {
            $this->message['Error'] =  'Caught exception: '. $e->getMessage(). "\n";
        }

        $this->prepareJSONResponseMessage($this->message,"json") ;
    }

    /**
     * function for Address Verify
     * @param $func_params
     * @return string
     */
    public function AddressVerify($func_params , $auth_params)
    {
        try {

            if (!isset($func_params)) {
                 return "An exception ocurred, Parameteres array can't be empty.";
            } else {
                if (
                    !isset($func_params["FirmName"]) && empty($func_params["FirmName"]) &&
                    !isset($func_params["Apt"]) && empty($func_params["Apt"]) &&
                    !isset($func_params["Address"]) && empty($func_params["Address"]) &&
                    !isset($func_params["City"]) && empty($func_params["City"]) &&
                    !isset($func_params["State"]) && empty($func_params["State"]) &&
                    !isset($func_params["Zip5"]) && empty($func_params["Zip5"])
                ) {
                    return "An exception ocurred, Shipping Service can't be empty.";
                }
            }
            // Initiate and set the username provided from usps
            $verify = new AddressVerify($this->userID);

            // During test mode this seems not to always work as expected
            $verify->setTestMode($this->testMode);
            $address = new \USPS\Address();
            $address->setFirmName($func_params['FirmName']);
            $address->setApt($func_params['Apt']);
            $address->setAddress($func_params['Address']);
            $address->setCity($func_params['City']);
            $address->setState($func_params['State']);
            $address->setZip5($func_params['Zip5']);
            $address->setZip4($func_params['Zip4']);

            // Add the address object to the address verify class
            $verify->addAddress($address);
            $verify->verify();

            // See if it was successful
            if ($verify->isSuccess()) {
                $this->message = "This IS Valid Address";
            } else {
                $this->message = 'Error: '.$verify->getErrorMessage();
            }
            return $this->prepareJSONResponseMessage($this->message,"json") ;

        }catch (Exception $e) {
            $this->message = 'Caught exception: '. $e->getMessage(). "\n";
            return  $this->prepareJSONResponseMessage($this->message,"json") ;
        }


    }
    protected function prepareJSONResponseMessage($message, $messageType, $itemsCount = 0, $returnType = 2)
    {
        if($returnType == 1)
        {
            $response = new Response('{"Message":"'.$messageType.'", "Result":'.$message.', "ItemsCount":"'.$itemsCount.'"}');
            return $response;
        }
        else
        {//Set the headers for the response
            $response = new Response('{"Message":"'.$messageType.'", "Result":'.$message.', "ItemsCount":"'.$itemsCount.'"}');
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
}