<?php

/**
 * Management database table profile
 *
 * In this case table profile like data mapper
 *
 * Support create, read, update, delete, finder on profile table
 */
class Application_Model_DbTable_Profile extends Zend_Db_Table_Abstract
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

}