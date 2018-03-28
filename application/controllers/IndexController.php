<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
       $Name = new Zend_Session_Namespace('user');
       isset($Name->username) ? $Name->username : 'guest';

    }

    public function indexAction()
    {
        // action body
        if(!isset($_SESSION['user']) || $_SESSION['user']['username'] == 'guest'){
            $this->_redirect('index/login');
        }else{
            $this->view->title = 'My Albums';
            $this->view->username = $_SESSION['user']['username'];
            $albums = new Albums();
            $this->view->albums = $albums->fetchAll();
        }



    }
    public function registerAction()
    {
        $form = new UserForm();
        if ($this->_request->isPost()){
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)){
                $user = new User();
                if($user->checkUnique($form->getValue('username'))){
                    $msg = '用户名已存在';
                    $this->view->title = '注册页面';
                    $this->view->msg = $msg;
                    $form->submit->setLabel('注册');
                    $this->view->form = $form;
                }else{
                    $row = $user->createRow();
                    $row->username = $form->getValue('username');
                    $pwd = $form->getValue('password');
                    $row->password = $this->_md5($pwd);
                    if ($row->save()){
                        $this->_redirect('/index/login');
                    }
                }
            }else{
                $msg = '用户名或密码输入不合法';
                $this->view->title = '注册页面';
                $this->view->msg = $msg;
                $form->submit->setLabel('注册');
                $this->view->form = $form;
            }
        }else{
            $this->view->title = '注册页面';
            $this->view->msg = '';
            $form->submit->setLabel('注册');
            $this->view->form = $form;
        }



    }
    public function loginAction()
    {
        $form = new UserForm();
        if ($this->_request->isPost()) {
            $data = $this->getRequest()->getPost();
            if (!$form->isValid($data)){
                exit('请输入用户名');
            }
            if (is_array($data)){
                $username = $data['username'];
                $password = $data['password'];
            }else{
                $username = '';
                $password = '';
            }
            $pwd = $this->_md5($password);
            $user = new User();
            $db = $user->getAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($db);
            $authAdapter->setTableName('user')
                ->setIdentity($username)
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setCredential($pwd);
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($authAdapter);
            if ($result->isValid()) {
                $_SESSION['user']['username'] = $username;
                $this->_redirect('/index/index');
            }else {
                $msg = '用户名或密码输入有误';
                $this->view->title = '登录页面';
                $this->view->msg = $msg;
                $form->submit->setLabel('登录');
                $this->view->form = $form;
            }

        } else {
            $this->view->title = '登录页面';
            $this->view->msg = '';
            $form->submit->setLabel('登录');
            $this->view->form = $form;
        }

    }
    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        unset($_SESSION['user']);
        $this->_redirect('index/login');
    }

    public function addAction()
    {
        if(!isset($_SESSION['user']) || $_SESSION['user']['username'] == 'guest'){
            $this->_redirect('index/login');
        }
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
        if(!isset($_SESSION['user']) || $_SESSION['user']['username'] == 'guest'){
            $this->_redirect('index/login');
        }
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
        if(!isset($_SESSION['user']) || $_SESSION['user']['username'] == 'guest'){
            $this->_redirect('index/login');
        }
        $this->view->title = "Delete Album";
        if ($this->_request->isPost ()) {
            $id= ( int ) $this->_request->getPost ('id');
            $del= $this->_request->getPost ( 'del' );
            if ($del == 'Yes' && $id > 0) {
                $albums= new Albums ();
                $where= 'id = ' . $id;
                $albums->delete( $where );
            }
            $this->_redirect( '/' );
        }else {
            $id= ( int ) $this->_request->getParam ('id');
            if ($id > 0) {
                $albums= new Albums ();
                $this->view->album = $albums->fetchRow ( 'id=' . $id );
            }
        }

    }
    private function _md5($string)
    {
        return md5('imooc'.$string);
    }

}

