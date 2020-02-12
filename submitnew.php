<?php


   // print_r($_POST);

/*echo '<pre>';
print_r($_POST);
print_r($_GET);
echo '</pre>';*/
if(!empty($_GET['id']))
{

    require_once('include/connection/driversql.inc.php');
    $dsql= new driversql();
    $dsql->init();
    require_once('data/character.php');
    $char=array();
    $idchar=$_GET['id'];
    $dsql->sendRequest('select * from characters where id ='.$_GET['id']);
    $dsql->res_tab_assoc($line);
//    print_r($line);
//    echo "truc",$_GET['id'];
    $dsql->sendRequest('select * from char2power where id_char ='.$_GET['id']);
    $i=0;
    while($dsql->res_tab_assoc($pow))
    {
        $line['pw_'.$i]=$pow['id_pow'];
        $line['pw_val_'.$i]=$pow['value'];
        $i++;
    }
    $dsql->sendRequest('select * from char2advantage where id_char ='.$_GET['id']);
    $i=0;
    while($dsql->res_tab_assoc($pow))
    {
       $line['av_'.$i]=$pow['id_advantage'];
       $line['av_val_'.$i]=$pow['value'];
       $i++;
    }
    $char=new Character($line);
    
    switch($line['type_being'])
    {
        case 1: //humain
            include('data/htv/charactersheet.php');
        break;
        case 2: //vampire
            include('data/vtr/charactersheet.php');
        break;
        case 4://lg
            $char->buildRenom($dsql);
            include('data/wtf/charactersheet.php');
        break;
        case 3://mage
            include('data/mta/charactersheet.php');
       break;
	case 5:
	include('data/ctl/charactersheet.php');
       break;


    }

}
else if($_POST['generatepdf']=='Générer Fiche')
{
    require_once('data/character.php');
    $char = new Character($_POST);
 //  echo 'test du type'.$id; 
   header('Content-Disposition: attachment; filename="download.pdf"');

    switch($_POST['type_being'])
    {
        case 1: //humain
            include('data/htv/charactersheet.php');
        break;
        case 2: //vampire
            include('data/vtr/charactersheet.php');
        break;
        case 4://lg
            include('data/wtf/charactersheet.php');
        break;
        case 3://mage
            include('data/mta/charactersheet.php');
       break;
       case 5:
//	echo 'changeling';
	include('data/ctl/charactersheet.php');
       break;
    } 
       






}
else if($_POST['save']=='Enregistrer')
{
//print_r($_POST);
    require_once('include/connection/driversql.inc.php');
    $dsql= new driversql();
    $dsql->init();

    $sql='describe characters;';
    $dsql->sendRequest($sql);
    $insertStr='';
    $i=0;
    $field='';
    while($dsql->res_tab_assoc($line))
    {
        if($line['Field']!='id')
        {    
            if($i!=0)
            {
                $insertStr.=',';
            }
    
            $field.=$line['Field'].',';
//            echo $line['Field'].'='.$_POST[$line['Field']].'='.$line['Type'].'<br/>';   
            if(strpos($line['Type'],'int')===false)
                $insertStr.="\"".trim($_POST[$line['Field']])."\"";
            else
                $insertStr.=(!empty($_POST[$line['Field']]))?$_POST[$line['Field']]:0;

        
            $i++;
        }

    }
    $field=substr($field,0,-1);
  //  $sql='INSERT INTO characters ('.$field.')VALUES('.$insertStr.')';
  //  echo $sql.'<br/><br/>';
  $dsql->sendRequest($sql);


  $lastid=$dsql->nextId();
$i=0;
    $tmp=$_POST['av_'.$i];
    while(!empty($tmp))
    {
        $request='insert into char2advantage VALUES('.$lastid.','.$tmp.','.$_POST['av_val_'.$i].');';
      //  $dsql->sendRequest($request);

        $i++;
            $tmp=$_POST['av_'.$i];
    }



  //  print_r($_POST);
  $i=0;
   
    $tmp=$_POST['pw_val_'.$i];
    while(!empty($tmp))
    {
           $request='insert into char2power VALUES('.$lastid.','.$_POST['pw_'.$i].','.$_POST['pw_val_'.$i].');';
           $dsql->sendRequest($request);
           echo $request;
           $i++;
           $tmp=$_POST['pw_val_'.$i];
     }










//header('location: /');


}
else if($_POST['save']=='Mettre à jour')
{
    //echo 'save';
    //print_r($_POST);
     require_once('include/connection/driversql.inc.php');
    $dsql= new driversql();
    $dsql->init();

    $sql='describe characters;';
    $dsql->sendRequest($sql);
    $insertStr='';
    $i=0;
    $field='';
    while($dsql->res_tab_assoc($line))
    {
        if($line['Field']!='id')
        {    
            if($i!=0)
            {
                $insertStr.=',';
            }
    
            
//            echo $line['Field'].'='.$_POST[$line['Field']].'='.$line['Type'].'<br/>';   
            if(strpos($line['Type'],'int')===false)
                $insertStr="\"".trim($_POST[$line['Field']])."\"";
            else
                $insertStr=(!empty($_POST[$line['Field']]))?$_POST[$line['Field']]:0;
                
            $field.=$line['Field'].'='.$insertStr.',';

        
            $i++;
        }

    }
    $field=substr($field,0,-1);
    $sql='update characters  SET '.$field.' where id='.$_POST['id'];
    //echo $sql.'<br/><br/>';
  $dsql->sendRequest($sql);


  $lastid=$_POST['id'];
$i=0;
    $tmp=$_POST['av_'.$i];
    $dsql->sendRequest('delete from char2advantage where id_char='.$_POST['id']);
    while(!empty($tmp))
    {
        $request='insert into char2advantage VALUES('.$lastid.','.$tmp.','.$_POST['av_val_'.$i].');';
        $dsql->sendRequest($request);

        $i++;
            $tmp=$_POST['av_'.$i];
    }



    //print_r($_POST);
    $i=0;

    $sql ='SELECT * from wod_game where id = '.$_POST['type_being'];
    $dsql->sendRequest($sql);
    $dsql->res_tab_assoc($line);
    if(empty($line['powertable']))
        return '';
        
     $dsql->sendRequest('delete from char2power where id_char='.$_POST['id']);
     if($line['powerCompulsory']==1)
     {
        $i=1;
        $tmp=$_POST['pw_val_'.$i];
        do
        {
            $request='insert into char2power VALUES('.$lastid.','.$_POST['pw_'.$i].','.$_POST['pw_val_'.$i].');';
            $dsql->sendRequest($request);
            $i++;
        }while($i<6);
        
    }
    else
    {
   
        $tmp=$_POST['pw_val_'.$i];
        
        while(!empty($tmp))
        {
               $request='insert into char2power VALUES('.$lastid.','.$_POST['pw_'.$i].','.$_POST['pw_val_'.$i].');';
               $dsql->sendRequest($request);
               //echo $request;
               $i++;
               $tmp=$_POST['pw_val_'.$i];
        }
    }
 header('location: /');
}



?>
