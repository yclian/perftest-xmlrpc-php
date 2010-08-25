<?php

set_include_path(
    dirname(__FILE__).'/../vendor/XML_RPC2:'.
    dirname(__FILE__).'/../vendor/Zend/library:'.
    get_include_path()
);

require 'PHPUnit/Framework/TestCase.php';

class XmlRpcPerfTest extends PHPUnit_Framework_TestCase{
    
    private static $clients = array(
        'Ixr',
        'PhpXmlRpc',
        'Pear',
        'Zend',
        'Native',
    );
    
    /**
     * @var XmlRpcClient
     */
    private $client;
    
    function test(){
        
        foreach(self::$clients as $client){
            
            $start = time();
            $class = "XmlRpcClient{$client}";
            $rt;
            
            require_once dirname(__FILE__)."/../src/$class.php";
            $class = new ReflectionClass("$class");
            
            $this->client = $class->newInstance(
               YOUR_ADDRESS
            );
            
            for($i = 0; $i < 1; $i++){
                $rt = $this->client->execute(
                    YOUR_METHOD,
                    array(
                        YOUR_ARGS
                    )
                );
            }
            
            print "Processed: XmlRpcClient{$client}, ".(time() - $start)."s taken.\n";
        }
    }
}

?>