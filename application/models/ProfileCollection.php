<?php

/**
 * Hold profile list and business logic relative profile list
 *
 * @implements Application_Model_ProfileCollectionInterface
 */
class Application_Model_ProfileCollection extends Zend_Db_Table_Rowset_Abstract implements Application_Model_ProfileCollectionInterface
{
    /**
     * Indicates type of item in collection
     *
     * @var string
     */
    protected $_rowClass = 'Application_Model_Profile';

    /**
     * Internal cache indicate list profile id in current collection
     * 
     * @var int []
     */
    protected $ids;

    /**
     * Internal cache indicates map (associative arrays) with key is profile id
     * and value is an item of Application_Model_ProfileInterface
     *
     * [profile id => Application_Model_ProfileInterface]
     *
     * @var Application_Model_ProfileInterface []
     */
    protected $identifyMap;

    /**
     * @inherit
     * {@inherit}
     * {@inheritdoc}
     */
    public function getIds()
    {
        if (null === $this->ids) {
            $this->ids = [];
            foreach ($this as $profile /* @var $profile Application_Model_ProfileInterface */) {
                $this->ids[] = $profile->getId();
            }
        }

        return $this->ids;
    }

    /**
     * @inherit
     * {@inherit}
     * {@inheritdoc}
     */
    public function getIdentifyMap()
    {
        if (null === $this->identifyMap) {
            $this->identifyMap = new ArrayObject();
            foreach ($this as $profile /* @var $profile Application_Model_ProfileInterface */) {
                $this->identifyMap[$profile->getId()] = $profile;
            }
        }
        return $this->identifyMap;
    }
}