<?php

/**
 * Description of RestHandler
 *
 * @author RyanChan
 */
class MR_Controller_Plugin_RestHandler extends Zend_Controller_Plugin_Abstract{
    
    private $dispatcher;
    
    private $defaultFormat = 'json';
    
    private $responseTypes = array(
        '*/*' => false,
        'text/xml' => 'xml',
        'application/xml' => 'xml',
        
    );
    
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        $this->getResponse()->setHeader('Vary', 'Accept');
        
        $mimeType = $this->getMimeType($request->getHeader('Accept'));
        
        switch ($mimeType){
            case 'text/xml':
            case 'application/xml':
                $request->setParam('format', 'xml');
                break;
            case 'application/octet-stream':
                $request->setParam('format', 'amf');
                break;
            case 'text/php':
                $request->setParam('format', 'php');
                break;
            case 'application/json':
            default:
                $request->setParam('format', 'json');
                break;
        }
    }
    
    private function getMimeType($mimeTypes = null){
        $AcceptTypes = array();
        
        $accept = strtolower(str_replace(' ', '', $mimeTypes));
        
        $accept = explode(',', $accept);
        
        foreach($accept as $a){
            $q = 1;
            
            if(strpos($a, ';q=')){
                list($a, $q) = explode(';q=', $a);
            }
            
            $AcceptTypes[$a] = $q;
        }
        
        arsort($AcceptTypes);
        
        foreach ($AcceptTypes as $mime => $q){
            if($q && in_array($mime, $this->availableMimeTypes)){
                return $mime;
            }
        }
        
        return null;
    }
}
