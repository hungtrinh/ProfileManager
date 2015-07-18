<?php

/**
 * Delete profile specification
 *
 */
class ProfileDeletePageIntergrateDbTest extends ControllerIntegrateDbTestCase
{
    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_ArrayDataSet([
            "profile" => [
                [
                    'id' => 1, 'fullname' => 'Trinh An An',
                    'dob' => $this->mysqlDateYearAgo(26),
                    'email' => 'an@gmail.com'
                ],
            ],
        ]);
    }

    public function visitDeleteProfilePage($profileId)
    {
        $this->dispatch($this->url(['id' => $profileId, 'action'=>'delete','controller'=> 'profile','module'=>'default' ], 'default', true));
        
        $body = $this->getResponse()->getBody();
        $this->assertResponseCode(200);
        $this->assertEquals($profileId, $this->getRequest()->getParam('id',0),$body);
        $this->assertAction('delete');
        $this->assertController('profile');
        $this->assertModule('default');
    }
    public function testVisitWillDisplayErrorWhenNotFoundProfile()
    {
        $this->visitDeleteProfilePage(2);

        $this->assertQueryContentContains('body', 'Profile not found' );
    }
}