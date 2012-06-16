<?php

/**
 * Description of Controller
 *
 * @author RyanChan
 */
class MR_Rest_Controller extends Zend_Rest_Controller {
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em = null;
    /**
     *
     * @var array $errors
     */
    protected $errors = array();

    public function init() {
        $this->setNoRender();
        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->em = Zend_Registry::get('doctrine')->getEntityManager();
    }

    protected function setNoRender($flag = true) {
        $this->_helper->viewRenderer->setNoRender($flag);
    }

    public function deleteAction() {
        
    }

    public function getAction() {
        
    }

    public function indexAction() {
        
    }

    public function postAction() {
        
    }

    public function putAction() {
        
    }
    
}
