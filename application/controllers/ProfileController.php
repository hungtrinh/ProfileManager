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

    /**
     *
     * @return Application_Repository_Profile
     */
    private function factoryProfileRepo()
    {
        return new Application_Repository_Profile(
            new Application_Model_DbTable_Profile()
        );
    }

    /**
     * Page paginator profile
     *
     * Handler GET request only
     * 
     * @param int $page page number
     * @param int $size item per page
     */
    public function indexAction()
    {
        $page        = (int) $this->getParam('page', 1);
        $pageSize    = (int) $this->getParam('size', 25);
        $profileRepo = $this->factoryProfileRepo();
        
        $this->view->profiles = $profileRepo->paginator($page, $pageSize);
    }
}