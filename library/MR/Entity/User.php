<?php

namespace MR\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of User
 *
 * @author RyanChan
 * @Entity
 * @HasLifecycleCallbacks
 */
class User {

    /**
     * @Id @GeneratedValue
     * @Column(type="bigint")
     * @var integer
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $username;

    /**
     * @Column(type="string", length=32)
     * @var string
     */
    private $password;

    /**
     * @ManyToOne(targetEntity="Role", inversedBy="user")
     * @var \Role $role
     */
    private $role;

    /**
     * @Column(type="datetime")
     * @var datetime $ts_created
     */
    private $ts_created;

    /**
     * @Column(type="datetime", nullable="true")
     * @var datetime $ts_last_updated
     */
    private $ts_last_updated;

    /**
     * @OneToMany(targetEntity="UserProfile", mappedBy="user", cascade={"persist", "remove"})
     * @var \ArrayCollection $profile
     */
    private $profile;

    /**
     * Constructor 
     */
    public function __construct() {
        $this->ts_created = new \DateTime();
        $this->ts_last_updated = new \DateTime();
        $this->profile = new ArrayCollection();
    }

    /**
     * Getter of User Id
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Setter of username
     * @param type $username 
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Getter of username
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Setter of password
     * @param string $password 
     */
    public function setPassword($password) {
        $this->password = md5($password);
    }

    /**
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Setter of Role
     * @param Role $role 
     */
    public function setRole(Role $role) {
        $this->role = $role;
    }

    /**
     * Getter of Role
     * @return type 
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Setter of UserProfile
     * @param UserProfile $profile
     * @return 
     */
    public function setProfile(UserProfile $profile) {
        foreach ($this->profile as $p) {
            if ($p->getProfileKey() == $profile->getProfileKey()) {
                $p->setProfileValue($profile->getProfileValue());
                return;
            }
        }

        $this->profile[] = $profile;
    }

    /**
     * Unsetter of UserProfile
     * @param string $key 
     */
    public function unsetProfile($key) {
        foreach ($this->profile as $k => $profile) {
            if ($profile->getProfileKey() == $key) {
                unset($this->profile[$k]);
            }
        }
    }

    /**
     * Getter of UserProfile
     * @param string $key
     * @return null|\UserProfile
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
     * Getter of UserProfile for all objects
     * @return array 
     */
    public function getProfiles() {
        return $this->profile;
    }

    /**
     * Getter of ts_created
     * @return type 
     */
    public function getCreated() {
        return $this->ts_created;
    }

    /**
     * Getter of ts_last_updated
     * @return type 
     */
    public function getLastUpdated() {
        return $this->ts_last_updated;
    }

    /**
     * Pre-Update
     * @PreUpdate 
     */
    public function preUpdate() {
        $this->ts_last_updated = new \DateTime('now');
    }

}
