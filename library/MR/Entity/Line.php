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
     * Getter of ID
     * @return integer $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Setter of LineNotification
     * @param LineNotification $notification 
     */
    public function setNotification(LineNotification $notification) {
        $this->notifications[] = $notification;
    }

    /**
     * Getter of LineNotification
     * @return array 
     */
    public function getNotification() {
        return $this->notifications;
    }

    /**
     * Get the current level of Line
     * @return integer 
     */
    public function getCurrentLevel() {
        if (count($this->notifications) > 0) {
            return $this->notifications[0]->getLevel();
        } else {
            return null;
        }
    }

    /**
     * Setter of Initial
     * @param string $initial 
     */
    public function setInitial($initial) {
        $this->initial = $initial;
    }

    /**
     * Getter of Initial
     * @return string 
     */
    public function getInitial() {
        return $this->initial;
    }

    /**
     * Setter of LineProfile
     * @param LineProfile $profile
     * @return null 
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
     * Getter of LineProfile
     * @param string $key
     * @return null|LineProfile
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
