<?php

/**
 * Discovery api of lower layer using by Application_Repository_Profile
 * 
 * @group discovery-mapper-api
 * @coversDefaultClass Application_Repository_Profile
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

    public function testPaginatorWillDelegateCallMethodToProfileMapperInterface()
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

    /**
     * @covers ::save
     */
    public function testSaveWillDelegateCallMethodToProfileMapperInterface()
    {
        $profile = new Application_Model_Profile(['data' => [
                'fullname' => 'Trinh Lam Tuyen',
                'dob' => '2018-1-18',
                'email' => 'lamtuyen@gmail.com'
        ]]);

        $this->profileMapperMock
            ->expects($this->once())
            ->method('save')
            ->with($profile)
            ->will($this->returnArgument(0));

        $this->profileRepo->save($profile);
//        $this->assertNotEmpty($profile->getId());
    }

    public function testFindByIdWillDelegateCallToMapperProfileMapperInterface()
    {
        $profile = new Application_Model_Profile(['data' => [
                'id' => $profileId = 1,
                'fullname' => 'Trinh Lam Tuyen',
                'dob' => '2018-1-18',
                'email' => 'lamtuyen@gmail.com'
        ]]);

        $this->profileMapperMock->expects($this->once())
            ->method('findById')
            ->with($profileId)
            ->willReturn($profile);

        $profileActual = $this->profileRepo->findById($profileId);
        $this->assertSame($profile, $profileActual);
    }


    public function testFindByIdWillThrowExceptionWhenNotFoundProfile()
    {
        $this->setExpectedException('Application_Repository_Exception', 'Not found profile', 404);
        
        $profileId = 1 ;
        $this->profileMapperMock->expects($this->once())
            ->method('findById')
            ->with($profileId)
            ->willReturn(null);

        $profileActual = $this->profileRepo->findById($profileId);
        $this->assertSame($profile, $profileActual);
    }

    public function testDeleteWillDelegateCallToMapperProfileMapperInterface()
    {
        $profileId = 1 ;
        $this->profileMapperMock->expects($this->once())
            ->method('deleteProfile')
            ->with($profileId);

        $this->profileRepo->delete($profileId);
    }

    public function testDeleteWillThrowExceptionWhenInjectAlpha()
    {
        $this->setExpectedException('InvalidArgumentException',"Profile id or Application_Model_ProfileInterface instance required");
        $this->profileRepo->delete('abc');
    }
}