<?php

/**
 * @group controller
 */
class ProfileCreatePageTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV, APPLICATION_PATH.'/configs/application.ini'
        );
        parent::setUp();
    }

    private function visitCreateProfilePage()
    {
        $createProfileUrl = $this->url(['action' => 'create', 'controller' => 'profile']);
        $this->dispatch($createProfileUrl);
    }

    private function submitProfileForm(array $profile)
    {
        $createProfileUrl = $this->url(['action' => 'create', 'controller' => 'profile']);
        $this->getRequest()->setMethod('POST')->setPost($profile);
        $this->dispatch($createProfileUrl);
    }

    public function testWhenVisitThenResponseSuccess()
    {
        $this->visitCreateProfilePage();
        $this->assertResponseCode(200);
    }

    /**
     * @test
     */
    public function testWhenVisitThenRequestHandlerByCreateActionProfileControllerDefaultModule()
    {
        $this->visitCreateProfilePage();
        $this->assertAction('create');
        $this->assertController('profile');
        $this->assertModule('default');
    }

    public function testWhenVisitThenShowBlankProfileForm()
    {
        $this->visitCreateProfilePage();

        $this->assertQueryCount('form#create-profile', 1);
        $this->assertQueryCount('input#fullname', 1);
        $this->assertQueryCount('input#dob', 1);
        $this->assertQueryCount('input#email', 1);
        $this->assertQueryCount('input#submit', 1);

        $createProfileUrl = $this->url(['action' => 'create', 'controller' => 'profile']);

        $this->assertQueryCount("form[method='post'][action='$createProfileUrl']", 1);
        $this->assertQueryCount('input[name="id"][type="hidden"]', 1);
        $this->assertQueryCount('input[name="fullname"][type="text"]', 1);
        $this->assertQueryCount('input[name="dob"][type="text"]', 1);
        $this->assertQueryCount('input[name="email"][type="text"]', 1);
        $this->assertQueryCount('input[name="submit"][type="submit"][value="submit"]', 1);
    }

    public function testWhenSubmitInvalidProfileThenRePresentFormProfile()
    {
        $invalidProfile = [
            'fullname' => $invalidFullname='$#!',
            'dob' => $invalidDob='four',
            'email' => $invalidEmail='email',
        ];

        $this->submitProfileForm($invalidProfile);
        
        $createProfileUrl = $this->url(['action' => 'create', 'controller' => 'profile']);
        $this->assertQueryCount("form[method='post'][action='$createProfileUrl']", 1);
        $this->assertQueryCount('input[name="id"][type="hidden"]', 1);
        $this->assertQueryCount("input[name='fullname'][type='text'][value='$invalidFullname']", 1);
        $this->assertQueryCount("input[name='dob'][type='text'][value='$invalidDob']", 1);
        $this->assertQueryCount("input[name='email'][type='text'][value='$invalidEmail']", 1);
        $this->assertQueryCount('input[name="submit"][type="submit"][value="submit"]', 1);
    }

    public function testWhenSubmitInvalidProfileThenDisplayFormErrorMessage()
    {
        $invalidProfile = [
            'fullname' => $invalidFullname='$#!',
            'dob' => $invalidDob='four',
            'email' => $invalidEmail='email',
        ];
        $this->submitProfileForm($invalidProfile);

        $this->assertQueryContentContains('body', "'$invalidFullname' contains characters which are non word character");
        $this->assertQueryContentContains('body', "'$invalidDob' does not fit the date format 'yyyy-MM-dd'");
        $this->assertQueryContentContains('body', "'$invalidEmail' is not a valid email address in the basic format local-part@hostname");
    }
}