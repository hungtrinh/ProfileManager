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
     * Page paginator profile
     *
     * Handler GET request only
     * GET /profile
     * GET /profile/index/[:page/pageValue/][:size/sizeValue]
     *
     * @param int $page page number
     * @param int $size item per page
     */
    public function indexAction()
    {
        $page     = (int) $this->getParam('page', 1);
        $pageSize = (int) $this->getParam('size', 25);

        $profileRepoFactory = new Application_Factory_ProfileRepository();
        $profileRepo        = $profileRepoFactory->createService();

        $this->view->profiles = $profileRepo->paginator($page, $pageSize);
    }

    /**
     * Show profile form when user visit page
     * Persit profile when user post valid profile
     *
     * Handler GET, POST request
     * @link GET /profile/create display form profile
     * @link POST /profile/create persit profile
     */
    public function createAction()
    {
        $profileForm             = new Application_Form_Profile(['id' => 'create-profile']);
        $this->view->profileForm = $profileForm;

        /**
         * GET handler request
         */
        $requestShowProfileFormOnly = !$this->getRequest()->isPost();
        if ($requestShowProfileFormOnly) {
            return; //show profile form now
        }

        /**
         * POST handler request
         */
        $invalidProfileSubmited = !$profileForm->isValid($this->getRequest()->getPost());
        if ($invalidProfileSubmited) {
            return; //show profile form with errors messages
        }

        /**
         * Persit valid profile after filtered
         */
        $profileRepoFactory  = new Application_Factory_ProfileRepository();
        $profileModelFactory = new Application_Factory_ProfileModel();

        $profileEntity = $profileModelFactory->createService($profileForm->getValues());
        $profileRepo   = $profileRepoFactory->createService();
        $profileRepo->save($profileEntity);

        return $this->_helper->redirector('index', 'profile', 'default');
    }

    /**
     * Edit existed profile
     *
     * Handler GET, POST request
     * @link GET /profile/edit/:id display form profile populated 
     * @link POST /profile/edit persit profile
     */
    public function editAction()
    {
        $profileRepoFactory = new Application_Factory_ProfileRepository();
        $profileRepo        = $profileRepoFactory->createService();
        $profileForm        = new Application_Form_Profile(['id' => 'edit-profile']);
        $profileForm->submit->setLabel("Save");

        $this->view->profileForm = $profileForm;

        //GET request handler
        $visitEditProfilePage    = !$this->getRequest()->isPost();
        if ($visitEditProfilePage) {
            $profileId     = (int) $this->getParam('id', 0);
            $profileEntity = $profileRepo->findById($profileId);
            $profileForm->bindFromProfile($profileEntity);
            return; //render edit profile form
        }

        //POST request handler
        $postInvalidProfile = $profileForm->isValid($this->getRequest()->getPost());
        if ($postInvalidProfile) {
            return; //represent profile form with error messages
        }

        //TODO: persit filtered profile to persistent
        

    }
}