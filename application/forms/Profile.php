<?php

class Application_Form_Profile extends Twitter_Bootstrap3_Form_Horizontal
{
    /**
     * Element name constant
     */
    const ELEMENT_ID       = 'id';
    const ELEMENT_FULLNAME = 'fullname';
    const ELEMENT_DOB      = 'dob';
    const ELEMENT_EMAIL    = 'email';
    const ELEMENT_SUBMIT   = 'submit';

    /**
     * Make fullname element
     *
     * @return \Zend_Form_Element_Text
     */
    private function factoryFullnameElement()
    {
        return [
            'name' => self::ELEMENT_FULLNAME,
            'type' => 'text',
            'options' => [
                'label' => 'Fullname',
                'validators' => [
                    [
                        'validator' => 'Regex',
                        'breakChainOnFailure' => false,
                        'options' => [
                            'pattern' => '/\w/',
                            'messages' => [Zend_Validate_Regex::NOT_MATCH => "'%value%' contains characters which are non word character"],
                        ]
                    ], // Zend_Validate_Regex
                ], // validators
            ] // options
        ];
    }

    /**
     * Make dob element
     *
     * @return \Zend_Form_Element_Text
     */
    private function factoryDateOfBirthElement()
    {
        return $this->createElement('text', self::ELEMENT_DOB,[
            'label' => 'Birthday',
            'placeholder' => "2018-01-30",
            'validators' => [
                [
                    'validator' => 'Date',
                    'breakChainOnFailure' => false,
                ], //Zend_Validate_Date
            ]
        ]);
    }

    /**
     * Make email element
     *
     * @return []
     */
    private function factoryEmailElement()
    {
        return [
            'name' => self::ELEMENT_EMAIL,
            'type' => 'text',
            'options' => [
                'label' => 'Email',
                'validators' => [
                    ['validator' => 'EmailAddress', 'breakChainOnFailure' => false,], //Zend_Validate_EmailAddress
                ]
            ]
        ];
    }

    /**
     * Make id element
     *
     * @return []
     */
    private function factoryIdElement()
    {
        return [
            'name' => self::ELEMENT_ID,
            'type' => 'hidden'
        ];
    }

    /**
     * Make submit button
     *
     * @return []
     */
    private function factorySubmitElement()
    {
        return [
            'name' => self::ELEMENT_SUBMIT,
            'type' => 'submit',
            'options' => [
                'label' => 'Add'
            ]
        ];
    }

    public function init()
    {
        $this->addElements([
            $this->factoryIdElement(),
            $this->factoryFullnameElement(),
            $this->factoryDateOfBirthElement(),
            $this->factoryEmailElement(),
            $this->factorySubmitElement()
        ]);
    }

    public function bindFromProfile(Application_Model_ProfileInterface $profile)
    {
        $this->populate([
            self::ELEMENT_ID => $profile->getId() ? $profile->getId() : NULL,
            self::ELEMENT_DOB => $profile->getBirthDay() ? $profile->getBirthDay()->format('Y-m-d') : NULL,
            self::ELEMENT_EMAIL => $profile->getEmail(),
            self::ELEMENT_FULLNAME => $profile->getFullname()
        ]);
    }
}
