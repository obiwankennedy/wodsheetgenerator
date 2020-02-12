<?php



if(!empty($_POST['login']))
{

$pw = crypt($_POST['mdp'], '$2a$07$jesuismorttrentedeuxfois$');
$sql='select * from users where login="'.$_POST['login'].'" and password="'.$pw.'" ;';
$dsql->sendRequest('select * from users where login="'.$_POST['login'].'" and password="'.$pw.'" and valid="1";');
if($dsql->getCount()==1)
{
$dsql->res_tab_assoc($user);

//$sql = 'INSERT into users VALUES(2,"zio","'.crypt('changemoi', '$2a$07$jesuismorttrentedeuxfois$').'","zio","2013-12-30",1,"burgaudcedric@gmail.com","fr")';
//$dsql->sendRequest($sql);


if(!empty($_POST['cookieAct']))
{
    setcookie("login",$_POST['login']);
    setcookie("indexSession",$pw);
}

SESSION_START();
$_SESSION['user']=$user;


$page.=redirect(1000,HOME).'<span>'.tr('_connection_allowed_').'</span>';
$body= 'onLoad="redirection_temp()"';
}

}

?>
