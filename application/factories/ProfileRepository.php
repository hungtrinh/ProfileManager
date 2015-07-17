<?php

/**
 * Create an instance of Application_Repository_Interface
 *
 */
class Application_Factory_ProfileRepository
{

    public function createService()
    {
        if (!Zend_Registry::isRegistered('Application_Repository_ProfileInterface')) {
            $profileRepo = new Application_Repository_Profile(
                new Application_Model_DbTable_Profile()
            );
            Zend_Registry::set('Application_Repository_ProfileInterface', $profileRepo);
        }
        return Zend_Registry::get('Application_Repository_ProfileInterface');
    }
}