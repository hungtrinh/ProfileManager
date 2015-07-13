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
     * @return Application_Repository_Profile
     *
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
     * GET /profile
     * GET /profile/index/[:page/pageValue/][:size/sizeValue]
     * 
     * @param int $page page number
     * @param int $size item per page
     *
     */
    public function indexAction()
    {
        $page        = (int) $this->getParam('page', 1);
        $pageSize    = (int) $this->getParam('size', 25);
        $profileRepo = $this->factoryProfileRepo();
        
        $this->view->profiles = $profileRepo->paginator($page, $pageSize);
    }

    /**
     * Show profile form when user visit page
     * Persit profile when user post valid profile
     *
     * Handler GET, POST request
     * @link GET /profile/create display form profile
     * @link POST /profile/create persit profile
     * 
     */
    public function createAction()
    {
        $profileForm = new Application_Form_Profile(['id' => 'create-profile']);
        
        $this->view->profileForm = $profileForm;
        $requestShowForm = !$this->getRequest()->isPost() ;
        $postInvalidProfile = !$profileForm->isValid($this->getRequest()->getPost());

        if ( $requestShowForm || $postInvalidProfile) {
            return;
        }

        //TODO Request post valid profile
    }
}