<?php
/**
 * Specification for Application_Factory_ProfileRepository
 *
 */
class Application_Factory_ProfileRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Application_Factory_ProfileRepository
     */
    protected $factory;

    protected function setUp()
    {
        $app = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . "/configs/application.ini");
        $app->bootstrap(['db','ResourceLoader']);
        $this->factory = new Application_Factory_ProfileRepository();
    }

    public function testCreateServiceWillReturnInstanceOfApplicationRepositoryProfileInterface()
    {
        $profileRepo = $this->factory->createService();
        $this->assertInstanceOf('Application_Repository_ProfileInterface', $profileRepo);
    }

    public function testCreateServiceWillReturnMappedObjectIfExists()
    {
        $profileRepoFactory = new Application_Factory_ProfileRepository();

        $profileRepo = $this->factory->createService();
        $profileRepoNextCall = $this->factory->createService();
        
        $this->assertSame($profileRepo, $profileRepoNextCall);
        $this->assertSame($profileRepo, $profileRepoFactory->createService());
    }

    public function testCreateServiceWillThrowExceptionWhenGetUnwantedInstanceType()
    {
        $serviceName = Application_Factory_ServiceName::PROFILE_REPOSITORY;
        $exceptionMessage = "$serviceName already registered in registry but is no instance of $serviceName";
        $this->setExpectedException("Application_Factory_Exception", $exceptionMessage);
        
        Zend_Registry::set(Application_Factory_ServiceName::PROFILE_REPOSITORY, new stdClass());
        $this->factory->createService();
    }
}