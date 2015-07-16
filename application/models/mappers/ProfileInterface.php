<?php

/**
 * Transport ProfileInterface between persistent layer and domain layer
 */
interface Application_Model_Mapper_ProfileInterface
{

    /**
     * Paginator profile list
     *
     * @param int $page page number default 1
     * @param int $size page size default 25
     * @return Zend_Paginator
     */
    public function paginator($page = 1, $size = 25);

    /**
     * Persit profile model to persitent layer
     * 
     * @param Application_Model_ProfileInterface $profile
     */
    public function save(Application_Model_ProfileInterface $profile);
}