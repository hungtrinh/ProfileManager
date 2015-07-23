<?php

/**
 * Switch translater (Zend_Translate) use new language
 * When use changing display language
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
        $rememberLanguage = $request->getCookie('lang');
        $languageSwitchTo = $request->getParam('lang', $rememberLanguage);

        if (!$languageSwitchTo) {
            // Not indicate language want translate then nothing to do
            return;
        }

        $locale = $this->findLocaleRelative($languageSwitchTo);
        if (!$locale) {
            //language is invalid or not supported in this system
            return;
        }

        if (!$this->switchTranslateToNewLanguage($locale)) {
            //Setting translator translate new language indicate by locale failed
            return;
        }

        $this->doRememberLanguage($locale);
    }

    /**
     * Resolve the locale by language that you want translate to.
     * If the locale is not existed in the world, we'll return null
     *
     * @param string $languageWantTranslateTo The language that you want to translate to
     * @return  Zend_Locale|null
     */
    private function findLocaleRelative($languageWantTranslateTo)
    {
        // If the locale is not existed, then returning null
        if (!Zend_Locale::isLocale($languageWantTranslateTo)) {
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
    private function switchTranslateToNewLanguage(Zend_Locale $locale)
    {
        $notFoundsharedTranslator = !Zend_Registry::isRegistered(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);

        if ($notFoundsharedTranslator) {
            return false;
        }

        $sharedTranslator = Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);
        $sharedTranslator->getAdapter()->setLocale($locale);

        return true;
    }

    /**
     * Notify the browser to "understand" the locale that we resolved.
     *
     * @param Zend_Locale $locale The resolved locale
     */
    private function doRememberLanguage(Zend_Locale $locale)
    {
        // Notify browser set cookie 'lang', keep track lastest request language want translate
        $cookieWriter = new Zend_Http_Header_SetCookie('lang', (string) $locale);

        $this->getResponse()->setRawHeader($cookieWriter);
    }
}