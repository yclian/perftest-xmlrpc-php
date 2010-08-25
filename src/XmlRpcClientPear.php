<?php

require_once dirname(__FILE__).'/XmlRpcClient.php';
require_once dirname(__FILE__).'/../vendor/XML_RPC2/XML/RPC2/Client.php';

/**
 * Adapter wrapping the PEAR XML_RPC2 client.
 * 
 * @author yclian
 */
class XmlRpcClientPear extends XmlRpcClient{
    
    /**
     * @var XML_RPC2_Client
     */
    private $client;
    
    protected function doInitialize(){
        // $this->client = XML_RPC2_Client::create($this->serverUri, array());
    }
    
    protected function doExecute($method, array $args){
        
        $this->client = XML_RPC2_Client::create(
            $this->serverUri,
            array(
                'prefix' => substr($method, 0, strpos($method, '.') + 1)
            )
        );
        
        try{
            return call_user_func_array(
                array(
                    $this->client,
                    substr($method, strpos($method, '.') + 1)
                ),
                $args
            );
        } catch(XML_RPC2_FaultException $xrf){
            throw new XmlRpcException($xrf->getFaultString(), $xrf->getFaultCode());
        }
    }
}
