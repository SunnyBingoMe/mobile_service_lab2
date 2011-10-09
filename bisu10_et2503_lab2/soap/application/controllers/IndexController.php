<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $client = new Application_Model_SoapClient();
        $this->view->resultGetTodoList = $client->getTodoList();
        
    }

    public function scriptAction()
    {
        // nothing. 
    }

    public function newAction()
    {
        $form = new Application_Form_NewTodo();
        if ($_POST){
        	if($form->isValid($_POST)){
        	    try{
        	        $client = new Application_Model_SoapClient();
        	        $acronym = $form->getValue('username');
        	        $time = $form->getValue('time');
        	        $note = $form->getValue('textarea');
        	        $priority = $form->getValue('priority');
        	        if ( ($returned = $client->createTodo($acronym, $time, $note, $priority) )
        	            == 'INSERTED'){
    	                $this->view->ok = 1;
    	            }
        	        
    	        }catch (Exception $e){
    	            $this->view->errors = $e->getTrace();
    	        	$this->view->form = $form;
    	        }
        	}else {
        		$this->view->errors = $form->getMessages();
        		$this->view->form = $form;
        	}
        }else{
           	$this->view->form = $form;
        }
        
    }


}





