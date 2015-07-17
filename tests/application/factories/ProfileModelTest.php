<?php

/**
 * Specification for Application_Factory_ProfileModel
 */
class Application_Factory_ProfileModelTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Application_Factory_ProfileModel
     */
    protected $factory;

    protected function setUp()
    {
        $app           = new Zend_Application(APPLICATION_ENV,
            APPLICATION_PATH."/configs/application.ini");
        $app->bootstrap(['db', 'ResourceLoader']);
        $this->factory = new Application_Factory_ProfileModel();
    }

    public function testCreateServiceWillReturnInstanceOfApplicationModelProfileInterface()
    {
        $profileModel = $this->factory->createService([]);
        $this->assertInstanceOf('Application_Model_ProfileInterface',
            $profileModel);
    }

    public function testCreateService()
    {
        $profileSubmited = [
            'id' => 1,
            'fullname' => 'Trinh Nha Uyen',
            'dob' => '2018-01-18',
            'email' => 'trinhnhauyen@gmail.com'
        ];
        
        $profileModel    = $this->factory->createService($profileSubmited);

        $this->assertSame($profileSubmited, [
            'id' => $profileModel->getId(),
            'fullname' => $profileModel->getFullname(),
            'dob' => $profileModel->getBirthDay()->format('Y-m-d'),
            'email' => $profileModel->getEmail()
        ]);
    }
}