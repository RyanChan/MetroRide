<?php
namespace MR\Entity;
/**
 * Description of KeySecret
 *
 * @author RyanChan
 * @Entity(repositoryClass="MR\Entity\Repository\KeySecretRepository")
 * @HasLifecycleCallbacks
 * 
 */
class KeySecret {
    /**
     *
     * @var integer $id
     * @Column(type="integer")
     * @Id @GeneratedValue
     */
    private $id;
    /**
     *
     * @var string $key
     * @Column(type="string")
     */
    private $api_key;
    /**
     *
     * @var string $secret
     * @Column(type="string", nullable="true")
     */
    private $api_secret;
    /**
     *
     * @var datetime $ts_created
     * @Column(type="datetime")
     */
    private $ts_created;
    /**
     *
     * @var datetime $ts_last_updated
     * @Column(type="datetime", nullable="true")
     */
    private $ts_last_updated;
    /**
     * Constructor 
     */
    public function __construct(){
        $this->ts_created = new \DateTime('now');
    }
    /**
     * Getter of ID
     * @return type 
     */
    public function getId(){
        return $this->id;
    }
    /**
     * Setter of Key
     * @param string $key 
     */
    public function setAPIKey($key){
        $this->api_key = $key;
    }
    /**
     * Getter of Key
     * @return string
     */
    public function getAPIKey(){
        return $this->api_key;
    }
    /**
     * Setter of Secret
     * @param string $secret 
     */
    public function setAPISecret($secret = null){
        if($secret == null){
            $key = $this->getAPIKey();
            $secret = ($key * $key) ^ $key;
        }
        $this->api_secret = md5($secret);
    }
    /**
     * Getter of Secret
     * @return string
     */
    public function getAPISecret(){
        return $this->api_secret;
    }
    /**
     * Pre-Update
     * @PreUpdate 
     */
    public function preUpdate(){
        $this->ts_lsat_updated = new \DateTime('now');
    }
}
