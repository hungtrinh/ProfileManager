<?php

/**
 * @group controller
 */
class ProfileListPageTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    private function visitListProfilePage()
    {
        $listProfileUrl = $this->url(['action' => 'index', 'controller' => 'profile', 'module' => 'default']);
        $this->dispatch($listProfileUrl);
    }

    public function testVisitThenLoadPageSuccess()
    {
        $this->visitListProfilePage();
        $this->assertResponseCode(200);
    }

    /**
     * @depends testVisitThenLoadPageSuccess
     */
    public function testVisitThenRequestHandlerByIndexActionInProfileController()
    {
        $this->visitListProfilePage();

        $this->assertAction('index');
        $this->assertController('profile');
        $this->assertModule('default');
    }

    /**
     * @depends testVisitThenRequestHandlerByIndexActionInProfileController
     */
    public function testVisitThenShowPageTitleEqualsProfileList()
    {
        $this->visitListProfilePage();
        $this->assertQueryContentContains('title', "Profile list");
    }

    /**
     * @depends testVisitThenShowPageTitleEqualsProfileList
     */
    public function testVisitWithEmptyProfileListThenShowContentEmptyProfileList()
    {
        $this->visitListProfilePage();
        $this->assertQueryContentContains('body', "Empty profile list");
    }

    public function testVisitThenContentContainsCreateProfileLink()
    {
        $this->visitListProfilePage();
        $body = $this->getResponse()->getBody();

        $createProfileUrl = $this->url(['action'=> 'create', 'controller'=> 'profile', 'module' => 'default']);
        $this->assertQuery("body a[href='$createProfileUrl']", $body);
    }
}
