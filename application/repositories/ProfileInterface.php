<?php

/**
 * Collection access for profile model
 *
 * Layer beetween profile Model and profile mapper 
 */
interface Application_Repository_ProfileInterface
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

    /**
     * Find profile by profile id
     *
     * @param int $profileId profile id
     * @return Application_Model_ProfileInterface
     *
     * @throw Application_Repository_NotFoundException
     */
    public function findById($profileId);

    /**
     * Find profile by profile id
     *
     * @param int | Application_Model_ProfileInterface $profile profile id or profile entity
     */
    public function delete($profile);
}