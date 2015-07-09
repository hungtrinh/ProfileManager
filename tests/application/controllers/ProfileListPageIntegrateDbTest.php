<?php

// require_once "ControllerIntegrateDbTestCase.php";

class ProfileListPageIntegrateDbTest extends ControllerIntegrateDbTestCase
{
    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_ArrayDataSet(array(
            'profile' => [
                ['id' => 1, 'fullname' => 'Trinh An An', 'age' => 26, 'email' => 'an@gmail.com'],
                ['id' => 2, 'fullname' => 'Trinh An Binh', 'age' => 25, 'email' => 'binh@gmail.com'],
                ['id' => 1, 'fullname' => 'Trinh An Thai', 'age' => 24, 'email' => 'thai@gmail.com'],
            ],
        ));
    }

    private function visitListProfilePage()
    {
        $listProfileUrl = $this->url(['action' => 'index', 'controller' => 'profile', 'module' => 'default']);
        $this->dispatch($listProfileUrl);
    }

    /**
     * @test
     */
    public function visitThenContentContainsTableProfiles()
    {
        $this->visitListProfilePage();

        $this->assertQuery('#table-list-profile');
        $this->assertQuery('#table-list-profile-head');
        $this->assertQuery('#table-list-profile-body');

        $this->assertQueryContentContains('#table-list-profile-head > th', 'id');
        $this->assertQueryContentContains('#table-list-profile-head > th', 'fullname');
        $this->assertQueryContentContains('#table-list-profile-head > th', 'age');
        $this->assertQueryContentContains('#table-list-profile-head > th', 'email');
    }
}
