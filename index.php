<?php
use Configs\Routing;

define('APPLICATION',dirname(__FILE__));
define('APPLICATION_VIEW',APPLICATION.'/app/Views/');
define('PATH_CACHE',APPLICATION.'/app/caches');

define('PATH_SERVERNAME','http://'.$_SERVER['SERVER_NAME'].'/');
define('PATH_SERVER',$_SERVER['DOCUMENT_ROOT'].'/');

define('PATH_CSS',PATH_SERVERNAME.'app/view/css/');
define('PATH_JS',PATH_SERVERNAME.'app/view/js/');
define('PATH_IMAGES',PATH_SERVERNAME.'app/images/');


require_once 'app/start.php';


$routing = new Routing();
global $smarty;
$smarty = new Smarty();
$smarty->template_dir = APPLICATION_VIEW;
$smarty->compile_dir = PATH_CACHE.'/templates_c';
$smarty->cache_dir = PATH_CACHE;

$content = $routing->getRouting();


$smarty->assign('PATH_CSS',PATH_CSS);
$smarty->assign('PATH_JS',PATH_JS);
$smarty->assign('PATH_IMAGES',PATH_IMAGES);

$smarty->assign('content',$content);
$smarty->display('layout.tpl');