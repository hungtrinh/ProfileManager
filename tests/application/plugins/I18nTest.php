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
    public $request;

    /**
     * Response object
     * @var Zend_Controller_Response_Http
     */
    public $response;

    /**
     * Change language plugins
     * @var Application_Plugin_I18n
     */
    public $plugin;

    /**
     * @var Zend_Application
     */
    public $app;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $app = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . "/configs/application.ini");
        $app->bootstrap();  //autoload module resource

        $this->request  = new Zend_Controller_Request_Http();
        $this->response = new Zend_Controller_Response_HttpTestCase();
        $this->plugin   = new Application_Plugin_I18n();
        $this->plugin->setRequest($this->request);
        $this->plugin->setResponse($this->response);
        $this->app = $app;

    }

    public function testWhenUseSwitchLocaleByGetMethodThenOnRouteShutdownSystemChangeLocale()
    {
        $this->request->setQuery('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);

        /* @var $trans Zend_Translate */
        $trans = Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);
        $this->assertEquals('vi_VN', $trans->getAdapter()->getLocale());
    }

    public function testWhenUseSwitchLocaleByGetMethodThenOnRouteShutdownSystemNotifyClientSetCookieLang()
    {
        $this->request->setQuery('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);

        $headers = $this->plugin->getResponse()->getRawHeaders();
        $this->assertEquals('Set-Cookie: lang=vi_VN; HttpOnly', $headers[0]);
    }
}
