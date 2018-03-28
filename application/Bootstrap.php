<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initSession()
    {
        $options = $this->getOption('resource');
        $option = $options['session'];
        Zend_Session::setOptions($option);
        Zend_Session::start();
    }
}

