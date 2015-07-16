<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initResourceLoader()
    {
        $this->getResourceLoader()
                ->addResourceType('repository', 'repositories/', 'Repository')
                ->addResourceType('factory', 'factories/', 'Factory');
    }
}