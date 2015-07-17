<?php
/**
 * Specification for Application_Factory_ProfileRepository
 *
 */
class ProfileRepositoryTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $app = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . "/configs/application.ini");
        $app->bootstrap('ResourceLoader');
        $this->factory = new Application_Factory_ProfileRepository();
    }

    public function testCreateServiceWillReturnInstanceOfApplicationRepositoryProfileInterface()
    {
        $profileRepo = $this->factory->createService();
        $this->assertInstanceOf('Application_Repository_ProfileInterface', $profileRepo);
    }

}