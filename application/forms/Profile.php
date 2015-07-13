<?php

class Application_Form_Profile extends Zend_Form
{

    public function init()
    {
        $this->addElements([
            new Zend_Form_Element_Hidden('id'),
            new Zend_Form_Element_Text('fullname', ['validators' => [new Zend_Validate_Alnum]]),
            new Zend_Form_Element_Text('age', ['validators' => [new Zend_Validate_Digits()]]),
            new Zend_Form_Element_Text('email', ['validators' => [new Zend_Validate_EmailAddress]]),
            new Zend_Form_Element_Submit('submit')
        ]);
    }
}