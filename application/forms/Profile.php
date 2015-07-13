<?php

class Application_Form_Profile extends Zend_Form
{

    public function init()
    {
        $this->addElements([
            new Zend_Form_Element_Hidden('id'),
            new Zend_Form_Element_Text('fullname'),
            new Zend_Form_Element_Text('age'),
            new Zend_Form_Element_Text('email'),
            new Zend_Form_Element_Submit('submit')
        ]);
    }
}