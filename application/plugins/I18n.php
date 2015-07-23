<?php

/**
 * Switch language want to translate on zend_translate
 * base on current use request language or lastest request language
 *
 * @package Application
 * @subpackage Application_Plugin
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

        // Not indicate language want translate then nothing to do
        if ( ! $languageWantTranslateTo) {
            return;
        }

        $locale = $this->resolveLocale($languageWantTranslateTo);
        if ( ! $locale) {
            return;
        }

        $success = $this->notifyTranslatorUsingLocale($locale);
        if ( ! $success) {
            return;
        }

        $this->notifyBrowserUsingLocale($locale);
    }

    /**
     * Resolve the locale by language that you want translate to.
     * If the locale is not existed in the world, we'll return null
     *
     * @param string $languageWantTranslateTo The language that you want to translate to
     * @return  Zend_Locale|null
     */
    protected function resolveLocale($languageWantTranslateTo)
    {
        // If the locale is not existed, then returning null
        if ( ! Zend_Locale::isLocale($languageWantTranslateTo)) {
            return null;
        }

        return new Zend_Locale($languageWantTranslateTo);
    }


    /**
     * Notify the translator using the resolved locale.
     *
     * @param Zend_Locale $locale The resolved locale
     * @return  bool
     */
    protected function notifyTranslatorUsingLocale(Zend_Locale $locale)
    {
        /* @var $sharedTranslator Zend_Translate */
        $sharedTranslator = Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY) ?: null;

        // If no translator found, assuming notify process has failed
        if ( ! $sharedTranslator) {
            return false;
        }

        $sharedTranslator->getAdapter()->setLocale($locale);

        return true;
    }

    /**
     * Notify the browser to "understand" the locale that we resolved.
     *
     * @param Zend_Locale $locale The resolved locale
     */
    protected function notifyBrowserUsingLocale(Zend_Locale $locale)
    {
        // Notify browser set cookie 'lang', keep track lastest request language want translate
        $cookieWriter = new Zend_Http_Header_SetCookie('lang', (string)$locale);

        $this->getResponse()->setRawHeader($cookieWriter);
    }

}
