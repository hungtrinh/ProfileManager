<?php

/**
 * Create an instance of Application_Model_ProfileInterface
 *
 */
class Application_Factory_ProfileModel
{
    /**
     * @param array $rowProfile
     * @return Application_Model_ProfileInterface
     */
    public function createService(array $rowProfile = []) {
        return new Application_Model_Profile(['data' => $rowProfile]);
    }
}