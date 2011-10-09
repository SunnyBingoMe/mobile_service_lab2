<?php

class Application_Model_SoapClient
{
    protected $client;
    
    public function __construct(){
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
        	$this->client = new SoapClient(APPLICATION_PATH."/../library/Sunny/scripts/site_dependent/todo.wsdl");
        }catch (Exception $e){
        	throw $e;
        }
        
    }
    
    public function getTodoList($name = 'bisu10'){
        try {
            $resultGetTodoList = get_object_vars($this->client->getTodoList($name));
        }catch (Exception $e){
            throw $e;
        }
        
        return $resultGetTodoList = $resultGetTodoList['TodoData'];
    }
    
    public function createTodo($form) {
        $acronym = $form->getValue('username');
        $time = $form->getValue('time');
        $note = $form->getValue('textarea');
        $priority = $form->getValue('priority');

        try {
            $result = $this->client->createTodo($acronym, $time, $note, $priority);
        }catch (Exception $e){
            throw $e;
        }
        
        return $result;
        
    }
    
    public function updateTodo($form) {
        $id = $form->getValue('id');
        $acronym = $form->getValue('username');
        $time = $form->getValue('time');
        $note = $form->getValue('textarea');
        $priority = $form->getValue('priority');

        try {
            $result = $this->client->updateTodo($id, $acronym, $time, $note, $priority);
        }catch (Exception $e){
            throw $e;
        }
        
        return $result;
        
        
    }


}

