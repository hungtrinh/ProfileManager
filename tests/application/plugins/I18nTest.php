<?php

/**
 * Test class for Application_Plugin_I18n.
 *
 * @category   Application
 * @package    Application_Plugin
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @group      Application_Plugin
 */
class Application_Plugin_I18nTest extends PHPUnit_Framework_TestCase
{
    /**
     * Request object
     * @var Zend_Controller_Request_Http
     */
    private $request;

    /**
     * Response object
     * @var Zend_Controller_Response_Http
     */
    private $response;

    /**
     * Change language plugins
     * @var Application_Plugin_I18n
     */
    private $plugin;

    /**
     * 
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        parent::setUp();
        Zend_Registry::_unsetInstance();

        $app = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . "/configs/application.ini");
        $app->getBootstrap()->getResourceLoader();  //trigger default autoload module resource only

        $this->request  = new Zend_Controller_Request_Http();
        $this->response = new Zend_Controller_Response_HttpTestCase();
        $this->plugin   = new Application_Plugin_I18n();
        $this->plugin->setRequest($this->request);
        $this->plugin->setResponse($this->response);
    }

    /**
     *
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
        //destroy dirty singleton instance
        Zend_Registry::_unsetInstance();
        parent::tearDown();
    }

    protected function prepaireSharedTranslaterForTestContext()
    {
        /**
         * Prepaire environment
         */
        $translater = new Zend_Translate([
            'adapter' => 'Array',
            'content' => [
                'hello' => 'hello'
            ],
            'locale' => 'en_US'
        ]);
        $translater->addTranslation([
            'content' => [
                'hello' => 'xin chao'
            ],
            'locale' => 'vi_VN'
        ]);
        $translater->getAdapter()->setLocale('en_US');
        Zend_Registry::set(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY, $translater);
        return $translater;
    }

    public function testWhenUseNotChooseLanguageAndSystemNotRememberLastLanguageUseChooseThenPluginI18nNoThingTodo()
    {
        $translater = $this->prepaireSharedTranslaterForTestContext();

        //run plugin - do examine
        $this->plugin->routeShutdown($this->request);

        /* @var $trans Zend_Translate */
        $sharedTranslater = Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);

        //verify nothing change
        $this->assertEquals($translater->getLocale(), $sharedTranslater->getLocale());
        $this->assertEquals($translater->translate('hello'), $sharedTranslater->translate('hello'));
        $this->assertEmpty($this->response->getRawHeaders());
    }

    public function testWhenSystemNotPredefinedTranslatorSharedResourceThenPluginI18nNoThingTodo()
    {
        $this->request->setQuery('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);
        $this->assertEmpty($this->response->getRawHeaders());
    }


    public function testWhenUseSwitchLocaleThenSystemDoChangeLanguageOnTranslatorShared()
    {
        $this->prepaireSharedTranslaterForTestContext();

        $this->request->setQuery('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);

        /* @var $trans Zend_Translate */
        $trans = Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);
        $this->assertEquals('vi_VN', (string)$trans->getAdapter()->getLocale());
    }

    public function testWhenUseSwitchLocaleThenSystemNotifyRememberLanguage()
    {
        $this->prepaireSharedTranslaterForTestContext();
        $this->request->setQuery('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);

        $headers = $this->plugin->getResponse()->getRawHeaders();
        $this->assertContains('Set-Cookie: lang=vi_VN', $headers, print_r($headers,true));
    }
}
