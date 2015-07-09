<?php

class Application_Model_DbTable_Profile extends Zend_Db_Table_Abstract
{

    protected $_name = 'profile';

    /**
     * Classname for row
     *
     * @var string
     */
    protected $_rowClass = 'Application_Model_Profile';
}

