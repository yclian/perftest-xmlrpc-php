<?php

require_once dirname(__FILE__).'/XmlRpcClient.php';

/**
 * Adapter wrapping the Native XML_RPC2 client.
 * 
 * @author yclian
 */
class XmlRpcClientNative extends XmlRpcClient{
    
    protected function doInitialize(){
    }
    
    protected function doExecute($method, array $args){
        
        $rt = $this->sendRequest($this->newRequest($method, $args));
        
        if ($rt && xmlrpc_is_fault($rt)){
            throw XmlRpcException($rt['faultString'], $rt['faultCode']);
        }
        
        return $rt;
    }
    
    private function newRequest($method, $args){
        return stream_context_create(array(
            'http' => array(
                'method' => "POST",
                'header' => "Content-Type: text/xml",
                'content' => xmlrpc_encode_request(
                    $method, 
                    $args
                )
            )
        ));
    }
    
    private function sendRequest($request){
        return xmlrpc_decode(file_get_contents($this->serverUri, false, $request));
    }
}
