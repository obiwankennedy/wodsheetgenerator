<?php

$_SESSION['i18n']=$currentPath[1];




$page.=redirect(1000,HOME).'<span>'.tr('_WebSite_Translation_').'</span>';
$body= 'onLoad="redirection_temp()"';
?>