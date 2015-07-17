<?php

/**
 * Management user profile
 *
 * Group page relative with profile manage
 * - paginator profile by page and page size
 * - add new profile
 * - edit exist profile
 * - delete exist profile
 *
 */
class ProfileController extends Zend_Controller_Action
{

    /**
     * @param array $profile
     * @return \Application_Model_Profile
     *
     */
    private function factoryProfileEntity(array $profile)
    {
        return new Application_Model_Profile(['data' => $profile]);
    }

    /**
     * @return \Application_Model_DbTable_Profile
     *
     */
    private function factoryProfileDbTable()
    {
        return new Application_Model_DbTable_Profile();
    }

    /**
     * @return \Application_Form_Profile
     *
     */
    private function factoryProfileForm($formOptions = ['id' => 'create-profile'])
    {
        return new Application_Form_Profile($formOptions);
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
     *
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
     *
     *
     */
    public function createAction()
    {
        $profileForm = $this->factoryProfileForm();

        /**
         * GET handler request
         */
        $requestShowProfileFormOnly = !$this->getRequest()->isPost();
        if ($requestShowProfileFormOnly) {
            $this->view->profileForm = $profileForm;
            return; //show profile form now
        }

        /**
         * POST handler request
         */
        $invalidProfileSubmited = !$profileForm->isValid(
                $this->getRequest()->getPost()
        );
        if ($invalidProfileSubmited) {
            $this->view->profileForm = $profileForm;
            return; //show profile form with errors messages
        }

        /**
         * Persit valid profile after filtered
         */
        $profileEntity = $this->factoryProfileEntity($profileForm->getValues());

        $profileRepoFactory = new Application_Factory_ProfileRepository();
        $profileRepo        = $profileRepoFactory->createService();
        $profileRepo->save($profileEntity);

        return $this->_helper->redirector('index', 'profile', 'default');
    }

    public function editAction()
    {
        $profileId          = (int) $this->getParam('id', 0);
        $profileRepoFactory = new Application_Factory_ProfileRepository();
        $profileRepo        = $profileRepoFactory->createService();
        $profileEntity      = $profileRepo->findById($profileId);

        $profileForm = $this->factoryProfileForm(['id' => 'edit-profile']);
        $profileForm->bindFromProfile($profileEntity);
        $profileForm->submit->setLabel("Save");

        $this->view->profileForm = $profileForm;
    }
}