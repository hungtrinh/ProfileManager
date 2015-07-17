<?php
/**
 * Specification for ProfileModel
 *
 * @author hungtd
 */
class Application_Model_ProfileTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        //autoload
        new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
    }

    public function testWhenMissingDobParamsThenGetBirthDayReturnNull()
    {
        $profile = new Application_Model_Profile(['data' => ['dob'=>'']]);
        $this->assertNull($profile->getBirthDay());

        $profileOther = new Application_Model_Profile(['data' => []]);
        $this->assertNull($profileOther->getBirthDay());
    }

    public function testWhenMissingDobParamsThenGetAgeReturnNull()
    {
        $profile = new Application_Model_Profile(['data' => ['dob'=>'']]);
        $this->assertNull($profile->getAge());

        $profileOther = new Application_Model_Profile(['data' => []]);
        $this->assertNull($profileOther->getAge());
    }
}