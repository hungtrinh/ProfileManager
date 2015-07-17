<?php

/**
 * @group page-intergrate-db
 * @group controller
 */
class ProfileListPageIntegrateDbTest extends ControllerIntegrateDbTestCase
{
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

    private function visitListProfilePage($page=null,$pageSize=null)
    {
        $urlOptions = ['action' => 'index', 'controller' => 'profile', 'module' => 'default'];
        if ($page) {
            $urlOptions['page'] = $page;
        }
        if ($pageSize) {
            $urlOptions['size'] = $pageSize;
        }
        $this->dispatch($this->url($urlOptions));
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

        $this->assertQueryContentContains('#table-list-profile-head th', 'id');
        $this->assertQueryContentContains('#table-list-profile-head th', 'fullname');
        $this->assertQueryContentContains('#table-list-profile-head th', 'age');
        $this->assertQueryContentContains('#table-list-profile-head th', 'email');

        $this->assertQueryCount('#table-list-profile-body > tr', 3);

        foreach ([
            ['id' => 1, 'fullname' => 'Trinh An An', 'age' => 26, 'email' => 'an@gmail.com'],
            ['id' => 2, 'fullname' => 'Trinh An Binh', 'age' => 25, 'email' => 'binh@gmail.com'],
            ['id' => 3, 'fullname' => 'Trinh An Thai', 'age' => 24, 'email' => 'thai@gmail.com'],
        ] as $profile) {
            $this->assertQueryContentContains('#table-list-profile-body td', $profile['id']);
            $this->assertQueryContentContains('#table-list-profile-body td', $profile['fullname']);
            $this->assertQueryContentContains('#table-list-profile-body td', $profile['age']);
            $this->assertQueryContentContains('#table-list-profile-body td', $profile['email']);
        }
    }

    /**
     * @test
     */
    public function visitFirstPageWithPageSizeOneThenShowOnlyFirstRecord()
    {
        $this->visitListProfilePage(1,1);
        $this->assertQueryCount('#table-list-profile-body tr', 1);

        $profile = ['id' => 1, 'fullname' => 'Trinh An An', 'age' => 26, 'email' => 'an@gmail.com'];
        $this->assertQueryContentContains('#table-list-profile-body td', $profile['id']);
        $this->assertQueryContentContains('#table-list-profile-body td', $profile['fullname']);
        $this->assertQueryContentContains('#table-list-profile-body td', $profile['age']);
        $this->assertQueryContentContains('#table-list-profile-body td', $profile['email']);
    }

    /**
     * @test
     */
    public function visitWhenHasManyProfileThenShowPaginationRegion()
    {
        $this->visitListProfilePage(1,1);
        $this->assertQueryCount('.paginationControl', 1);
        $this->assertQueryCount('.paginationControl .next', 1);
        $this->assertQueryCount('.paginationControl .prev', 1);
        $this->assertQueryCount('.paginationControl .number', 2);
    }
}
