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
        return new Zend_Form_Element_Text('fullname',
            [
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
        ]);
    }

    /**
     * Make age element
     *
     * @return \Zend_Form_Element_Text
     */
    private function factoryAgeElement()
    {
        return new Zend_Form_Element_Text('age',
            ['validators' => [
                ['validator' => 'Digits', 'breakChainOnFailure' => false,], //Zend_Validate_Digits
        ]]);
    }

    /**
     * Make email element
     *
     * @return \Zend_Form_Element_Text
     */
    private function factoryEmailElement()
    {
        return new Zend_Form_Element_Text('email',
            ['validators' => [
                ['validator' => 'EmailAddress', 'breakChainOnFailure' => false,], //Zend_Validate_EmailAddress
        ]]);
    }

    public function init()
    {
        $this->addElements([
            new Zend_Form_Element_Hidden('id'),
            $this->factoryFullnameElement(),
            $this->factoryAgeElement(),
            $this->factoryEmailElement(),
            new Zend_Form_Element_Submit('submit')
        ]);
    }
}