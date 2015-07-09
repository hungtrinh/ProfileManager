<?php

// require_once "ControllerIntegrateDbTestCase.php";

class ProfileListPageIntegrateDbTest extends ControllerIntegrateDbTestCase
{
    private function mysqlDateYearAgo($yearAgo)
    {
        $yearAgo = (int) $yearAgo;
        return (new DateTime())->modify("- $yearAgo years")->format('Y-m-d');
    }

    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_ArrayDataSet(array(
            'profile' => [
                ['id' => 1, 'fullname' => 'Trinh An An', 'dob' => $this->mysqlDateYearAgo(26), 'email' => 'an@gmail.com'],
                ['id' => 2, 'fullname' => 'Trinh An Binh', 'dob' => $this->mysqlDateYearAgo(25), 'email' => 'binh@gmail.com'],
                ['id' => 3, 'fullname' => 'Trinh An Thai', 'dob' => $this->mysqlDateYearAgo(24), 'email' => 'thai@gmail.com'],
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
