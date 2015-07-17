<?php

/**
 * Create an instance of service by service name
 * Service name can @see Application_Factory_ServiceName
 */
abstract class Application_Factory_AbstractCreateService
{
    /**
     * Service need resolve get from constant @see Application_Factory_ServiceName
     * @var string
     */
    protected $serviceName = Application_Factory_ServiceName::PROFILE_REPOSITORY;

    /**
     * Create new instance of service
     *
     * @return mixed
     */
    abstract protected function newInstanceOfService();

    /**
     * Check service existing
     * 
     * @return bool
     */
    private function existingSharedInstanceOfService()
    {
        return Zend_Registry::isRegistered($this->serviceName);
    }

    /**
     * Retrieve service from shared store
     *
     * @return Application_Repository_ProfileInterface
     */
    private function getSharedInstanceOfService()
    {
        return Zend_Registry::get($this->serviceName);
    }

    /**
     *
     * @param type $service
     */
    private function shareInstanceOfService($service) {
        Zend_Registry::set($this->serviceName, $service);
    }

    /**
     * Create an instance of service by service name indicated
     * by $this->serviceName
     *
     * @return mixed
     */
    public function createService()
    {
        if (!$this->existingSharedInstanceOfService()) {
            $this->shareInstanceOfService($this->newInstanceOfService());
        }
        return $this->getSharedInstanceOfService();
    }
}