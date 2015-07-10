<?php

interface Application_Model_ProfileCollectionInterface
{
    /**
     * Get list profile ids
     * @return int[]
     */
    public function getIds();

    /**
     * Get array with struct
     * [profile id => Application_Model_ProfileInterface]
     *
     * @return Application_Model_ProfileInterface[]
     */
    public function getIdentifyMap();
}
