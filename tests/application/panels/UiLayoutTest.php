<?php

/**
 * Specification UI layout default 'applcation/layouts/scripts/layout.phtml'
 */
class UiLayoutTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV, APPLICATION_PATH.'/configs/application.ini'
        );
        parent::setUp();
    }

    public function testHeaderHasLinkToProfileListPage()
    {
        $this->dispatch($this->url(['action'=>'index', 'controller'=> 'index', 'module' => 'default'],'default',true));
        $body = $this->getResponse()->getBody();

        $listProfileUrl = $this->url(['action'=>'index', 'controller'=> 'profile', 'module' => 'default'],'default',true);
        $this->assertQuery("nav a[href='$listProfileUrl']",$body);
    }

    public function testHeaderHasSwitcherLanguage()
    {
        $this->dispatch($this->url(['action'=>'index', 'controller'=> 'index', 'module' => 'default'],'default',true));
        $body = $this->getResponse()->getBody();

        $changeDisplayVietnameseLink = $this->url(['lang'=> 'vi_VN'],'default',true);
        $changeDisplayUsLink = $this->url(['lang'=> 'en_US'],'default',true);
        $this->assertQuery("nav a[href='$changeDisplayVietnameseLink']",$body);
        $this->assertQuery("nav a[href='$changeDisplayUsLink']",$body);
    }
}
