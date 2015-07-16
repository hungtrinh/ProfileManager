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

    public function testWhenVisitThenShowProfileForm()
    {
        $this->visitEditProfilePage($profileId = 1);

        $html = $this->getResponse()->getBody();
        $this->assertQuery('form#edit-profile', $html);
        $this->assertQuery('input#fullname', $html);
        $this->assertQuery('input#dob', $html);
        $this->assertQuery('input#email', $html);
        $this->assertQuery('input#submit', $html);

        $editProfileUrl = $this->url(['action' => 'edit', 'controller' => 'profile']);


        $this->assertQuery("form[method='post'][action='$editProfileUrl']",
            $html);
        $this->assertQuery('input[name="id"][type="hidden"]', $html);
        $this->assertQuery('input[name="fullname"][type="text"]', $html);
        $this->assertQuery('input[name="dob"][type="text"]', $html);
        $this->assertQuery('input[name="email"][type="text"]', $html);
        $this->assertQuery('input[name="submit"][type="submit"][value="Save"]', $html);
    }
}