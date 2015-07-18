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
        $this->visitDeleteProfilePage($unknowProfile=2);

        $this->assertQueryContentContains('body', 'Profile not found' );
        $this->assertNotQuery("form[id='delete-profile']");
    }

    public function testVisitWillDisplayConfirmDeleteForm()
    {
        $this->visitDeleteProfilePage($existingProfile=1);
        $body = $this->getResponse()->getBody();
        $deleteUrl = $this->url(['action'=>'delete','controller' => 'profile', 'module' => 'default'], 'default',true);
        
        $this->assertQuery("form[action='$deleteUrl'][id='delete-profile'][method='post']", $body);
        $this->assertQuery("input[type='hidden'][name='id'][value='$existingProfile']", $body);
        $this->assertQuery("input[type='submit'][name='del'][value='Yes']", $body);
        $this->assertQuery("input[type='submit'][name='del'][value='No']", $body);
    }

    public function testWhenUserConfirmYesSystemWillDeletedProfile()
    {
        $this->getRequest()->setMethod('post')->setPost(['id'=>$existingProfile=1,'del'=>'Yes']);
        $this->dispatch($this->url(['action'=>'delete','controller'=>'profile','module'=>'default'],'default',true));

        $this->resetRequest()->resetResponse();
        $this->getRequest()->setMethod('get')->setPost([]);
        $this->dispatch($this->url(['action'=>'index','controller'=>'profile','module'=>'default'],'default',true));
        $this->assertQueryContentContains("body", "Empty profile list", $this->getResponse()->getBody());
    }

    public function testWhenProfileDeletedSuccessThenSystemWillRedirectToProfileList()
    {
        $this->getRequest()->setMethod('post')->setPost(['id'=>$existingProfile=1,'del'=>'Yes']);
        $this->dispatch($this->url(['action'=>'delete','controller'=>'profile','module'=>'default'],'default',true));

        $body = $this->getResponse()->getBody();
        $profileListUrl = $this->url(['action'=>'index','controller'=>'profile','module'=>'default'],'default',true);
        $this->assertRedirect($body);
        $this->assertRedirectTo($profileListUrl, $body);
    }
}