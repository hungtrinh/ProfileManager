<?php

class ProfileController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->profiles = (new Application_Model_DbTable_Profile())->fetchAll();
    }
}