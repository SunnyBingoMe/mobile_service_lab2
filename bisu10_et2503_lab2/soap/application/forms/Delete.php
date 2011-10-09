<?php

class Application_Form_Delete extends Zend_Form
{

    public function init()
    {
        $hidden = new Zend_Form_Element_Hidden('id');
        
        $submit = new Sunny_Form_Element_Submit();
        
        $cancel = new Sunny_Form_Element_Submit();
        $cancel->setLabel('Cancel');
        
        $this->addElements(array($hidden, $submit, $cancel));
    }


}

