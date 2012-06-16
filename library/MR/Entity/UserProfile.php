<?php
namespace MR\Entity;
/**
 * Description of UserProfile
 *
 * @author RyanChan
 * @Entity
 * @HasLifecycleCallbacks
 */
class UserProfile {
    /**
     * @Id @GeneratedValue
     * @Column(type="bigint")
     * @var integer $id
     */
    private $id;
    /**
     * @ManyToOne(targetEntity="User", inversedBy="profile")
     * @var \User $user
     */
    private $user;
    /**
     * @Column(type="string")
     * @var string $profile_key
     */
    private $profile_key;
    /**
     * @Column(type="text", nullable="true")
     * @var string $profile_value
     */
    private $profile_value;
    /**
     * Setter of User
     * @param User $user 
     */
    public function setUser(User $user){
        $this->user = $user;
        $this->user->setProfile($this);
    }
    /**
     * Getter of User
     * @return \User 
     */
    public function getUser(){
        return $this->user;
    }
    /**
     * Setter of Profile Key
     * @param string $key 
     */
    public function setProfileKey($key){
        $this->profile_key = $key;
    }
    /**
     * Getter of Profile Key
     * @return string 
     */
    public function getProfileKey(){
        return $this->profile_key;
    }
    /**
     * Setter of Profile Value
     * @param string $value 
     */
    public function setProfileValue($value){
        $this->profile_value = $value;
    }
    /**
     * Getter of Profile Value
     * @return string
     */
    public function getProfileValue(){
        return $this->profile_value;
    }
}
