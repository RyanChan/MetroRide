<?php

/**
 * Description of DeviceList
 *
 * @author RyanChan
 */
class MR_Airship_DeviceList implements Iterator, Countable{
    /**
     *
     * @var MR_Airship
     */
    private $_airship = null;
    private $_page = null;
    private $_position = 0;
    
    public function __construct($airship) {
        $this->_airship = $airship;
        $this->_load_page(MR_Airship::DEVICE_TOKEN_URL);
        $this->_position = 0;
    }
    
    private function _load_page($url){
        $response = $this->_airship->_request($url, 'GET', NULL, NULL);
        $response_code = $response[0];
        if($response_code != 200){
            throw new MR_Airship_Exception_AirshipFailure($response[1], $response_code);
        }
        $result = json_decode($response[1]);
        if($this->_page == null){
            $this->_page = $result;
        }else{
            $this->_page->device_tokens = array_merge($this->_page->device_tokens, $result->device_tokens);
            $this->_page->next_page = $result->next_page;
        }
    }
    
    public function count(){
        return $this->_page->device_tokens_count;
    }
    
    public function rewind() {
        $this->_position = 0;
    }
    
    public function current(){
        return $this->_page->device_tokens[$this->_position];
    }
    
    public function key(){
        return $this->_position;
    }
    
    public function next(){
        ++$this->_position;
    }
    
    public function valid(){
        if(!isset($this->_page->device_tokens[$this->_position])){
            $next_page = isset($this->_page->next_page) ? $this->_page->next_page : null;
            if($next_page == null){
                return false;
            }else{
                $this->_load_page($next_page);
                return $this->valid();
            }
        }
        
        return true;
    }
}
