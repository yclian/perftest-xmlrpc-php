<?php

require_once dirname(__FILE__).'/XmlRpcClient.php';
require_once dirname(__FILE__).'/../vendor/PHP-XMLRPC/xmlrpc/lib/xmlrpc.inc';
require_once dirname(__FILE__).'/../vendor/PHP-XMLRPC/xmlrpc/lib/xmlrpc_wrappers.inc';

/**
 * Adapter wrapping the PHP XML-RPC Client.
 * 
 * @author yclian
 */
class XmlRpcClientPhpXmlRpc extends XmlRpcClient{
    
    /**
     * @var xmlrpc_client
     */
    private $client;
    
    protected function doInitialize(){
        $this->client = new xmlrpc_client($this->serverUri);
    }
    
    protected function doExecute($method, array $args){
        
        if($result = $this->client->send(new xmlrpcmsg(
            $method,
            $this->convertToXmlRpcVals($args)
        ))){
            return $result->value();
        } else{
            throw new XmlRpcException($result->faultString(), $result->faultCode());
        }
    }
    
    private function convertToXmlRpcVals(array $vals){
        $rt = array();
        foreach($vals as $val){
            
            $type = $this->convertToXmlRpcType($val);
            
            switch($type){
                
                case 'array': 
                case 'struct':{
                    array_walk($val, create_function(
                        '&$v, $k', '
$v = new xmlrpcval($v, php_2_xmlrpc_type(gettype($v)));
                    '));
                }
                default:{
                    $val = $val;
                }
            }
            
            $rt []= new xmlrpcval($val, $type);
        }
        return $rt;
    }
    
    private function convertToXmlRpcType($val){
        
        if(is_array($val)){
            if(!empty($val) && !isset($val[0])){
                return 'struct';
            }
        }
        
        return php_2_xmlrpc_type(gettype($val));
    }
}
