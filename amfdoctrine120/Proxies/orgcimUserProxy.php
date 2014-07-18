<?php

namespace org\cim\proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class orgcimUserProxy extends \org\cim\User implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function addInstrument($instrument)
    {
        $this->_load();
        return parent::addInstrument($instrument);
    }

    public function getInstruments()
    {
        $this->_load();
        return parent::getInstruments();
    }

    public function addPracticeSession($practiceSession)
    {
        $this->_load();
        return parent::addPracticeSession($practiceSession);
    }

    public function getPracticeSessions()
    {
        $this->_load();
        return parent::getPracticeSessions();
    }

    public function addRole($role)
    {
        $this->_load();
        return parent::addRole($role);
    }

    public function getRoles()
    {
        $this->_load();
        return parent::getRoles();
    }

    public function load()
    {
        $this->_load();
        return parent::load();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'firstName', 'lastName', 'password', 'rawPassword', 'institution', 'bio', 'email', 'createdDate', 'lastLoginDate', 'id', 'practiceSessions', 'instruments', 'roles');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}