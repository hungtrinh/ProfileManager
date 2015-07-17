<?php

/**
 * Create an instance of Application_Repository_Interface
 *
 * @method Application_Model_Mapper_ProfileInterface createService() create instance of Application_Mapper_ProfileInterface
 */
class Application_Factory_ProfileMapper extends Application_Factory_AbstractCreateService
{
    protected $serviceName = Application_Factory_ServiceName::PROFILE_MAPPER;

    /**
     * 
     * @return Application_Mapper_ProfileInterface
     */
    protected function newInstanceOfService()
    {
        return new Application_Model_DbTable_Profile();
    }
}