<?php
SESSION_START();
	if(!isset($_SESSION['id_groupe']))
		$_SESSION['id_groupe']=0;
function checkSession($type)
{
	/*print_r($_SESSION);
	echo "type=",$type;*/
	if(isset($_SESSION['nom_group']))
		if($_SESSION['nom_group']==$type)
			return true;
		else
			return false;
	else 
		return false;
}
function checkSession2($type)
{
	
	if(isset($_SESSION['type']))
		if($_SESSION['type']==$type)
			return true;
		else
			return false;
	else 
		return false;
}
function checkAuth()
{
	
	if(isset($_SESSION['nom_group']))
		return true;
	else
		return false;

}
function delVa($type)
{
	if(isset($_SESSION[$type]))
	{
  		if(session_unregister($type)) 
		{
      			return  true;
  		}
		else 
		{
	      		return  false;
  		}
	}
	else
	return false;
}
function delSession()
{
	
	if(session_destroy()) {
			
     		return  true;
  	} else {
    		 return  false;
  	}
}
function delallvalu()
{
	$temp=$_SESSION['URI'];

	//$page.= $temp;
	session_unset();
	//$page.= $temp;
	$_SESSION['URI']=$temp;

	//$page.= $_SESSION['URI'];
}
?>
