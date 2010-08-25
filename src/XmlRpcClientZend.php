<?php

require_once dirname(__FILE__).'/XmlRpcClient.php';
require_once dirname(__FILE__).'/../vendor/Zend/library/Zend/Loader/Autoloader.php';
require_once dirname(__FILE__).'/../vendor/Zend/library/Zend/XmlRpc/Client.php';

use Zend\Loader;
use Zend\XmlRpc;

$autoloader = Loader\Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true); 

/**
 * Adapter wrapping the Zend XML-RPC Client.
 * 
 * @author yclian
 */
class XmlRpcClientZend extends \XmlRpcClient{
    
    /**
     * @var XmlRpc\Client
     */
    private $client;
    
    protected function doInitialize(){
        $this->client = new XmlRpc\Client($this->serverUri);
    }
    
    protected function doExecute($method, array $args){
        
        try{
            return $this->client->call($method, $args);
        } catch(\Exception $e){
            throw new \XmlRpcException($e->getMessage(), $e->getCode());
        }
    }
}
