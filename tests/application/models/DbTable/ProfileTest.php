<?php

/**
 * @group db-intergration
 * @group mapper
 */
class Application_Model_DbTable_ProfileTest extends Zend_Test_PHPUnit_DatabaseTestCase
{
    /**
     * Database connection
     *
     * @var Zend_Test_PHPUnit_Db_Connection
     */
    private $connection;

    /**
     * @var Application_Model_DbTable_Profile
     */
    private $profileTable;

    protected function setUp()
    {
        $this->runAutoloadResources();
        parent::setUp();
        $this->profileTable = new Application_Model_DbTable_Profile();
    }

    public function runAutoloadResources()
    {
        $app = new Zend_Application(
            APPLICATION_ENV, APPLICATION_PATH."/configs/application.ini"
        );
        $app->bootstrap(['db','ResourceLoader']);
    }

    /**
     *
     * @return Zend_Test_PHPUnit_Db_Connection
     */
    protected function getConnection()
    {
        if ($this->connection == null) {
            $connection       = Zend_Db_Table::getDefaultAdapter();
            $this->connection = $this->createZendDbConnection(
                $connection, 'zfunittests'
            );
        }
        return $this->connection;
    }

    protected function getDataSet()
    {
        $currentDate = new DateTime('2015-07-16');
        $current     = $currentDate->format('Y-m-d');
        return $this->createArrayDataSet([
                'profile' => [
                    ['id' => 1, 'fullname' => 'Quang A', 'dob' => $current, 'email' => 'a@mail.com'],
                    ['id' => 2, 'fullname' => 'Quang B', 'dob' => $current, 'email' => 'b@mail.com'],
                    ['id' => 3, 'fullname' => 'Quang C', 'dob' => $current, 'email' => 'c@mail.com'],
                ]
        ]);
    }

    public function testGetIdsWillReturnAllProfileId()
    {
        $this->assertEquals([1, 2, 3], $this->profileTable->fetchAll()->getIds());
    }

    public function testGetIdentifyMapWillReturnArrayWithProfileIdIsKeyAndProfileModelIsValue()
    {
        $profiles     = $this->profileTable->fetchAll();
        /* @var $profiles Application_Model_ProfileCollectionInterface */
        $mapIdProfile = $profiles->getIdentifyMap();
        /* @var $mapIdProfile ArrayObject */

        foreach ($mapIdProfile as $profileId => $profileEntity) {
            /* @var $profileEntity Application_Model_ProfileInterface */
            $this->assertInstanceOf('Application_Model_ProfileInterface',
                $profileEntity);
            $this->assertEquals($profileEntity->getId(), $profileId);
        }
    }

    public function testPaginatorWillReturnInstanceOfZendPaginator()
    {
        $profiles  = $this->profileTable->paginator(1, 1);
        $totalPage = $profiles->count();

        $this->assertInstanceOf('Zend_Paginator', $profiles);
        $this->assertEquals(3, $totalPage);
    }

    /**
     * @group save
     */
    public function testSaveWillReplaceExistingRecord()
    {
        $expectedRow = [
            'id' => 1,
            'fullname' => "Trinh Nha Uyen",
            'dob' => '2018-01-18',
            'email' => 'nhauyen@gmail.com'
        ];

        $entityFactory = new Application_Factory_ProfileModel();
        $profile = $entityFactory->createService($expectedRow);
        $this->profileTable->save($profile);

        $this->assertEquals(3,
            (int) $this->getConnection()->getConnection()->query("SELECT COUNT(*) FROM profile")->fetchColumn());

        $ds         = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet($this->getConnection());
        $ds->addTable('profile', "SELECT * FROM PROFILE WHERE ID=1");
        $this->assertDataSetsEqual($this->createArrayDataSet(['profile' => [$expectedRow]]), $ds);
    }

    /**
     * @group save
     */
    public function testSaveWillInsertWithProfileDoesNotExistProfileId()
    {
        $expectedRow = [
            'fullname' => "Trinh Nha Uyen",
            'dob' => '2018-01-18',
            'email' => 'nhauyen@gmail.com'
        ];

        $profile = $this->profileTable->createRow($expectedRow);
        $this->profileTable->save($profile);

        $this->assertEquals(4,
            (int) $this->getConnection()->getConnection()->query("SELECT COUNT(*) FROM profile")->fetchColumn());

        $insertedId = 4;
        $ds         = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet($this->getConnection());
        $ds->addTable('profile', "SELECT * FROM PROFILE WHERE ID=$insertedId");
        $this->assertDataSetsEqual($this->createArrayDataSet(['profile' => [['id' => $insertedId]
                    + $expectedRow]]), $ds);
    }

    public function testFindByIdWillReturnModelProfileInterface()
    {
        $profileIdExisted = 1;
        $profile = $this->profileTable->findById($profileIdExisted);
        /* @var $profile Application_Model_ProfileInterface */
        
        $this->assertEquals([
            'id' => 1,
            'fullname' => 'Quang A',
            'email' => 'a@mail.com',
            'dob' => new DateTime('2015-07-16')
        ], [
            'id' => $profile->getId(),
            'fullname' => $profile->getFullname(),
            'email' => $profile->getEmail(),
            'dob' => $profile->getBirthDay()
        ]);

    }
}