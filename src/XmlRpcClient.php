<?php

require_once dirname(__FILE__).'/XmlRpcException.php';

abstract class XmlRpcClient{
    
    protected $serverUri;
    
    function __construct($serverUri = NULL){
        $this->serverUri = $serverUri;
        $this->doInitialize();
    }
    
    protected abstract function doInitialize();
    
    /**
     * Execute the remote invocation.
     * 
     * @param string $method
     * @param array $args
     * @return
     * @throws XmlRpcException
     */
    function execute($method, array $args){
        
        $rt;
        
        $rt = $this->doExecute($method, $args);
        
        return $rt;
    }
    
    /**
     * Exact implementation.
     * 
     * @param string $method
     * @param array $args
     * @see #execute()
     */
    protected abstract function doExecute($method, array $args);
}

?>