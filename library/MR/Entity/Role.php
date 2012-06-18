<?php

namespace MR\Entity;

/**
 * Description of Role
 *
 * @author RyanChan
 * @Entity
 * @HasLifecycleCallbacks
 */
class Role {

    /**
     * @Id @GeneratedValue
     * @Column(type="smallint")
     * @var integer $id
     */
    private $id;

    /**
     * @OneToMany(targetEntity="User", mappedBy="role")
     * @var User $user
     */
    private $user;

    /**
     * @Column(type="string")
     * @var string $name
     */
    private $name;

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
     * Contructor 
     */
    public function __construct() {
        $this->ts_created = new \DateTime('now');
    }

    /**
     * Getter of Role id
     * @return type 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Setter of User
     * @param User $user 
     */
    public function setUser(User $user) {
        $this->user = $user;
        $this->user->setRole($this);
    }

    /**
     * Getter of User
     * @return \User 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Setter of name
     * @param type $name 
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Getter of name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Pre-Update
     * @PreUpdate 
     */
    public function preUpdate() {
        $this->ts_last_updated = new \DateTime('now');
    }

}
