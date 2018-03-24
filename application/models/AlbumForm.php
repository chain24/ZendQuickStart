<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 14:17
 */

class AlbumForm extends Zend_Form
{
    public function __construct($options=null)
    {
        parent::__construct($options);
        $this->setName('album');
        $id = new Zend_Form_Element_Hidden('id');
        $artist = new Zend_Form_Element_Text('artist');
        $artist->setLabel('Artist')
            ->setRequired(true)
            ->addFilter('Strip Tags')
            ->addFilter('String Trim')
            ->addValidator('NotEmpty');
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('title')
            ->setRequired(true)
            ->addFilter('Strip Tags')
            ->addFilter('String Trim')
            ->addValidator('NotEmpty');
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id','submitbutton');
        $this->addElements(array($id, $artist, $title, $submit));
    }
}