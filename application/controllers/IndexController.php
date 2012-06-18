<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
    
    public function indexAction(){
        $em = Zend_Registry::get('doctrine')->getEntityManager();
        
        $keySecret = new \MR\Entity\KeySecret();
        
        $key = rand(1, 100000000);
        
        $keySecret->setAPIKey($key);
        $keySecret->setAPISecret(md5(($key * $key) ^ $key)); 
        
        $em->persist($keySecret);
        $em->flush();
        
        
         
    }

    public function importlineAction(){
        $fp = fopen(APPLICATION_PATH.'/../data/MR/Lines.csv', 'r');
        
        $em = Zend_Registry::get('doctrine')->getEntityManager();
        
        $i = 0;
        while($line = fgetcsv($fp)){
            if($i == 0){
                $i++;
                continue;
            }
            
            $l = new \MR\Entity\Line();
            $l->chinese_name = $line[0];
            $l->english_name = $line[1];
            $l->initial      = $line[2];
            
            $em->persist($l);
        }
        
        $em->flush();
    }
    
    public function importtypeAction(){
        $fp = fopen(APPLICATION_PATH.'/../data/MR/Types.csv', 'r');
        
        $em = Zend_Registry::get('doctrine')->getEntityManager();
        
        $i = 0;
        while($line = fgetc($fp)){
            if($i == 0){
                $i++;
                continue;
            }
            
            $type = new \MR\Entity\Type();
            $type->chinese_name = $line[0];
            $type->english_name = $line[1];
            
            $em->persist($type);
        }
        
        $em->flush();
    }
    
    public function importroleAction(){
        $em = Zend_Registry::get('doctrine')->getEntityManager();
        
        $operator = new \MR\Entity\Role();
        $operator->name = 'Operator';
        
        $em->persist($operator);
        
        $administrator = new \MR\Entity\Role();
        $administrator->name = 'Administrator';
        
        $em->persist($administrator);
        
        $em->flush();
    }
    
    public function importstationAction(){
        
    }
    
    public function importplatformAction(){
        
    }
    
    public function importrouteAction(){
        
    }
    
    public function importfarezoneAction(){
        
    }
    
    public function importfacilityAction(){
        
    }
    
    public function importwayoutAction(){
        
    }
    
    public function teststationAction(){
        $em = Zend_Registry::get('doctrine')->getEntityManager();
        /*
        $line = new \MR\Entity\Line();
        $line->chinese_name = 'Line 1';
        $line->english_name = 'Line 1';
        $line->initial = 'l1';
        
        $em->persist($line);
        
        $type = new \MR\Entity\Type();
        $type->chinese_name = 'Type 1';
        $type->english_name = 'Type 1';
        
        $em->persist($type);
        
        $farezone = new \MR\Entity\FareZone();
        $farezone->name = 'fare zone 1';
        $farezone->adult = '4.00';
        $farezone->concession = '2.00';
        
        $em->persist($farezone);
        
        $em->flush();
        */
        
        $lineRepository = $em->getRepository('MR\Entity\Line');
        $line = $lineRepository->findOneBy(array('chinese_name' => 'Line 1'));
        
        echo $line->initial;
        /*
        $station = new \MR\Entity\Station();
        $station->line = $line;
        $station->type = $type;
        $station->fare_zone = $farezone;
        $station->chinese_name = 'Station 1';
        $station->english_name = 'Station 1';
        $station->initial = 's1';
        
        $em->persist($station);
        */
        //$em->flush();
    }
}

