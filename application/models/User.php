<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27
 * Time: 9:53
 */

class User extends Zend_Db_Table
{
    protected $_name = 'user';

    /**
     * 检验用户的唯一性
     * @param $name
     * @return bool
     */
    public function checkUnique($name)
    {
        $select = $this->_db->select()->from($this->_name)->where('username=?',$name);
        if($this->getAdapter()->fetchOne($select))
            return true;
        else
            return false;
    }
    public function authCheck($name,$password)
    {
        $select = "SELECT 1 FROM `user` WHERE `username`='$name' AND `password`='$password'";
        if($this->_db->fetchOne($select))
            return true;
        else
            return false;
    }
}