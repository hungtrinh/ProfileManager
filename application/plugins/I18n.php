<?php

/**
 * I18n reponsibility
 * - Switch language on zend_translate when choose language
 *
 * @package Application
 * @subpackage Application_Plugin
 * @author hungtd
 */
class Application_Plugin_I18n extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        /* @var $trans Zend_Translate */
        $trans = Zend_Registry::get(Zend_Application_Resource_Translate::DEFAULT_REGISTRY_KEY);

        if (!$trans) {
            return;
        }
        $lang = $request->getParam('lang',$request->getCookie('lang'));
        if (!$lang) {
            return;
        }

        if (!Zend_Locale::isLocale($lang)) {
            return;
        }

        $locale = new Zend_Locale($lang);
        $trans->getAdapter()->setLocale($locale);

        $this->getResponse()->setRawHeader(new Zend_Http_Header_SetCookie(
            'lang', $locale, NULL, NULL, NULL , false, true
        ));
    }

}
