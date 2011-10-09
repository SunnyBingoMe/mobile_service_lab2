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
        	        if ( ($result = $client->createTodo($form) ) == 'INSERTED'){
    	                $this->view->ok = 1;
    	            }else {
    	                $this->view->message = "err: createTodo";
    	            }
    	        }catch (Exception $e){
    	            $this->view->message = "err: Application_Model_SoapClient".$e->getMessage();
    	            $this->view->errors = $e->getTrace();
    	        	$this->view->form = $form;
    	        }
        	}else {
        	    $this->view->message = "not valid form";
        		$this->view->errors = $form->getMessages();
        		$this->view->form = $form;
        	}
        }else{
           	$this->view->form = $form;
        }
    }


    public function updateAction()
    {
        $form = new Application_Form_Update();
        if ($_POST){
        	if($form->isValid($_POST)){
        	    try{
        	        $client = new Application_Model_SoapClient();
        	        if ( ($returned = $client->updateTodo($form) ) == 'UPDATED'){
    	                $this->view->ok = 1;
    	            }else {
    	                $this->view->message = "err: update fail";
    	            }
    	        }catch (Exception $e){
    	            $this->view->message = "err: try Application_Model_SoapClient".$e->getMessage();
    	            $this->view->errors = $e->getTrace();
    	        	$this->view->form = $form;
    	        }
        	}else {
    	        $this->view->message = "err: post not valid".$e->getMessage();
        	    $this->view->errors = $form->getMessages();
        		$this->view->form = $form;
        	}
        }else{
            $id = $_GET['id'];
            $name = $_GET['name'];
            $textarea = $_GET['note'];
            $time = $_GET['time'];
            $priority = $_GET['priority'];
            
            $form->getElement('id')->setValue($id);
            $form->getElement('username')->setValue($name);
            $form->getElement('textarea')->setValue($textarea);
            $form->getElement('time')->setValue($time);
            $form->getElement('priority')->setValue($priority);
            
           	$this->view->form = $form;
        }
    }



    public function deleteAction()
    {
        $form = new Application_Form_Delete();
        if ($_POST){
        	if($form->isValid($_POST)){
        	    try{
        	        $client = new Application_Model_SoapClient();
        	        if ( ($returned = $client->updateTodo($form) ) == 'UPDATED'){
    	                $this->view->ok = 1;
    	            }else {
    	                $this->view->message = "err: update fail";
    	            }
    	        }catch (Exception $e){
    	            $this->view->message = "err: try Application_Model_SoapClient".$e->getMessage();
    	            $this->view->errors = $e->getTrace();
    	        	$this->view->form = $form;
    	        }
        	}else {
    	        $this->view->message = "err: post not valid".$e->getMessage();
        	    $this->view->errors = $form->getMessages();
        		$this->view->form = $form;
        	}
        }else{
            $id = $_GET['id'];
            
            $form->getElement('id')->setValue($id);
            
           	$this->view->form = $form;
        }
    }

    

}









