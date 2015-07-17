<?php

/**
 * Specification profile edit when intergrate database
 *
 *
 * @covers ProfileController::editAction
 */
class ProfileEditPageIntergrateDbTest extends ControllerIntegrateDbTestCase
{

    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            "profile" => [
                ['id' => 1, 'fullname' => 'Trinh An An', 'dob' => $this->mysqlDateYearAgo(26),
                    'email' => 'an@gmail.com'],
            ]
        ]);
    }

    private function visitEditProfilePage($profileId = 1)
    {
        $editProfileUrl = $this->url(['id' => $profileId, 'action' => 'edit', 'controller' => 'profile']);
        $this->dispatch($editProfileUrl);
    }

    private function submitProfileForm(array $profile)
    {
        $createProfileUrl = $this->url(['action' => 'edit', 'controller' => 'profile']);
        $this->getRequest()->setMethod('POST')->setPost($profile);
        $this->dispatch($createProfileUrl);
    }

    public function testWhenVisitThenResponseSuccess()
    {
        $this->visitEditProfilePage(1);
        $this->assertResponseCode(200, $this->getResponse()->getBody());
    }

    public function testWhenVisitThenRequestHandlerByEditActionProfileControllerDefaultModule()
    {
        $this->visitEditProfilePage($profileId = 1);

        $this->assertModule('default');
        $this->assertController('profile');
        $this->assertAction('edit');
        $this->assertEquals($profileId, $this->getRequest()->getParam('id'));
    }

    public function testWhenVisitThenPageTitleIsEditProfile()
    {
        $this->visitEditProfilePage($profileId = 1);
        $this->assertQueryContentContains('title', "Profile Edit");
    }

    public function testWhenVisitThenShowProfileForm()
    {
        $this->visitEditProfilePage($profileId = 1);

        $html = $this->getResponse()->getBody();
        $this->assertQuery('form#edit-profile', $html);
        $this->assertQuery('input#fullname', $html);
        $this->assertQuery('input#dob', $html);
        $this->assertQuery('input#email', $html);
        $this->assertQuery('input#submit', $html);

        $editProfileUrl = $this->url(['action' => 'edit', 'controller' => 'profile'],
            'default', true);

        $this->assertQuery("form[method='post'][action='$editProfileUrl']",
            $html);
        $this->assertQuery('input[name="id"][type="hidden"]', $html);
        $this->assertQuery('input[name="fullname"][type="text"]', $html);
        $this->assertQuery('input[name="dob"][type="text"]', $html);
        $this->assertQuery('input[name="email"][type="text"]', $html);
        $this->assertQuery('input[name="submit"][type="submit"][value="Save"]',
            $html);
    }

    public function testWhenPostInvalidProfileThenRepesenterProfileFormWithErrorMessage()
    {
        $invalidProfile = [
            'id' => 1,
            'fullname' => $invalidFullname = '$#!',
            'dob' => $invalidDob      = 'four',
            'email' => $invalidEmail    = 'email',
        ];

        $this->submitProfileForm($invalidProfile);
        $body = $this->getResponse()->getBody();

        $editProfileUrl = $this->url(['action' => 'edit', 'controller' => 'profile']);
        $this->assertQuery("form[method='post'][action='$editProfileUrl']",
            $body);
        $this->assertQuery('input[name="id"][type="hidden"]', $body);
        $this->assertQuery("input[name='fullname'][type='text'][value='$invalidFullname']",
            $body);
        $this->assertQuery("input[name='dob'][type='text'][value='$invalidDob']",
            $body);
        $this->assertQuery("input[name='email'][type='text'][value='$invalidEmail']",
            $body);
        $this->assertQuery('input[name="submit"][type="submit"][value="Save"]',
            $body);
    }

    public function testWhenPostValidProfileThenRedirectToProfileList()
    {
        $profileListUrl = $this->url(['action' => 'index', 'controller' => 'profile']);
        $validProfile   = ['id' => 1, 'fullname' => 'Trinh An An edited', 'dob' => $this->mysqlDateYearAgo(27),
            'email' => 'anEdited@gmail.com'];

        $this->submitProfileForm($validProfile);

        $this->assertRedirect();
        $this->assertRedirectTo($profileListUrl);
    }

    public function testWhenPostValidProfileThenPersitProfileToDb()
    {
        $validProfile = ['id' => 1, 'fullname' => 'Trinh An An edited', 'dob' => $this->mysqlDateYearAgo(27),
            'email' => 'anEdited@gmail.com'];

        $this->submitProfileForm($validProfile);
        $this->assertTableContains($validProfile,
            $this->databaseTester->getConnection()->createDataSet()->getTable('profile'));
    }
}