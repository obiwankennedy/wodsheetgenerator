<?php

if(!empty($_POST['validate']))
{
  require_once('include/connection/driversql.inc.php');
  $dsql = new driversql();
  $dsql->init();
  $dsql->sendRequest('select * from users where login="'.$_POST["login"].'" or email="'.$_POST["email"].'"');
  if(($dsql->getCount()==0)&&($_POST['password']==$_POST['password2']))
  {
    $pw = crypt($_POST['password'], '$2a$07$jesuismorttrentedeuxfois$');
    $dsql->sendRequest('insert into users values (0,"'.$_POST["login"].'","'.$pw.'","'.$_POST["login"].'",date(now()),2,"'.$_POST['email'].'","'.$_POST['lang'].'",0);');
    mail('renaud@rolisteam.org','New registration on Nwod.rolisteam.org',$_POST["login"].' want to participate to Nwod.rolisteam.org. <br/> His email is: '.$_POST['email']);
    $page.='Congratulation: You have been registered to <a href="http://nwod.rolisteam.org">http://nwod.rolisteam.org</a>.<br/> Your account will be validated soon.';
  }
  else {
    $page.="Error: the login you give or the email are already in use.<br/> Your password and the confirmation did not match. ";
  }
  //| id | login  | password | displayedname | arrivaldate | groupe | email | lang | valid |
}



$title = tr('Registration Form');

$page.='<form id="registration" method="post" action="/auth/register">
<fieldset>
<legend>'.tr("Your identity").'</legend>
<ul>
<li>
  <label for="login">'.tr("Login").'</label>
  <input name="login" id="login" tye="text" required autofocus/>
</li>
<li>
  <label for="password">'.tr("Password").'</label>
  <input type="password" name="password" id="password"/>
</li>
<li>
  <label for="password2">'.tr("Confirm Password").'</label>
  <input type="password" name="password2" id="password2"/>
</li>
<li>
  <label for="email">'.tr("Email").'</label>
  <input name="email" id="email" required/>
</li>
<li>
  <label for="lang">'.tr("Langue").'</label>
  <select name="lang" id="lang" type="select">
    <option name="fr" value="fr">fr</option>
    <option name="en" value="en">en</option>
  </select>
</li>
<li>
<input name="validate" value='.tr("Validate").' type="submit" />
</li>
</ul>
</form>
';

?>
