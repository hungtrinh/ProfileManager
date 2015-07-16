<?php

/**
 * Verify expected result when visit edit profile page
 *
 *
 * @covers ProfileController::editAction
 *
 * @author hungtd
 */
class PageEditProfileTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected function setUp()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV, APPLICATION_PATH.'/configs/application.ini'
        );
        parent::setUp();
    }

    private function visitEditProfilePage($profileId=1)
    {
        $editProfileUrl = $this->url(['id' => $profileId, 'action'=>'edit', 'controller'=> 'profile']);
        $this->dispatch($editProfileUrl);
    }


    public function testWhenVisitThenResponseSuccess()
    {
        $this->visitEditProfilePage(1);
        $this->assertResponseCode(200);
    }

    public function testWhenVisitThenRequestHandlerByEditActionProfileControllerDefaultModule()
    {
        $this->visitEditProfilePage($profileId=1);

        $this->assertModule('default');
        $this->assertController('profile');
        $this->assertAction('edit');
        $this->assertEquals($profileId, $this->getRequest()->getParam('id'));
    }

    public function testWhenVisitThenPageTitleIsEditProfile()
    {
        $this->visitEditProfilePage($profileId=1);
        $this->assertQueryContentContains('title', "Edit Profile");
    }
}