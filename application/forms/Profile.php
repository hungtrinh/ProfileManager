<?php

class Application_Form_Profile extends Zend_Form
{

    /**
     * Make fullname element
     *
     * @return \Zend_Form_Element_Text
     */
    private function factoryFullnameElement()
    {
        return [
            'name' => 'fullname',
            'type' => 'text',
            'options' => [
                'validators' => [
                    [
                        'validator' => 'Regex',
                        'breakChainOnFailure' => false,
                        'options' => [
                            'pattern' => '/\w/',
                            'messages' => [Zend_Validate_Regex::NOT_MATCH => "'%value%' contains characters which are non word character"],
                        ]
                    ], //Zend_Validate_Regex
                ], //validators
            ]
        ];
    }

    /**
     * Make dob element
     *
     * @return \Zend_Form_Element_Text
     */
    private function factoryDateOfBirthElement()
    {
        return [
            'name' => 'dob',
            'type' => 'text',
            'options' => [
                'validators' => [
                    [
                        'validator' => 'Date',
                        'breakChainOnFailure' => false,
                    ], //Zend_Validate_Date
                ]
            ]
        ];
    }

    /**
     * Make email element
     *
     * @return \Zend_Form_Element_Text
     */
    private function factoryEmailElement()
    {
        return [
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'validators' => [
                    ['validator' => 'EmailAddress', 'breakChainOnFailure' => false,], //Zend_Validate_EmailAddress
                ]
            ]
        ];
    }

    private function factoryIdElement()
    {
        return [
            'name' => 'id',
            'type' => 'hidden'
        ];
    }

    private function factorySubmitElement()
    {
        return [
            'name' => 'submit',
            'type' => 'submit'
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
}