<?php

class Application_Model_ProfileCollection
 extends Zend_Db_Table_Rowset_Abstract
 implements Application_Model_ProfileCollectionInterface {
    /**
     * Zend_Db_Table_Row_Abstract class name.
     *
     * @var string
     */
    protected $_rowClass = 'Application_Model_Profile';

    /**
     * @var int []
     */
    protected $ids;

    /**
     * @var Application_Model_ProfileInterface []
     */
    protected $identifyMap;

    /**
     * Get list profile ids
     * @return int[]
     */
    public function getIds()
    {
        if (null == $this->ids) {
            $this->ids = [];
            foreach($this as $profile /* @var $profile Application_Model_ProfileInterface */) {
                $this->ids[] = $profile->getId();
            }
        }

        return $this->ids;
    }

    /**
     * Get array with struct
     * [profile id => Application_Model_ProfileInterface]
     *
     * @return Application_Model_ProfileInterface[]
     */
    public function getIdentifyMap()
    {
        if (null == $this->identifyMap) {
            foreach($this as $profile /* @var $profile Application_Model_ProfileInterface */) {
                $this->identifyMap[$profile->getId()] = $profile;
            }
        }
        return $this->identifyMap;
    }
}
