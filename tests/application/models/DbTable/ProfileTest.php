<?php

class Application_Model_DbTable_ProfileTest extends Zend_Test_PHPUnit_DatabaseTestCase
{
    /**
     * Database connection
     *
     * @var PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    private $connection;

    /**
     * @var Application_Model_DbTable_Profile
     */
    private $profileTable;

    protected function setUp()
    {
        parent::setUp();
        $this->profileTable = new Application_Model_DbTable_Profile();
    }

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
        $current = (new DateTime())->format('Y-m-d');
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
}