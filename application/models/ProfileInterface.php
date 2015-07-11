<?php

/**
 * Hold data and business logic relate profile in app
 */
interface Application_Model_ProfileInterface
{

    /**
     * Get profile id
     *
     * @return int profile id
     */
    public function getId();

    /**
     * Get age of profile
     *
     * @return int age
     */
    public function getAge();

    /**
     * Get fullname
     *
     * @return string fullname
     */
    public function getFullname();

    /**
     * Get email
     *
     * @return string email
     */
    public function getEmail();

    /**
     * Get birth day
     *
     * @return DateTime Birth day
     */
    public function getBirthDay();
}