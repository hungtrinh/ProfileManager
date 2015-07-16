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

    /**
     * @test
     */
    public function visitThenLoadPageSuccess()
    {
        $this->visitListProfilePage();
        $this->assertResponseCode(200);
    }

    /**
     * @test
     * @depends visitThenLoadPageSuccess
     */
    public function visitThenRequestHandlerByIndexActionInProfileController()
    {
        $this->visitListProfilePage();

        $this->assertAction('index');
        $this->assertController('profile');
        $this->assertModule('default');
    }

    /**
     * @test
     * @depends visitThenRequestHandlerByIndexActionInProfileController
     */
    public function visitThenShowPageTitleEqualsProfileList()
    {
        $this->visitListProfilePage();
        $this->assertQueryContentContains('title', "Profile list");
    }

    /**
     * @test
     * @depends visitThenShowPageTitleEqualsProfileList
     */
    public function visitWithEmptyProfileListThenShowContentEmptyProfileList()
    {
        $this->visitListProfilePage();
        $this->assertQueryContentContains('body', "Empty profile list");
    }
}
