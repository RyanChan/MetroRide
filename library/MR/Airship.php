<?php
require_once 'urbanairship.php';
/**
 * Description of Airship
 *
 * @author RyanChan
 */
class MR_Airship {
    
    private $key = '';
    private $secret = '';
    /**
     *
     * @var Airship $airship
     */
    private $airship = null;
    
    public function __construct() {
        
        $config = Zend_Registry::get('config');
        
        $this->key = $config['airship']['key'];
        $this->secret = $config['airship']['secret'];
        
        $this->airship = new Airship($this->key, $this->secret);
    }
    
    public function register ($device_token, $alias = null, $tags = null, $badge = null){
        return $this->airship->register($device_token, $alias, $tags, $badge);
    }
    
    public function deregister($device_token){
        $this->airship->deregister($device_token);
    }
    
    public function get_device_token_info($device_token){
        return $this->airship->get_device_token_info($device_token);
    }
    
    public function get_device_tokens(){
//        return new MR_Airship_DeviceList($this);
        return $this->airship->get_device_tokens();
    }
    
    public function push($payload, $device_tokens = null, $aliases = null, $tags = null){
        $this->airship->push($payload, $device_tokens, $aliases, $tags);
    }
    
    public function broadcast($payload, $exclude_tokens = null){
        $this->airship->broadcast($payload, $exclude_tokens);
    }
    
    public function feedback($since){
        return $this->airship->feedback($since);
    }

    
}
