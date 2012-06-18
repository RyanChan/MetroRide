<?php

/**
 * Description of Airship
 *
 * @author RyanChan
 */
class MR_Airship_Resource_Airship extends Zend_Application_Resource_ResourceAbstract {

    public function init() {
        $config = $this->getOptions();
        
        $airship = new MR_Airship($config);
        
        Zend_Registry::set('airship', $airship);
        
        return $airship;
    }

}
