<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $this->view->title = 'My Albums';
    }

    public function addAction()
    {
        $this->view->title = 'Add New Album';
    }
    function editAction()

    {

        $this->view->title = "Edit Album";

    }

    function deleteAction()

    {

        $this->view->title = "Delete Album";

    }


}

