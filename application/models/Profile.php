<?php

/**
 * Hold data and business logic relate profile in app
 */
class Application_Model_Profile extends Zend_Db_Table_Row_abstract implements Application_Model_ProfileInterface
{

    /**
     * Get profile id
     *
     * @return int profile id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get age of profile
     *
     * @return int age
     */
    public function getAge()
    {
        if (empty($this->getBirthDay())) {
            return NULL;
        }
        $current      = new DateTime();
        $dateInterval = $current->diff($this->getBirthDay());
        return $dateInterval->y;
    }

    /**
     * Get fullname of profile
     *
     * @return string fullname
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Get email
     *
     * @return string email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get birth day
     *
     * @return DateTime | NULL
     */
    public function getBirthDay()
    {
        if (empty($this->dob)) {
            return NULL;
        }
        return new DateTime($this->dob);
    }
}