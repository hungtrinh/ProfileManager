<?php

/**
 * Management user profile
 *
 * Group page relative with profile manage
 * - paginator profile by page and page size
 * - add new profile
 * - edit exist profile
 * - delete exist profile
 */
class ProfileController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $page     = (int) $this->getParam('page', 1);
        $pageSize = (int) $this->getParam('size', 25);

        $profileTable = new Application_Model_DbTable_Profile();
        $select       = $profileTable->select()->limitPage($page, $pageSize);

        $this->view->profiles = $profileTable->fetchAll($select);
    }
}