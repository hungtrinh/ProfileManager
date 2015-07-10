<?php

class Application_Model_DbTable_ProfileTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application_Model_DbTable_Profile
     */
    private $profileTable;

    protected function setUp()
    {
        parent::setUp();
        $app = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $app->bootstrap();

        $this->profileTable = new Application_Model_DbTable_Profile();
        $this->prepaireData();
    }

    protected function prepaireData()
    {
        $this->profileTable->getAdapter()->query("TRUNCATE TABLE profile;");
        foreach([
            ['id' => 1, 'fullname' => 'Nguyen Quang A', 'dob' => (new DateTime())->format('Y-m-d'), 'email' => 'a@mail.com'],
            ['id' => 2, 'fullname' => 'Nguyen Quang B', 'dob' => (new DateTime())->format('Y-m-d'), 'email' => 'b@mail.com'],
            ['id' => 3, 'fullname' => 'Nguyen Quang C', 'dob' => (new DateTime())->format('Y-m-d'), 'email' => 'c@mail.com'],
        ] as $profile) {
            $this->profileTable->insert($profile);
        }
    }

    public function testGetIdsWillReturnAllProfileId()
    {
        $this->assertEquals([1,2,3], $this->profileTable->fetchAll()->getIds());

        $this->profileTable->getAdapter()->query("TRUNCATE TABLE profile;");
    }

    public function testGetIdentifyMapWillReturnArrayWithProfileIdIsKeyAndProfileModelIsValue()
    {
        $profiles = $this->profileTable->fetchAll();
        $mapIdProfile = $profiles->getIdentifyMap();


        $this->assertEquals([1,2,3], array_keys($mapIdProfile));
        $this->assertSame($profiles[0], array_values($mapIdProfile)[0]);

        $this->profileTable->getAdapter()->query("TRUNCATE TABLE profile;");
    }
}
