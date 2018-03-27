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
        $albums = new Albums();
        $this->view->albums = $albums->fetchAll();
    }
    public function register()
    {
        $this->view->title = '注册页面';
        $form = new UserForm();
        $form->submit->setLabel('注册');
        $this->view->$form = $form;


    }

    public function addAction()
    {
        $this->view->title = 'Add New Album';
        $form = new AlbumForm();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        if($this->_request->isPost()){
            $formData = $this->_request->getPost();
            if($form->isValid($formData)){
                $albums = New Albums();
                $row = $albums->createRow();
                $row->title = $form->getValue('title');
                $row->artist = $form->getValue('artist');
                if($row->save()){
                    $this->_redirect('/');
                }
            }else{
                $form->populate($formData);
            }
        }
    }
    function editAction()

    {

        $this->view->title = "Edit Album";
        $form= new AlbumForm ();

        $form->submit->setLabel ( 'Save' );

        $this->view->form = $form;

        if ($this->_request->isPost ()) {

            $formData= $this->_request->getPost ();

            if ($form->isValid ( $formData )) {

                $albums= new Albums ();

                $id= ( int ) $form->getValue ( 'id' );

                $row= $albums->fetchRow ( 'id=' . $id );

                $row->artist = $form->getValue ( 'artist' );

                $row->title = $form->getValue ( 'title' );

                $row->save();

                $this->_redirect( '/' );

            }else {

                $form->populate( $formData );

            }

        }else {

            // album id is expected in $params['id']

            $id= ( int ) $this->_request->getParam ( 'id', 0 );

            if ($id > 0) {

                $albums= new Albums ();

                $album= $albums->fetchRow ( 'id=' . $id );

                $form->populate( $album->toArray () );

            }

        }
    }

    function deleteAction()

    {

        $this->view->title = "Delete Album";
        if ($this->_request->isPost ()) {

            $id= ( int ) $this->_request->getPost ( 'id' );

            $del= $this->_request->getPost ( 'del' );

            if ($del == 'Yes' && $id > 0) {

                $albums= new Albums ();

                $where= 'id = ' . $id;

                $albums->delete( $where );

            }

            $this->_redirect( '/' );

        }else {

            $id= ( int ) $this->_request->getParam ( 'id' );

            if ($id > 0) {

                $albums= new Albums ();

                $this->view->album = $albums->fetchRow ( 'id=' . $id );

            }

        }

    }


}

