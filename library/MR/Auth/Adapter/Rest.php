<?php

/**
 * Description of Rest
 *
 * @author RyanChan
 */
class MR_Auth_Adapter_Rest extends Zend_Auth_Adapter_Http{
    public function __construct(array $config) {
        parent::__construct($config);
    }
    
    protected function _basicAuth($header) {
        if(empty($header)){
            throw new Zend_Auth_Adapter_Exception('The value of the client Authorization header is required');
        }
        
        $auth = substr($header, strlen('Basic '));
        $auth = base64_decode($auth);
        if(!$auth){
            throw new Zend_Auth_Adapter_Exception('Unable to base64_decode Authorization header value');
        }
        
        if(!ctype_print($auth)){
            return $this->_challengeClient();
        }
        
        $creds = array_filter(explode(':', $auth));
        if(count($creds) != 2){
            return $this->_challengeClient();
        }
        
        
    }
}
