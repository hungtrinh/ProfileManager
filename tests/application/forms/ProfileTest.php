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
     * @dataProvider invalidProfileProvider
     * @param array $invalidProfile
     */
    public function testWhenInjectInvalidProfileThenIsValidReturnFalse($invalidProfile)
    {
        $this->assertFalse($this->form->isValid($invalidProfile));
    }

    public function testWhenInjectInvalidProfileThenGetMessagesWillReturnAllErrorsMessage()
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
}