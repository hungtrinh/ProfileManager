<?php

/**
 * Create an instance of Application_Repository_Interface
 *
 */
class Application_Factory_ProfileRepository
{
    public function createService()
    {
        return new Application_Repository_Profile(
            new Application_Model_DbTable_Profile()
        );
    }
}