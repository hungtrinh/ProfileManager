<?php

/**
 * Hold profile list and business logic relative profile list
 *
 * @implements Application_Model_ProfileCollectionInterface
 */
interface Application_Model_ProfileCollectionInterface
{
    /**
     * Get list profile ids
     * @return int[]
     */
    public function getIds();

    /**
     * Get map profile id => profile entity
     *
     * <code>
     * <?php
     *      $profile = Application_Model_Profile();
     *      $profileId = 1;
     *      $profile->setId($profileId);
     *      $identifyMap = [ $profileId => $profile ]
     * ?>
     * </code>
     *
     * @return Application_Model_ProfileInterface[] map profile id to profile entity
     */
    public function getIdentifyMap();
}
