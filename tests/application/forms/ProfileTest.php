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
            [['fullname' => '$#!', 'age' => 'four', 'email' => 'email']],
            [['fullname' => '$#!']],
            [['age' => 'four']],
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
        $invalidProfile = ['fullname' => '$#!', 'age' => 'four', 'email' => 'email'];

        $expectedErrorMessage = [
            'fullname' => [ 'notAlnum' => "'$#!' contains characters which are non alphabetic and no digits"],
            'age' => ['notDigits' => "'four' must contain only digits"],
            'email' => ['emailAddressInvalidFormat' => "'email' is not a valid email address in the basic format local-part@hostname"],
        ];

        $this->form->isValid($invalidProfile);
        $this->assertEquals($expectedErrorMessage, $this->form->getMessages());
    }
}