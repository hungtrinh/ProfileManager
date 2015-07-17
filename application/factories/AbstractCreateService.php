<?php

/**
 * Create an instance of service by service name
 * Service name can @see Application_Factory_ServiceName
 */
abstract class Application_Factory_Abstractcreateservice
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
     * @throws Application_Factory_Exception
     */
    private function getSharedInstanceOfService()
    {
        $cachedInstance = Zend_Registry::get($this->serviceName);
        if (!$cachedInstance instanceof $this->serviceName) {
            throw new Application_Factory_Exception(
                $this->serviceName
                . ' already registered in registry but is '
                . "no instance of {$this->serviceName}"
            );
        }
        return $cachedInstance;
    }

    /**
     *
     * @param type $service
     */
    private function shareInstanceOfService($service)
    {
        Zend_Registry::set($this->serviceName, $service);
    }

    /**
     * Create an instance of service by service name indicated
     * by $this->serviceName
     *
     * @return mixed
     * @throws Application_Factory_Exception
     */
    public function createService()
    {
        if (!$this->existingSharedInstanceOfService()) {
            $this->shareInstanceOfService($this->newInstanceOfService());
        }
        return $this->getSharedInstanceOfService();
    }
}
