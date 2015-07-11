<?php

/**
 * Transport ProfileInterface between persistent layer and domain layer
 */
interface Application_Model_Mapper_ProfileInterface
{

    /**
     * Paginator profile list
     *
     * @param int $page page number default 1
     * @param int $size page size default 25
     * @return Zend_Paginator
     */
    public function paginator($page = 1, $size = 25);
}