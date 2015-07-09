<?php

class Application_Model_Profile
 extends Zend_Db_Table_Row_abstract
 implements Application_Model_ProfileInterface {

    /**
     * Get profile id
     *
     * @return int profile id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get age
     *
     * @return int age
     */
    public function getAge() {
        $current = new DateTime();
        $dateInterval = $current->diff($this->getBirthDay());
        return $dateInterval->y;
    }

    /**
     * Get fullname
     *
     * @return string fullname
     */
    public function getFullname() {
        return $this->fullname;
    }

    /**
     * Get email
     *
     * @return string email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Get birth day
     *
     * @return DateTime Birth day
     */
    public function getBirthDay() {
        if (empty($this->dob)) {
            throw new DomainException("Missing birth day");
        }
        return new DateTime($this->dob);
    }
}