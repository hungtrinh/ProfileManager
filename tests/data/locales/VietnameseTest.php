<?php

/**
 * Intergration test zend translate resources
 * Specification translate to vietnamese
 * 
 * @group intergation
 */
class Zend_Translate_VietnameseTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Zend_Translate_Adapter | Zend_Translate
     */
    private $translate;
    
    protected function setUp()
    {
        parent::setUp();
        $app = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH. "/configs/application.ini");
        $app->bootstrap('translate');

        $this->translate = $app->getBootstrap()->getResource('translate');
        $this->translate->setLocale(new Zend_Locale('vi_VN'));
    }

    /**
     * @dataProvider translateProvider
     */
    public function testTranslateWillReturnRightResult($messageId, $vietnamesePharses)
    {
        $this->assertEquals($vietnamesePharses, $this->translate->translate($messageId));
    }

    public function translateProvider()
    {
        return [
            ['Empty profile list' , 'Danh sách hồ sơ rỗng'],
            ["Value is required and can't be empty", "Vui lòng nhập liệu và không để trống"], 
        ];
    }
}