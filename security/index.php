<?php
require_once('security/session_lib.php');

if(!empty($_POST['valider']))
{

	require_once('include/connection/driversql.inc.php');
	$dsql = new driversql();
	$dsql->init();
	
	$dsql->sendRequest('SELECT * FROM users WHERE login=\''.$_POST["login"].'\'');
	$dsql->res_tab_assoc($line);

//	echo ($line['password']==md5($_POST["passwd"]));
	if(($line['password']==md5($_POST["passwd"])))
	{

		if($line['group']!=3)
		{
/*			$dsql->sendRequest('SELECT users.*,usergroup.id as idgroup, usergroup.name as namegroup, character.id as idchar FROM users JOIN  usergroup ON usergroup.id= users.groupe left JOIN character ON character.id = users.id_character WHERE login=\''.$_POST["login"].'\'');
			delallvalu();
			$dsql->res_tab_assoc($line);
			$_SESSION['id']=$line['id'];
			$_SESSION['idchar']=$line['idchar'];
			$_SESSION['login']=$line['login'];
			//$_SESSION['password']=$line['password'];
			$_SESSION['id_groupe']=$line['idgroup'];
			$_SESSION['nom_group']=$line['namegroup'];*/

		}
		else
		{
		/*	$dsql->sendRequest('SELECT users.*,usergroup.id as idgroup, usergroup.name as namegroup FROM users JOIN  usergroup ON usergroup.id= users.groupe WHERE login=\''.$_POST["login"].'\'');
                        delallvalu();
			$dsql->res_tab_assoc($line);
                        $_SESSION['id']=$line['id'];
//                        $_SESSION['idchar']=$line['idchar'];
                        $_SESSION['login']=$line['login'];
                        //$_SESSION['password']=$line['password'];
                        $_SESSION['id_groupe']=$line['idgroup'];
                        $_SESSION['nom_group']=$line['namegroup'];*/

		}
	}
	else
	{

//			header('location: ../');
		echo "erreur";
	}
	



}
else if(empty($_SESSION['id']))
{
	
/*$leftcol .= '
<form method="post" action="#">
Login: <input name="login"/>
Password: <input type="password" name="passwd"/>
<input type="submit" name="valider" value="Valider"/>
</form>';*/
}

?>
