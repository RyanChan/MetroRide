<?php

/**
 * Description of ContextSwitch
 *
 * @author RyanChan
 */
class MR_Controller_Action_Helper_ContextSwitch extends Zend_Controller_Action_Helper_ContextSwitch{
    protected $_autoSerializetion = true;
    protected $_availableAdapters = array(
        'amf' => 'Zend_Serializer_Adapter_Amf3',
        'json' => 'Zend_Serializer_Adapter_Json',
        'xml' => 'MR_Serializer_Adapter_Xml',
        'php' => 'Zend_Serializer_Adapter_PhpSerialize'
    );
    
    public function __construct($options = null){
        if($options instanceof Zend_Config){
            $this->setConfig($options);
        }else if(is_array($options)){
            $this->setOptions($options);
        }
        
        if(empty($this->_contexts)){
            $this->addContexts(array(
                'amf' => array(
                    'suffix' => 'json',
                    'headers' => array(
                        'Content-Type' => 'application/octet-stream'
                    ),
                    'callbacks' => array(
                        'init' => 'initAbstractContext',
                        'post' => 'restContext'
                    )
                ),
                'json' => array(
                    'suffix' => 'json',
                    'headers' => array(
                        'Content-Type' => 'application/json'
                    ),
                    'callbacks' => array(
                        'init' => 'initAbstractContext',
                        'post' => 'restContext'
                    )
                ),
                'xml' => array(
                    'suffix' => 'xml',
                    'headers' => array(
                        'Content-Type' => 'application/xml'
                    ),
                    'callbacks' => array(
                        'init' => 'initAbstractContext',
                        'post' => 'restContext'
                    )
                ),
                'php' => array(
                    'suffix' => 'php',
                    'headers' => array(
                        'Content-Type' => 'text/php'
                    ),
                    'callbacks' => array(
                        'init' => 'initAbstractContext',
                        'post' => 'restContext'
                    )
                )
            ));
        }
        
        $this->init();
    }
    
    public function initAbstractContext(){
        if(!$this->getAutoSerialization()){
            return;
        }
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $view = $viewRenderer->view;
        
        if($view instanceof Zend_View_Interface){
            $viewRenderer->setNoRender(true);
        }
    }
    
    public function restContext(){
        if(!$this->getAutoSerialization()){
            return;
        }
        
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        
        if($view instanceof Zend_View_Interface){
            if(method_exists($view, 'getVars')){
                $data = $view->getVars();
                
                if(count($data) !== 0){
                    $serializer = new $this->_availableAdapters[$this->_currentContext];
                    $body = $serializer->serialize($view->getVars());
                    
                    if($this->_currentContext == 'xml'){
                        $stylesheet = $this->getRequest->getHeader('X-XSL-Stylesheet');
                        
                        if($stylesheet !== false and !empty($stylesheet)){
                            $body = str_replace('<!--?xml version="1.0"?-->', sprintf('<!--?xml version="1.0"?--><!--?xml-stylesheet type="text/xsl" href="%s"?-->', $stylesheet), $body);
                        }
                    }
                    
                    if($this->_currentContext == 'json'){
                        $callback = $this->getRequest()->getParam('jsonp-callback', false);
                        
                        if($callback !== false and !empty($callback)){
                            $body = sprintf('%s(%s)', $callback, $body);
                        }
                    }
                    
                    $this->getResponse()->setBody($body);
                }
            }
        }
    }
    
    public function setAutoSerialization($flag){
        $this->_autoSerializetion = (bool) $flag;
        return $this;
    }
    
    public function getAutoSerialization(){
        return $this->_autoSerializetion;
    }
}
