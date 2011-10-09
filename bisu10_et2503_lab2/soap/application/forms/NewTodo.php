<?php

class Application_Form_NewTodo extends Zend_Form
{

    public function init()
    {
        $this
        ->setMethod('post')
        ->setName('login')
        ->setAction('')
        ;
        
        $username = new Sunny_Form_Element_Username();
        $username->setValue('bisu10');
        
        $textarea = new Zend_Form_Element_Textarea('textarea');
        $textarea->setLabel('Note')
            ->setValue('this is text note.')
        ;
        
        $dateTime = new DateTime();
        $time = new Zend_Form_Element_Text('time');
        $time->setLabel('Time')
            ->setValue($dateTime->format('Y-m-d H:i:s'))
        ;
            
        $options = array('multiOptions'=>array(
           0, 1, 2, 3, 4, 5
        ));
        $priority = new Zend_Form_Element_Select('priority', $options);
        $priority->setLabel('Priority');
        
        $submit = new Sunny_Form_Element_Submit();
        
        $this->addElements(array($username, $textarea, $time, $priority, $submit));
        
        
    }


}

