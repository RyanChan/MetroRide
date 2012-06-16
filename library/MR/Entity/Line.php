<?php
namespace MR\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of Line
 *
 * @author RyanChan
 * @Entity
 * @HasLifecycleCallbacks
 */
class Line {

    /**
     *
     * @var integer $id
     * @Id @GeneratedValue
     * @Column(type="bigint")
     */
    private $id;

    /**
     *
     * @var string $initial
     * @Column(type="string")
     */
    private $initial;

    /**
     *
     * @var datetime $ts_created
     * @Column(type="datetime")
     */
    private $ts_created;

    /**
     *
     * @var datetime $ts_last_updated
     * @Column(type="datetime", nullable=true)
     */
    private $ts_last_updated;

    /**
     *
     * @var array $profile
     * @OneToMany(targetEntity="LineProfile", mappedBy="line")
     */
    private $profile;
    /**
     *
     * @var array $notifications
     * @OneToMany(targetEntity="LineNotification", mappedBy="line")
     */
    private $notifications;
    /**
     * Constructor 
     */
    public function __construct() {
        $this->ts_created = new \DateTime();

        $this->profile = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        
//        echo 'load';
    }
    /**
     * Setter of LineNotification
     * @param LineNotification $notification 
     */
    public function setNotification(LineNotification $notification){
        $this->notifications[] = $notification;
    }
    /**
     * Getter of LineNotification
     * @return type 
     */
    public function getNotification(){
        return $this->notifications;
    }
    /**
     * Setter of Initial
     * @param type $initial 
     */
    public function setInitial($initial){
        $this->initial = $initial;
    }
    /**
     * Getter of Initial
     * @return type 
     */
    public function getInitial(){
        return $this->initial;
    }
    /**
     * Setter of LineProfile
     * @param LineProfile $profile
     * @return type 
     */
    public function setProfile(LineProfile $profile) {
        foreach ($this->profile as $p) {
            if ($p->getProfileKey() == $profile->getProfileKey()) {
                $p->setProfileValue($profile->getProfileValue());
                return;
            }
        }

        $this->profile[] = $profile;
    }
    /**
     * Unsetter of LineProfile
     * @param type $key 
     */
    public function unsetProfile($key){
        foreach ($this->profile as $k => $profile){
            if($profile->getProfileKey() == $key){
                unset($this->profile[$k]);
            }
        }
    }
    /**
     * Getter of LineProfile
     * @param type $key
     * @return null 
     */
    public function getProfile($key) {
        foreach ($this->profile as $profile) {
            if ($profile->getProfileKey() == $key) {
                return $profile;
            }
        }
        
        return null;
    }
    /**
     * Pre-Update
     * @PreUpdate
     */
    public function preUpdate(){
        $this->ts_last_updated = new \DateTime('now');        
    }
}
