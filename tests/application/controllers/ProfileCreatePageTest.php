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
        $body = $this->getResponse()->getBody();

        $this->assertQuery('form#create-profile', $body);
        $this->assertQuery('input#fullname', $body);
        $this->assertQuery('input#dob', $body);
        $this->assertQuery('input#email', $body);
        $this->assertQuery('input#submit', $body);

        $createProfileUrl = $this->url(['action' => 'create', 'controller' => 'profile']);

        $this->assertQuery("form[method='post'][action='$createProfileUrl']", $body);
        $this->assertQuery('input[name="id"][type="hidden"]', $body);
        $this->assertQuery('input[name="fullname"][type="text"]', $body);
        $this->assertQuery('input[name="dob"][type="text"]', $body);
        $this->assertQuery('input[name="email"][type="text"]', $body);
        $this->assertQuery('input[name="submit"][type="submit"][value="Add"]', $body);
    }

    public function testWhenSubmitInvalidProfileThenRePresentFormProfile()
    {
        $invalidProfile = [
            'fullname' => $invalidFullname='$#!',
            'dob' => $invalidDob='four',
            'email' => $invalidEmail='email',
        ];

        $this->submitProfileForm($invalidProfile);
        $body = $this->getResponse()->getBody();

        $createProfileUrl = $this->url(['action' => 'create', 'controller' => 'profile']);
        $this->assertQuery("form[method='post'][action='$createProfileUrl']", $body);
        $this->assertQuery('input[name="id"][type="hidden"]', $body);
        $this->assertQuery("input[name='fullname'][type='text'][value='$invalidFullname']", $body);
        $this->assertQuery("input[name='dob'][type='text'][value='$invalidDob']", $body);
        $this->assertQuery("input[name='email'][type='text'][value='$invalidEmail']", $body);
        $this->assertQuery('input[name="submit"][type="submit"][value="Add"]',$body);
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
