<?php

/**
 * Switch language want to translate on zend_translate
 * base on current use request language or lastest request language
 *
 * @package Application
 * @subpackage Application_Plugin
 * @author hungtd
 */
class Application_Plugin_I18n extends Zend_Controller_Plugin_Abstract
{
    /**
     * Finish routing request
     * Then change language want to translate and keep track lastest language want translate
     *
     * @param type Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $languageWantTranslateTo = $request->getParam('lang', $request->getCookie('lang'));

        $locale = $this->resolveLocale($languageWantTranslateTo);

        if ( ! $locale)
        {
            return;
        }

        $sharedTranslator = $this->resolveTranslator();

        // Not found translater then nothing to do
        if ( ! $sharedTranslator)
        {
            return;
        }

        $sharedTranslator->getAdapter()

    }

    protected function resolveLocale($languageWantTranslateTo)
    {
        // Not indicate language want translate then nothing to do
        if ( ! $languageWantTranslateTo)
        {
            return null;
        }

        if ( ! Zend_Locale::isLocale($languageWantTranslateTo))
        {
            return null;
        }

        return new Zend_Locale($languageWantTranslateTo);
    }

    protected function resolveTranslator()
    {
        /* @var $sharedTranslater Zend_Translate */
        return Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY) ?: null;
    }

    protected function nofifyBrowser (Zend_Locale $locale)
    {
        // Notify browser set cookie 'lang', keep track lastest request language want translate
        $cookieWriter = new Zend_Http_Header_SetCookie('lang', (string)$locale);
        $this->getResponse()->setRawHeader($cookieWriter);
    }

}
