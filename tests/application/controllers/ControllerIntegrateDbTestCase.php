<?php

/**
 * Controller intergration with database
 *
 * Run flow
 * 1. You: setup db table data fixture on method XXX (System: will truncate table data before insert your table data fixture)
 * 2. You: Do something on controller ex create, delete, search, edit,... (one at time)
 * 3. You: Assert something you want to check
 * 4. System: auto truncate table data fixture after each your test
 *
 * @author hungtd
 */
abstract class ControllerIntegrateDbTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     *
     * @var Zend_Test_PHPUnit_Db_SimpleTester
     */
    protected $databaseTester;

    /**
     *
     * @var boolean
     */
    protected $truncateFixturesWhenTearDown = true;

    protected function setUp()
    {
        $this->setUpBoostrap();
        parent::setUp();
        $this->setupDatabase();

    }

    /**
     * Init boostrap to controller test case
     *
     * Override this method if you want change init application evn
     */
    protected function setUpBoostrap()
    {
        // Set configuration files
        $config = array(APPLICATION_PATH . '/configs/application.ini');
        if (file_exists(APPLICATION_PATH . '/configs/application.local.ini')) {
            $config[] = APPLICATION_PATH . '/configs/application.local.ini';
        }
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, array('config' => $config));
    }

    protected function tearDown()
    {
        if ($this->databaseTester) {
            $this->databaseTester->onTearDown(); //default null operation - nothing to
            /**
             * Destroy the tester after the test is run to keep DB connections
             * from piling up.
             */
            $this->databaseTester = null;
        }
        parent::tearDown();
    }

    protected function setupDatabase()
    {
        $db = $this->bootstrap->getBootstrap()->getResource('db');
        if (empty($db)) {
            throw new RuntimeException(
                sprintf(
                    "Please setting resources.db for section [%s] in file %s",
                    APPLICATION_ENV,
                    realpath(APPLICATION_PATH . "/configs/application.ini")
                )
            );
        }

        $connection = new Zend_Test_PHPUnit_Db_Connection($db, '');
        $databaseTester = new Zend_Test_PHPUnit_Db_SimpleTester($connection);
        $databaseTester->setupDatabase($this->getDataSet());
        if ($this->truncateFixturesWhenTearDown) {
            $databaseTester->setTearDownOperation(new Zend_Test_PHPUnit_Db_Operation_Truncate()); // truncate database when call teardown
        }
        $this->databaseTester = $databaseTester;
    }

    /**
     * Table data fixtures setup
     *
     * Example
     *
     * return new PHPUnit_Extensions_Database_DataSet_ArrayDataSet(array(
     *       "table_name" => array(
     *           array("column1_name" => column1_value,"column2_name" => column2_value...)
     *           ...
     *           array("column1_name" => column1_value,"column2_name" => column2_value...)
     *       )
     * ));
     */
    abstract protected function getDataSet();

        /**
     * Asserts that two given tables are equal.
     *
     * @param PHPUnit_Extensions_Database_DataSet_ITable $expected
     * @param PHPUnit_Extensions_Database_DataSet_ITable $actual
     * @param string                                     $message
     */
    public static function assertTablesEqual(PHPUnit_Extensions_Database_DataSet_ITable $expected, PHPUnit_Extensions_Database_DataSet_ITable $actual, $message = '')
    {
        $constraint = new PHPUnit_Extensions_Database_Constraint_TableIsEqual($expected);
        self::assertThat($actual, $constraint, $message);
    }
    /**
     * Asserts that two given datasets are equal.
     *
     * @param PHPUnit_Extensions_Database_DataSet_ITable $expected
     * @param PHPUnit_Extensions_Database_DataSet_ITable $actual
     * @param string                                     $message
     */
    public static function assertDataSetsEqual(PHPUnit_Extensions_Database_DataSet_IDataSet $expected, PHPUnit_Extensions_Database_DataSet_IDataSet $actual, $message = '')
    {
        $constraint = new PHPUnit_Extensions_Database_Constraint_DataSetIsEqual($expected);
        self::assertThat($actual, $constraint, $message);
    }
    
    /**
     * Assert that a given table has a given amount of rows
     *
     * @param string $tableName Name of the table
     * @param int    $expected  Expected amount of rows in the table
     * @param string $message   Optional message
     */
    public function assertTableRowCount($tableName, $expected, $message = '')
    {
        $constraint = new PHPUnit_Extensions_Database_Constraint_TableRowCount($tableName, $expected);
        $actual     = $this->databaseTester->getConnection()->getRowCount($tableName);
        self::assertThat($actual, $constraint, $message);
    }
    
    /**
     * Asserts that a given table contains a given row
     *
     * @param array                                      $expectedRow Row expected to find
     * @param PHPUnit_Extensions_Database_DataSet_ITable $table       Table to look into
     * @param string                                     $message     Optional message
     */
    public function assertTableContains(array $expectedRow, PHPUnit_Extensions_Database_DataSet_ITable $table, $message = '')
    {
        self::assertThat($table->assertContainsRow($expectedRow), self::isTrue(), $message);
    }
    
    protected function mysqlDateYearAgo($yearAgo)
    {
        $number = (int) $yearAgo; /* @var $number int*/
        $oneYearAge = new DateTime("- $number years");
        return $oneYearAge->format('Y-m-d');
    }
}
