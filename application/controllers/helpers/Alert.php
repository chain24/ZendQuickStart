<?php

class Zend_Controller_Action_Helper_Alert extends Zend_Controller_Action_Helper_Abstract
{

    function direct($messages,$gourl='')
    {
        $r="<script>";
        $r.="alert('$messages');";
        if($gourl){
            $r.="location.href='$gourl';";
        }else{
            $r.="history.go(-1);";
        }
        $r.="</script>";
        echo $r;
        die();
    }
}
?>
