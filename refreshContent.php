<?php

/*


</div><!-- #topper -->
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://liberty.fdn.fr/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "2"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->


*/
//print_r($_SERVER);

require_once("security/index.php");
require_once("include/libphp/lib.php");
getLang($_SESSION['i18n']);
$currentPage=substr($_SERVER['HTTP_REFERER'],strripos($_SERVER['HTTP_REFERER'], '/')+1,strlen($_SERVER['HTTP_REFERER'])-1);

$currentPath2=explode('/',$_SERVER['HTTP_REFERER']);
//print_r($currentPath);
$currentPage=$currentPath2[3];
$currentPath=array();
$currentPath[1]=$currentPath2[4];
$description="";

//menu
require_once("menu.php"); 

//page
$includedpage = "";

//echo $currentPage,$_SERVER['HTTP_REFERER'],strripos($_SERVER['HTTP_REFERER'], '/')+1,strlen($_SERVER['HTTP_REFERER']);
if((!empty($currentPage)&&($currentPage!="/")))
{
	
	if(file_exists($currentPage.".php"))
	{
		$includedpage = 'modules/'.$currentPage.".php";
	}
	else	
    {
		$includedpage = 'modules/'.$currentPage."/index.php";
    }
	
}
else
	$includedpage = "modules/search/index.php";
	


require_once($includedpage);

echo $page;






?>