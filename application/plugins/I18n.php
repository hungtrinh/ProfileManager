<?php

/**
 * Change language used in application (Zend_Translate::setLocale(newLanguage))
 * when use changing display language
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
        $rememberLanguage                = $request->getCookie('lang');
        $languageWantTranslateTo         = $request->getParam('lang',$rememberLanguage);
        $notFoundRequestChangingLanguage = !$languageWantTranslateTo;

        if ($notFoundRequestChangingLanguage
            || $this->systemNotSupported($languageWantTranslateTo)
            || $this->notFoundSharedTranslator()) {
            return;
        }

        $this->changeLanguageUsedInApplication($languageWantTranslateTo);
        $this->remember($languageWantTranslateTo);
    }

    /**
     * Notify the translator using the resolved locale.
     *
     * @param Zend_Locale | string $locale 
     * @return  void
     */
    private function changeLanguageUsedInApplication($locale)
    {
        $sharedTranslator = Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);
        $sharedTranslator->getAdapter()->setLocale($locale);
    }

    /**
     * Notify the browser to keeptrack lastest language use changing
     *
     * @param Zend_Locale | string $languageWantTranslateTo locale or language
     */
    private function remember($languageWantTranslateTo)
    {
        // Notify browser set cookie 'lang', keep track lastest request language want translate
        $cookieWriter = new Zend_Http_Header_SetCookie('lang', (string) $languageWantTranslateTo);

        $this->getResponse()->setRawHeader($cookieWriter);
    }

    /**
     * Indicate system not support this $languageWantTranslateTo
     * 
     * @param string $languageWantTranslateTo
     * @return boolean
     */
    private function systemNotSupported($languageWantTranslateTo)
    {
        return !Zend_Locale::isLocale($languageWantTranslateTo);
    }

    /**
     * Indicate not found shared translator
     * @return boolean
     */
    private function notFoundSharedTranslator()
    {
        return !Zend_Registry::isRegistered(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);
    }
}