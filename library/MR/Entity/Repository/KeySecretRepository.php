<?php
namespace MR\Entity\Repository;
use Doctrine\ORM\EntityRepository, MR\Entity\KeySecret;
/**
 * Description of KeySeceretRepository
 *
 * @author RyanChan
 */
class KeySecretRepository extends EntityRepository{
    public function validateKeyAndSecret($key){
        $keySecret = $this->findOneBy(array('api_key' => $key));
        
        if(!$keySecret)
            return false;
        
        $key = ($key * $key) ^ $keySecret->getAPIKey();
        
        if(md5($key) == $keySecret->getAPISecret()){
            return true;
        }else{
            return false;
        }
    }
}
