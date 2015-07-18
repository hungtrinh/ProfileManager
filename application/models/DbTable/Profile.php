<?php

/**
 * Management database table profile
 *
 * In this case table profile like data mapper
 *
 * Support create, read, update, delete, finder on profile table
 */
class Application_Model_DbTable_Profile extends Zend_Db_Table_Abstract implements Application_Model_Mapper_ProfileInterface
{
    /**
     * Table name (in database context)
     *
     * @var string
     */
    protected $_name = 'profile';

    /**
     * Classname for row
     *
     * @var string
     */
    protected $_rowClass = 'Application_Model_Profile';

    /**
     * Classname for rowset
     *
     * @var string
     */
    protected $_rowsetClass = 'Application_Model_ProfileCollection';

    /**
     * Paginator profile
     *
     * @param int $page page number default 1
     * @param int $size page size default 25
     * @return Zend_Paginator
     */
    public function paginator($page = 1, $size = 25)
    {
        $select    = $this->select()->limitPage($page, $size);
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbTableSelect($select));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($size);
        return $paginator;
    }

    /**
     * Persit profile model to persitent layer
     *
     * @param Application_Model_ProfileInterface $profile
     */
    public function save(Application_Model_ProfileInterface $profile)
    {
        if (!$profile->getId()) {
            $id = $this->insert($this->mapFromEntity($profile));
            $profile->id = $id;
            return;
        }
        $this->update($this->mapFromEntity($profile), ['id=?'=>$profile->getId()]);
    }

    /**
     * Find profile by profile id
     *
     * @param int $profileId profile id
     * @return Application_Model_ProfileInterface
     */
    public function findById($profileId)
    {
        return $this->find($profileId)->current();
    }

    /**
     * Map profile from persit to profile entity
     * 
     * @param Application_Model_ProfileInterface $profile
     * @return []
     */
    private function mapFromEntity(Application_Model_ProfileInterface $profile) {
        $profilePersit = [];
        if ($profile->getId()) {
            $profilePersit['id'] = $profile->getId();
        }
        if ($profile->getBirthDay()) {
            $profilePersit['dob'] = $profile->getBirthDay()->format('Y-m-d');
        }
        if ($profile->getEmail()) {
            $profilePersit['email'] = $profile->getEmail();
        }
        if ($profile->getFullname()) {
            $profilePersit['fullname'] = $profile->getFullname();
        }
        return $profilePersit;
    }

    /**
     * Find profile by profile id
     *
     * @param int | Application_Model_ProfileInterface $profile profile id or profile entity
     */
    public function deleteProfile($profile)
    {
        $profileId = is_numeric($profile) ? (int)$profile : $profile->getId();
        $this->delete(['id=?'=>$profileId]);
    }
}