<?php

/**
 * Description of RestAuth
 *
 * @author RyanChan
 */
class MR_Controller_Plugin_RestAuth extends Zend_Controller_Plugin_Abstract{
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $apiKey = $request->getHeader('apiKey');
        
        // get doctrine entity manager
        $em = Zend_Registry::get('doctrine')->getEntityManager();
        
        // get KeySecret's repository from EntityManager
        $keySecretRepository = $em->getRepository('\MR\Entity\KeySecret');
        
        if(!$keySecretRepository->validateKeyAndSecret($apiKey)){
            $this->getResponse()->setHttpResponseCode(401)->appendBody("Invalid API Key\n");
            $request->setControllerName('error')->setActionName('error')->setDispatched(true);
        }
        
    }
}
