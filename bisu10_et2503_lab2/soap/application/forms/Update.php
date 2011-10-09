<?php

class Application_Form_Update extends Application_Form_NewTodo
{

    public function init()
    {
        parent::init();
        
        $hidden = new Zend_Form_Element_Hidden('id');
        
        $this->addElement($hidden);
    }


}

