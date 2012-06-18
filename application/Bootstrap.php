<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /*
    protected function _initActionHelpers(){
        $contextSwitch = new MR_Controller_Action_Helper_ContextSwitch();
        Zend_Controller_Action_HelperBroker::addHelper($contextSwitch);
        
        $restContexts = new MR_Controller_Action_Helper_RestContexts();
        Zend_Controller_Action_HelperBroker::addHelper($restContexts);
    }
     * 
     */
    
    protected function _initGlobals(){
        Zend_Registry::set('config', $this->getOptions());
    }
}

