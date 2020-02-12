<?php

include_once("include/connection/driversql.inc.php");
$dsql = new driversql();
$dsql->init();

$temp_menu='';

if(currentUserIsRegisted())
	$dsql->sendRequest('select * from menu order by position');
else
	$dsql->sendRequest('select * from menu where type=1 order by position');

$temp_menu.='<h2 class="widget-title">'.tr('Navigation').'</h2><ul class="menu_second">';
while($dsql->res_tab_assoc($line))
{
	if((!strcmp($currentPage,$line['path']))||(!strcmp($currentPage, substr($line['path'],1))))
	{
		$description .= $line['description'];

		$temp_menu.='<li class="currentTab"><a href="/'.$line['path'].'">'.tr($line['title']).'</a></li>';
	}
	else
		$temp_menu.='<li><a href="/'.$line['path'].'">'.$line['title'].'</a></li>';
}



if(!currentUserIsRegisted())
{
$temp_menu.='</ul>

<div>
<h2 class="widget-title">'.tr('Authentification').'</h2>
<form action="/auth/connect" method="post">
<ul>
<li>Login: <input name="login"/></li>
<li>Pass:<input type="password" name="mdp"/></li>
<li><input type="submit" value="Log in"/> '.tr('RememberMe?').'<input type="checkbox" name="cookieAct" id="cookieAct" value="cookieAct"/> <a href="/auth/register">'.tr('_register?_').'</a></li>
</ul>
</form>';


}
else
{
    $temp_menu.='<div><h2 class="widget-title">Authentification</h2>'.tr('_welcome_user_').': '.$_SESSION['user']['displayedname'].'';
}

$temp_menu.='<ul>';
$dsql->sendRequest('describe i18n');
$forbidden_field=array('id','wordkey');
    while($dsql->res_tab_assoc($line))
    {
        if(!isInside($line['Field'],$forbidden_field))
        {
            $temp_menu.='<li><a href="/i18n/'.$line['Field'].'"><img src="include/resources/icon/'.$line['Field'].'.png" alt="'.$line['Field'].'"/></a></li>';
        }

    }
$temp_menu.='</ul>';
$temp_menu.='</div><div><ul><li><img alt="" src="" /></li></ul></div>';



$menu=$temp_menu.$menu;
?>
