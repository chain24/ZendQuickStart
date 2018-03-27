<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27
 * Time: 10:27
 */

class UserRegisterForm extends Zend_Form
{
    public function __construct($options=null)
    {
        parent::__construct($options);
        $this->setName('registerForm');
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('用户名：')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('密 码：')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id','registerbutton')->setLabel('注册');
        $this->addElements(array($username, $password, $submit));
    }
}