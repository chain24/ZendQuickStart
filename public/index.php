<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';
/**
 * 类的自动加载
 */
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
//设置控制器
$frontController =Zend_Controller_Front::getInstance();
$frontController->throwExceptions(true);
$frontController->setControllerDirectory('../application/controllers');
Zend_Layout::startMvc(array('layoutPath'=>'../application/layouts'));
set_include_path('.'.PATH_SEPARATOR.'../library'.PATH_SEPARATOR.'../application/models'.PATH_SEPARATOR.get_include_path());

// Create application, bootstrap, and run
$config = new Zend_Config_Ini('../application/configs/application.ini', 'general');

$registry =Zend_Registry::getInstance();

$registry->set('config',$config);
$db = Zend_Db::factory($config->db);
Zend_Db_Table::setDefaultAdapter($db);

$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();