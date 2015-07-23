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
        $languageWantTranslateTo = $request->getParam('lang',$request->getCookie('lang'));
        // Not indicate language want translate then nothing to do
        if (!$languageWantTranslateTo) {
            return;
        }

        $languageNotExistInTheWorld = !Zend_Locale::isLocale($languageWantTranslateTo);
        if ($languageNotExistInTheWorld) {
            return;
        }

        /* @var $sharedTranslater Zend_Translate */
        $sharedTranslaterName = Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY;
        $sharedTranslater     = Zend_Registry::get($sharedTranslaterName);

        // Not found translater then nothing to do
        if (!$sharedTranslater) {
            return;
        }

        // Language valid then switch translator to locale indicate by language
        $locale = new Zend_Locale($languageWantTranslateTo);
        $sharedTranslater->getAdapter()->setLocale($locale);

        // Notify browser set cookie 'lang', keep track lastest request language want translate
        $cookieWriter = new Zend_Http_Header_SetCookie('lang', (string)$locale);
        $this->getResponse()->setRawHeader($cookieWriter);
    }
}
