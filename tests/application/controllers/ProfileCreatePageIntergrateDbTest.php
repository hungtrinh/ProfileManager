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

    public function validProfileProvider()
    {
        $bornYear = new DateTime('-30 years');
        return [
            [['fullname' => 'Trinh Duc Hung','dob' => $bornYear->format('Y-m-d') ,'email' => 'email@gmail.com']]
        ];
    }

    /**
     * @dataProvider validProfileProvider
     * @param [] | array $validProfile
     */
    public function testWhenPostValidProfileThenRedirectToProfileList($validProfile)
    {
        $profileListUrl = $this->url(['action'=>'index','controller'=>'profile']);
        
        $this->submitProfileForm($validProfile);
        
        $this->assertRedirect();
        $this->assertRedirectTo($profileListUrl);
    }

    /**
     * @dataProvider validProfileProvider
     * @param [] | array $validProfile
     */
    public function testWhenPostValidProfileThenPersitProfileToDb($validProfile)
    {
        $this->submitProfileForm($validProfile);
        $expectedRow = $validProfile;
        $expectedRow['id'] = 1;
        $this->assertTableContains($expectedRow, $this->databaseTester->getConnection()->createDataSet()->getTable('profile'));
    }
}