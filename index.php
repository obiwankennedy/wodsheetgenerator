<?php

session_start();
$title="Home";
$body="";
$currentLang=array();

require_once("security/index.php");
require_once("include/libphp/lib.php");

//print_r( $_SESSION);

if(!empty($_GET['path']))
{
 $currentPage = $_GET['path'];
 $currentPath = explode('/',$_GET['path']);
}
else
	$currentPage="default";
    
//print_r(  $currentPath);
//print_r(  $currentPage);
$lang = $_SESSION['i18n'];
if((empty($lang))&&(is_lang($currentPath[0])))
{
    $lang = $currentPath[0];
}
if(!getLang($lang))
{
    getLang("en");
}
else
{
    if((is_array($currentPath))&&(is_lang($currentPath[0])))
    {
        $currentPath = array_slice($currentPath,1);
    }
}
	
$description="";

$css='vtr';

//page
$includedpage = "";
if((!empty($currentPage)&&($currentPage!="/")))
{
	
	if(file_exists('modules/'.$currentPage.".php"))
	{
		$includedpage = 'modules/'.$currentPage.".php";
	}
	else	 if(file_exists('modules/'.$currentPage."/index.php"))
    {
		$includedpage = 'modules/'.$currentPage."/index.php";
    }
    else if(file_exists('modules/'.$currentPath[0].".php"))
    {
        $includedpage = 'modules/'.$currentPath[0].".php";
    }
    else if(file_exists('modules/'.$currentPath[0]."/index.php"))
    {
        $includedpage = 'modules/'.$currentPath[0]."/index.php";
    }
    else if(file_exists('modules/'.$currentPath[0].'/'.$currentPath[0].'.php'))
    {
        $includedpage = 'modules/'.$currentPath[0].'/'.$currentPath[0].'.php';
    }
	
}
else
	$includedpage = "modules/default/index.php";
	


if(strpos($includedpage,"modules/api")=== false)
{

//echo $includedpage;
//page
require_once($includedpage);


//menu
require_once("menu.php"); 

//template
//require_once("include/template/template2.html"); 
require_once("include/template/template_z.html"); 
}
else
{
    
    
    require_once($includedpage);
}

?>
