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

    public function checkUnique($name)
    {
        $select = $this->_db->select()->from($this->_name)->where('username=?',$name);
        if($this->getAdapter()->fetchOne($select))
            return true;
        else
            return false;
    }
}