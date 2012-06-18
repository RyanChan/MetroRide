<?php

namespace MR\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class MREntityUserProxy extends \MR\Entity\User implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setUsername($username)
    {
        $this->_load();
        return parent::setUsername($username);
    }

    public function getUsername()
    {
        $this->_load();
        return parent::getUsername();
    }

    public function setPassword($password)
    {
        $this->_load();
        return parent::setPassword($password);
    }

    public function getPassword()
    {
        $this->_load();
        return parent::getPassword();
    }

    public function setRole(\MR\Entity\Role $role)
    {
        $this->_load();
        return parent::setRole($role);
    }

    public function getRole()
    {
        $this->_load();
        return parent::getRole();
    }

    public function setProfile(\MR\Entity\UserProfile $profile)
    {
        $this->_load();
        return parent::setProfile($profile);
    }

    public function unsetProfile($key)
    {
        $this->_load();
        return parent::unsetProfile($key);
    }

    public function getProfile($key)
    {
        $this->_load();
        return parent::getProfile($key);
    }

    public function getProfiles()
    {
        $this->_load();
        return parent::getProfiles();
    }

    public function getCreated()
    {
        $this->_load();
        return parent::getCreated();
    }

    public function getLastUpdated()
    {
        $this->_load();
        return parent::getLastUpdated();
    }

    public function preUpdate()
    {
        $this->_load();
        return parent::preUpdate();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'username', 'password', 'role', 'ts_created', 'ts_last_updated', 'profile');
    }
}