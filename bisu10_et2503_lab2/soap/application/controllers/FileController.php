<?php

class FileController extends Zend_Controller_Action
{
    

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function hrefAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $realFile = realpath(APPLICATION_PATH . '/../' . getRawQueryString());
	    readfile( $realFile );

    }


}



