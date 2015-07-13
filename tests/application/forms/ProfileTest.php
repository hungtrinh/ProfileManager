<?php

class Application_Form_ProfileTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Application_Form_Profile
     */
    private $form;

    protected function setUp()
    {
        $app = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . "/configs/application.ini");
        $app->bootstrap();
        $this->form = new Application_Form_Profile();
    }

    public function invalidProfileProvider()
    {
        return [
            [['fullname' => '$#!', 'age' => 'four', 'email' => 'email']],
            [['fullname' => '$#!']],
            [['age' => 'four']],
            [['email' => 'email']]
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
}