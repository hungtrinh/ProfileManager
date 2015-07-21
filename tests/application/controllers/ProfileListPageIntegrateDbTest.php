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
        $this->visitListProfilePage(1,25);
        $body = $this->getResponse()->getBody();

        $this->assertQuery('#table-list-profile',  $body);
        $this->assertQuery('#table-list-profile-head',  $body);
        $this->assertQuery('#table-list-profile-body',  $body);

        $this->assertQueryContentContains('#table-list-profile-head th', 'id',  $body);
        $this->assertQueryContentContains('#table-list-profile-head th', 'fullname',  $body);
        $this->assertQueryContentContains('#table-list-profile-head th', 'age', $body);
        $this->assertQueryContentContains('#table-list-profile-head th', 'email', $body);
        $this->assertQueryContentContains('#table-list-profile-head th', 'Action', $body);

        $this->assertQueryCount('#table-list-profile-body > tr', 3);

        foreach ([
            ['id' => 1, 'fullname' => 'Trinh An An', 'age' => 26, 'email' => 'an@gmail.com'],
            ['id' => 2, 'fullname' => 'Trinh An Binh', 'age' => 25, 'email' => 'binh@gmail.com'],
            ['id' => 3, 'fullname' => 'Trinh An Thai', 'age' => 24, 'email' => 'thai@gmail.com'],
        ] as $profile) {
            $editLink = $this->url((['id' => $profile['id'], 'action'=>'edit','controller'=>'profile']),'default',true);
            $deleteLink = $this->url((['id' => $profile['id'], 'action'=>'delete','controller'=>'profile']),'default',true);
            $this->assertQueryContentContains('#table-list-profile-body td', $profile['id'],  $body);
            $this->assertQueryContentContains('#table-list-profile-body td', $profile['fullname'],  $body);
            $this->assertQueryContentContains('#table-list-profile-body td', $profile['age'],  $body);
            $this->assertQueryContentContains('#table-list-profile-body td', $profile['email'],  $body);
            $this->assertQuery("#table-list-profile-body td a[href='$editLink']", $body);
            $this->assertQuery("#table-list-profile-body td a[href='$deleteLink']", $body);
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
        $body = $this->getResponse()->getBody();
        $this->assertQuery('.paginationControl', $body);
        $this->assertQuery('.paginationControl .next', $body);
        $this->assertQuery('.paginationControl .prev', $body);
        $this->assertQueryCount('.paginationControl .number', 3, $body);
    }
}
