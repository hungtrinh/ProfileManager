<?php

/**
 * Create an instance of Application_Repository_Interface
 *
 * @method Application_Repository_ProfileInterface createService() create instance of Application_Repository_ProfileInterface
 */
class Application_Factory_ProfileRepository extends Application_Factory_AbstractCreateService
{
    protected $serviceName = Application_Factory_ServiceName::PROFILE_REPOSITORY;
    
    /**
     * 
     * @return Application_Repository_ProfileInterface
     */
    protected function newInstanceOfService()
    {
        $profileMapperFactory = new Application_Factory_ProfileMapper();
        return new Application_Repository_Profile(
            $profileMapperFactory->createService()
        );
    }
}