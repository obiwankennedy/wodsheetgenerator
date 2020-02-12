<?php
/*******************************************
*users/auth.php - page d'authentification d'un utilisateur.
*
*Auteur : Renaud GUEZENNEC
*
*******************************************/
	include("../include/driversql.inc.php");
	$dsql = new driversql();
	$dsql->init();

	include("../session/session_lib.php");
	if(($_POST['valider']=='cacher'))
		{
			
			$_SESSION['visible']=$_POST['valider'];
			header('location: '.$_SESSION['URI']);
		}
	else	if((!empty($_POST["login"]))&&(!empty($_POST["password"]))&&($_POST['valider']=='valider'))
	{
	
		
	$dsql->envoirequete('SELECT * FROM users JOIN  usergroup ON usergroup.id = users.groupe WHERE login=\''.$_POST['login'].'\'');
		//$dsql->envoirequete('SELECT * FROM users JOIN  group_user ON group_user.id= Users.id_users INNER JOIN `group` ON group.id_groupe = group_user.id_groupe WHERE login="'.$_POST["login"].'"');
		$dsql->res_tab_assoc($ligne);//=mysql_fetch_array($result);
		//mysql_close($connexion);
		
	
	
		if(($ligne['mdp']==md5($_POST["password"]))&&($ligne['statut']!=0))
		{
	
			delallvalu();
		
			$_SESSION['id']=$ligne['id'];
			$_SESSION['login']=$ligne['login'];
			$_SESSION['password']=$ligne['password'];
			$_SESSION['id_groupe']=$ligne['id_groupe'];
			$_SESSION['nom_group']=$ligne['nom_group'];
			if(isset($_SESSION['URI']))
				header('location: '.$_SESSION['URI']);
			else
				header('location: ../');
		}
		else
		{

			header('location: ../');
		}
		
		
	}
	else if($_GET['id'])
		{
			
			SESSION_START();
			delallvalu();
			header('location: '.$_SESSION['URI']);
		}
		else 
	header('location:  ../');
	
	


?>
