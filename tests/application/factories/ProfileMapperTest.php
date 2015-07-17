<?php
/**
 * Specification for Application_Factory_ProfileMapper
 */
class Application_Factory_ProfileMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Application_Factory_ProfileMapper
     */
    protected $factory;

    protected function setUp()
    {
        $app = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . "/configs/application.ini");
        $app->bootstrap(['db','ResourceLoader']);
        $this->factory = new Application_Factory_ProfileMapper();
    }

    public function testCreateServiceWillReturnInstanceOfApplicationMapperProfileInterface()
    {
        $profileMapper = $this->factory->createService();
        $this->assertInstanceOf('Application_Model_Mapper_ProfileInterface', $profileMapper);
    }

    public function testCreateServiceWillReturnMappedObjectIfExists()
    {
        $profileMapperFactory = new Application_Factory_ProfileMapper();

        $profileMapper = $this->factory->createService();
        $profileMapperNextCall = $this->factory->createService();
        
        $this->assertSame($profileMapper, $profileMapperNextCall);
        $this->assertSame($profileMapper, $profileMapperFactory->createService());
    }

}