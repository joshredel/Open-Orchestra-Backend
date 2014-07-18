<?php

namespace org\cim\proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class orgcimSettingProxy extends \org\cim\Setting implements \Doctrine\ORM\Proxy\Proxy
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
            unset($this->_entityPersister);
            unset($this->_identifier);
        }
    }

    
    public function setPracticeSession($practiceSession)
    {
        $this->_load();
        return parent::setPracticeSession($practiceSession);
    }

    public function getPracticeSession()
    {
        $this->_load();
        return parent::getPracticeSession();
    }

    public function load()
    {
        $this->_load();
        return parent::load();
    }


    public function __sleep()
    {
        if (!$this->__isInitialized__) {
            throw new \RuntimeException("Not fully loaded proxy can not be serialized.");
        }
        return array('settingName', 'startingPoint', 'endingPoint', 'mixerData', 'id', 'practiceSession');
    }
}