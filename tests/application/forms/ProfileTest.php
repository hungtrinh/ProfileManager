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
            [[]], //all field required

            [['fullname'=>'Trinh Duc Hung']], //input only one field valid
            [['dob'=>'2018-12-18']], //input only one field valid
            [['email'=>'trinhnhauyen@gmail.com']], //input only one field valid
            
            [['fullname'=>'Trinh Duc Hung', 'dob'=>'2018-12-18']], //input only two field valid
            [['fullname'=>'Trinh Duc Hung', 'email'=>'trinhnhauyen@gmail.com']], //input only two field valid
            [['dob'=>'2018-12-18', 'email'=>'trinhnhauyen@gmail.com']], //input only two field valid

            [['fullname' => '$#!']], //input one field invalid
            [['dob' => 'four']], //input one field invalid
            [['email' => 'email']], //input one field invalid

            [['fullname' => '$#!', 'dob' => 'four']], //input two field invalid
            [['fullname' => '$#!', 'email' => 'email']], //input two field invalid
            [['dob' => 'four', 'email' => 'email']], //input two field invalid
            
            [['fullname' => '$#!', 'dob' => 'four', 'email' => 'email']], //input all field invalid
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

    public function testisValidPartialWillReturnTrueWhenInjectValidDobFormat()
    {
        $this->assertTrue(
            $this->form->isValidPartial(['dob' => '2015-01-30']),
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
