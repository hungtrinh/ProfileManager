<?php

/**
 * Test profile form when call method
 * - isValid
 * - getMessage
 * - getValues (get filtered data)
 */
class Application_Form_ProfileTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Application_Form_Profile
     */
    private $form;

    protected function setUp()
    {
        //Autoload resource by init Zend_Application
        new Zend_Application(APPLICATION_ENV,
            APPLICATION_PATH."/configs/application.ini");
        $this->form = new Application_Form_Profile();
    }

    /**
     * Invalid profile submited
     * 
     * @return []
     */
    public function invalidProfileProvider()
    {
        return [
            [['fullname' => '$#!', 'dob' => 'four', 'email' => 'email']],
            [['fullname' => '$#!']],
            [['dob' => 'four']],
            [['email' => 'email']],
        ];
    }


    /**
     * Invalid date profider
     *
     * @return []
     */
    public function invalidDateProvider()
    {
        return [
            ['2015-01-30 123'],
            ['01-30-2015'],
            ['30-01-2015'],
            ['30012015'],
        ];
    }
    
    /**
     * @dataProvider invalidProfileProvider
     * @param array $invalidProfile
     */
    public function testIsValidWillReturnFalseWhenInputInvalidProfile($invalidProfile)
    {
        $this->assertFalse(
            $this->form->isValid($invalidProfile),
            print_r($this->form->getMessages(),true)
        );
    }

    public function testGetMessagesWillReturnAllErrorsMessageWhenInputInvalidProfile()
    {
        $invalidProfile = ['fullname' => '$#!', 'dob' => 'four', 'email' => 'email'];

        $expectedErrorMessage = [
            'fullname' => [ 'regexNotMatch' => "'$#!' contains characters which are non word character"],
            'dob' => [Zend_Validate_Date::FALSEFORMAT => "'four' does not fit the date format 'yyyy-MM-dd'"],
            'email' => ['emailAddressInvalidFormat' => "'email' is not a valid email address in the basic format local-part@hostname"],
        ];

        $this->form->isValid($invalidProfile);
        $this->assertEquals($expectedErrorMessage, $this->form->getMessages());
    }

    public function testIsValidWillReturnTrueWhenInjectValidDobFormat()
    {
        $this->assertTrue(
            $this->form->isValid(['dob' => '2015-01-30']),
            print_r($this->form->getMessages('dob'),true)
        );
    }

    /**
     * @dataProvider invalidDateProvider
     * 
     * @param string $invalidDate
     */
    public function testIsValidWillReturnFalseWhenInjectInValidDobFormat($invalidDate)
    {
        $this->assertFalse(
            $this->form->isValid(['dob' => $invalidDate]),
            print_r($this->form->getMessages('dob'),true)
        );
    }

    public function testBindFromProfileWillPopulateDataFromProfileEntity()
    {
        $profileRaw = [
            'id' => 1,
            'fullname' => "Trinh Thanh Tam",
            'dob' => '2018-06-18',
            'email' => 'TrinhThanhTam@gmail.com'
        ];
        
        $profile = new Application_Model_Profile(['data' => $profileRaw]);
            
        $this->form->bindFromProfile($profile);
        $this->assertEquals($profileRaw, $this->form->getValues());
    }
}
