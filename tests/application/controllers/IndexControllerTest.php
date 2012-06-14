<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected $doctrine;

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        
        
        $this->doctrine = Zend_Registry::get('doctrine');
        
        $em = $this->doctrine->getEntityManager();
        
        $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $tool->dropDatabase();
        $tool->createSchema($em->getMetadataFactory()->getAllMetadata());
    }

    public function testLineObject(){
        
    }
    
}

