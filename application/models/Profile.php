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
        $dob = new DateTime($this->dob);
        $dateInterval = $current->diff($dob);
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
        return new DateTime($this->dob);
    }
}
