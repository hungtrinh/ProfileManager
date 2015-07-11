<?php

/**
 * Discovery api of lower layer using by Application_Repository_Profile
 * 
 * @group discovery-mapper-api
 */
class Application_Repository_ProfileDiscoveryMapperApiTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Application_Repository_Profile 
     */
    private $profileRepo;

    /**
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $profileMapperMock;

    protected function setUp()
    {
        $this->autoloadResource();
        $this->profileMapperMock = $this->getMockBuilder('Application_Model_Mapper_ProfileInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $this->profileRepo       = new Application_Repository_Profile($this->profileMapperMock);
    }

    protected function autoloadResource()
    {
        $app = new Zend_Application(APPLICATION_ENV,
            APPLICATION_PATH."/configs/application.ini");
        /* 'ResourceLoader' get from '_initResourceLoader' in Boostrap::_initResourceLoader() */
        $app->bootstrap('ResourceLoader');
    }

    /**
     * @test
     */
    public function paginatorWillDelegateCallMethodToProfileMapperInterface()
    {
        $profileCollection = new Application_Model_ProfileCollection([new Application_Model_Profile()]);
        $page              = 1;
        $pageSize          = 25;

        $this->profileMapperMock
            ->expects($this->once())
            ->method('paginator')
            ->with($page, $pageSize)
            ->will($this->returnValue($profileCollection));

        $result = $this->profileRepo->paginator($page, $pageSize);
        $this->assertSame($profileCollection, $result);
    }
}