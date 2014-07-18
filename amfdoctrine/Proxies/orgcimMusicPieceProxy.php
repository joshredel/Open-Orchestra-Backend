<?php

namespace org\cim\proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class orgcimMusicPieceProxy extends \org\cim\MusicPiece implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function setConductorUser($user)
    {
        $this->_load();
        return parent::setConductorUser($user);
    }

    public function getConductorUser()
    {
        $this->_load();
        return parent::getConductorUser();
    }

    public function addScore($score)
    {
        $this->_load();
        return parent::addScore($score);
    }

    public function getScores()
    {
        $this->_load();
        return parent::getScores();
    }

    public function addGenre($genre)
    {
        $this->_load();
        return parent::addGenre($genre);
    }

    public function getGenres()
    {
        $this->_load();
        return parent::getGenres();
    }

    public function addMixer($mixer)
    {
        $this->_load();
        return parent::addMixer($mixer);
    }

    public function getMixers()
    {
        $this->_load();
        return parent::getMixers();
    }


    public function __sleep()
    {
        if (!$this->__isInitialized__) {
            throw new \RuntimeException("Not fully loaded proxy can not be serialized.");
        }
        return array('pieceName', 'composer', 'performingEnsemble', 'recordedDate', 'conductorName', 'description', 'thumbnailSet', 'mainStream', 'secondaryStream', 'tertiaryStream', 'id', 'conductorUser', 'scores', 'mixers', 'genres');
    }
}