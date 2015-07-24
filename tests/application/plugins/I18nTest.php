<?php

/**
 * Test class for Application_Plugin_I18n.
 *
 * @category   Application
 * @package    Application_Plugin
 * @subpackage UnitTests
 * @group      Application_Plugin
 */
class Application_Plugin_I18nTest extends PHPUnit_Framework_TestCase
{
    /**
     * Request object
     * @var Zend_Controller_Request_HttpTestCase
     */
    private $request;

    /**
     * Response object
     * @var Zend_Controller_Response_HttpTestCase
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

        $this->request  = new Zend_Controller_Request_HttpTestCase();
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
        $this->request = null;
        $this->response = null;
        $this->plugin = null;
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

    public function testWhenRequestChangeDisplayLanguageNotFoundThenThePluginI18nDoNothing()
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

    public function testWhenSystemDoesNotHaveSharedTranslatorThenThePluginI18nDoNothing()
    {
        $this->request->setQuery('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);
        $this->assertEmpty($this->response->getRawHeaders());
    }


    public function testWhenUseSwitchLanguageSuccessThenSystemChangeTheUsedLanguageInApplication()
    {
        $this->prepaireSharedTranslaterForTestContext();

        $this->request->setQuery('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);

        /* @var $trans Zend_Translate */
        $trans = Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);
        $this->assertEquals('vi_VN', (string)$trans->getAdapter()->getLocale());
    }

    public function testWhenUseSwitchLanguageSuccessThenSystemRememberTheSwitchedLangauge()
    {
        $this->prepaireSharedTranslaterForTestContext();
        $this->request->setQuery('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);

        $this->assertPluginI18nSetCookieRightWay();
    }

    public function testWhenGetRememberedLanguageSuccessThenSystemChangeTheUsedLanguageInApplication()
    {
        $this->prepaireSharedTranslaterForTestContext();

        $this->request->setCookie('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);

        /* @var $trans Zend_Translate */
        $trans = Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);
        $this->assertEquals('vi_VN', (string)$trans->getAdapter()->getLocale());

    }

    public function testWhenGetRememberedLanguageSuccessThenSystemRememberTheSwitchedLangauge()
    {
        $this->prepaireSharedTranslaterForTestContext();
        $this->request->setCookie('lang', 'vi_VN');
        $this->plugin->routeShutdown($this->request);

        $this->assertPluginI18nSetCookieRightWay();
    }

    protected function assertPluginI18nSetCookieRightWay()
    {
        $headers = $this->response->getRawHeaders();
        $this->assertNotEmpty($headers);

        /* @var $setCookie Zend_Http_Header_SetCookie */
        $setCookie = Zend_Http_Header_SetCookie::fromString($headers[0]);
        $dateAHead = new DateTime($setCookie->getExpires());
        $dayAHeadExpireCookie = $dateAHead->diff(new DateTime())->days;

        $this->assertEquals('lang', $setCookie->getName(), print_r($setCookie,true));
        $this->assertEquals('vi_VN', $setCookie->getValue(), print_r($setCookie,true));
        $this->assertEquals('/', $setCookie->getPath(), print_r($setCookie,true));
        $this->assertNull($setCookie->getDomain(), print_r($setCookie,true));
        $this->assertEquals(10, $dayAHeadExpireCookie);
    }
}
