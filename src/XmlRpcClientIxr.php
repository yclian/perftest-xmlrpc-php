<?php

require_once dirname(__FILE__).'/XmlRpcClient.php';
require_once dirname(__FILE__).'/../vendor/IXR/IXR_Library.php';

/**
 * Adapter wrapping the Inutio XML-RPC client.
 * 
 * @author yclian
 */
class XmlRpcClientIxr extends XmlRpcClient{
    
    /**
     * @var IXR_Client
     */
    private $client;
    
    protected function doInitialize(){
        $this->client = new IXR_Client($this->serverUri);
    }
    
    protected function doExecute($method, array $args){
        
        array_unshift($args, $method);
        
        if(!call_user_func_array(
            array($this->client, 'query'),
            $args
        )){
            throw new XmlRpcException($this->client->getErrorMessage(), $this->client->getErrorCode());
        } else{
            return $this->client->getResponse();
        }
    }
}
