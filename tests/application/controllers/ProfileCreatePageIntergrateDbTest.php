<?php

/**
 * Test when user post valid profile to /profile/create
 *
 * @group page-intergrate-db
 * @group controller
 */
class ProfileCreatePageIntergrateDbTest extends ControllerIntegrateDbTestCase
{

    /**
     * Prepaire empty profile table
     * 
     * @return \PHPUnit_Extensions_Database_DataSet_ArrayDataSet
     */
    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            "profile" => []
        ]);
    }

    private function submitProfileForm(array $profile)
    {
        $createProfileUrl = $this->url(['action' => 'create', 'controller' => 'profile']);
        $this->getRequest()->setMethod('POST')->setPost($profile);
        $this->dispatch($createProfileUrl);
    }

    public function testWhenPostValidProfileThenRedirectToProfileList()
    {
        $profileListUrl = $this->url(['action'=>'index','controller'=>'profile']);
        $validProfile = [
            'fullname' => 'Trinh Duc Hung',
            'age' => 30,
            'email' => 'email@gmail.com'
        ];
        
        $this->submitProfileForm($validProfile);

        $this->assertRedirect();
        $this->assertRedirectTo($profileListUrl);
    }

    public function testWhenPostValidProfileThenPersitProfileToDb()
    {
        $validProfile = [
            'fullname' => 'Trinh Duc Hung',
            'age' => 30,
            'email' => 'email@gmail.com'
        ];

        $profileListUrl = $this->url(['action'=>'index','controller'=>'profile']);
        $this->submitProfileForm($validProfile);

        $this->assertRedirectTo($profileListUrl);
    }
}