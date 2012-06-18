<?php
require_once 'HTTP/Request.php';
/**
 * Description of Client
 *
 * @author RyanChan
 */
class MR_Rest_Client {
    private $curr_url = "";
    private $username = "";
    private $password = "";
    private $content_type = "";
    private $response = "";
    private $responseBody = "";
    private $responseCode = "";
    /**
     *
     * @var HTTP_Request
     */
    private $req = null;
    
    public function __construct($username = "", $password = "", $content_type = ""){
        $this->username = $username;
        $this->password = $password;
        $this->content_type = $content_type;
    }
    
    public function createRequest($url, $method, $arr = null){
        $this->curr_url = $url;
        $this->req = new HTTP_Request($url);
        
        if(!empty($this->username) && !empty($this->password)){
            $this->req->setBasicAuth($this->username, $this->password);
        }
        if(!empty($this->content_type)){
            $this->req->addHeader('Content-Type', $this->content_type);
        }
        
        switch($method){
            case 'GET':
                $this->req->setMethod(HTTP_REQUEST_METHOD_GET);
                break;
            case 'POST':
                $this->req->setMethod(HTTP_REQUEST_METHOD_POST);
                break;
            case 'PUT':
                $this->req->setMethod(HTTP_REQUEST_METHOD_PUT);
                break;
            case 'DELETE':
                $this->req->setMethod(HTTP_REQUEST_METHOD_DELETE);
                break;
        }
    }
    
    private function addPostData($arr){
        if($arr != null){
            if(gettype($arr) == 'string'){
                $this->req->setBody($arr);
            }else{
                foreach ($arr as $key => $value){
                    $this->req->addPostData($key, $value);
                }
            }
        }
    }
    
    public function sendRequest(){
        $this->response = $this->req->sendRequest();
        
        if(PEAR::isError($this->response)){
            echo $this->response->getMessage();
            die();
        }else{
            $this->responseCode = $this->req->getResponseCode();
            $this->responseBody = $this->req->getResponseBody();
        }
    }
    
    public function getResponse(){
        return array($this->responseCode, $this->responseBody);
    }
}
