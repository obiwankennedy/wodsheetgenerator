<?php

$ForbiddenFields=array('id','counthit');

if(!empty($currentPath[1]))
{

    require_once('include/connection/driversql.inc.php');
    $dsql= new driversql();
    $dsql->init();
    require_once('data/character.php');
    $char=array();
    $idchar=$currentPath[1];
    $dsql->sendRequest('update characters set counthit=counthit+1 where id='.$currentPath[1]);
    $dsql->sendRequest('select * from characters where id ='.$currentPath[1]);
    $dsql->res_tab_assoc($line);
    $dsql->sendRequest('select * from char2power where id_char ='.$currentPath[1]);
    $i=0;
    while($dsql->res_tab_assoc($pow))
    {
        $line['pw_'.$i]=$pow['id_pow'];
        $line['pw_val_'.$i]=$pow['value'];
        $i++;
    }
    $dsql->sendRequest('select * from char2advantage where id_char ='.$currentPath[1]);
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
        case 5://changeling
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
       
        if(!isInside($line['Field'],$ForbiddenFields))
        {    

            if($i!=0)
            {
                $insertStr.=',';
            }
    
            $field.=$line['Field'].',';
//            echo $line['Field'].'='.$_POST[$line['Field']].'='.$line['Type'].'<br/>';   
            if(strpos($line['Type'],'int')===false)
            {
                $insertStr.="\"".trim($_POST[$line['Field']])."\"";
        }
                   else if($line['Field']=='latest_modification')
           {
               $insertStr.='now()';
            }
            else
            {
                $insertStr.=(!empty($_POST[$line['Field']]))?$_POST[$line['Field']]:0;
            }


        
            $i++;
        }

    }
   // $field.='latest_modification,';
   // $insertStr.=',now()';
    $field=substr($field,0,-1);
    $sql='INSERT INTO characters ('.$field.')VALUES('.$insertStr.')';
  //  echo $sql.'<br/><br/>';
  $dsql->sendRequest($sql);


  $lastid=$dsql->nextId();
$i=0;
    $tmp=$_POST['av_'.$i];
    while(!empty($tmp))
    {
        $request='insert into char2advantage VALUES('.$lastid.','.$tmp.','.$_POST['av_val_'.$i].');';
        $dsql->sendRequest($request);

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
           $i++;
           $tmp=$_POST['pw_val_'.$i];
     }


        $tab = explode(',',$_POST['tag']);
        $lastTagId=-1;
        if(!empty($_POST['tag']))
        {
        foreach($tab as $value)
        {
            
            $dsql->sendRequest('select id from tags where name="'.$value.'"');
            if($dsql->getCount()==0)
            {
                $dsql->sendRequest2('insert into tags VALUES(DEFAULT,"'.$value.'")');
                $lastTagId=$dsql->nextId();
            }
            else
            {
                $dsql->res_tab_assoc($tag);
                $lastTagId=$tag['id'];
            }
        
            $dsql->sendRequest2('insert into tags2char VALUES('.$lastTagId.','.$lastid.')');
            
            
    }
    }







//header('location: /');


}
else if($_POST['save']=='Mettre à jour')
{
    //echo 'save';

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
        
        if(!isInside($line['Field'],$ForbiddenFields))
        {    
            echo $line['Field'];
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
    $field.='latest_modification=now(),';
    $field=substr($field,0,-1);
    $sql='update characters  SET '.$field.' where id='.$_POST['id'];
    //echo $sql.'<br/><br/>';
  $dsql->sendRequest($sql);


  $lastid=$_POST['id'];
$i=0;
    $tmp=$_POST['av_'.$i];

    $dsql->sendRequest('delete from char2advantage where id_char='.$_POST['id']);
   /* while(!empty($tmp))
    {
        $request='insert into char2advantage VALUES('.$lastid.','.$tmp.','.$_POST['av_val_'.$i].');';
        $dsql->sendRequest($request);

        $i++;
            $tmp=$_POST['av_'.$i];
    }*/
        $sql ='SELECT * from wod_game where id = '.$_POST['type_being'];
    $dsql->sendRequest($sql);
    $dsql->res_tab_assoc($line);
     if($line['powerCompulsory']==1)
     {
        $i=1;
        $tmp=$_POST['pw_val_'.$i];
        do
        {
            if(!empty($_POST['pw_val_'.$i]))
            {
                $request='insert into char2power VALUES('.$lastid.','.$_POST['pw_'.$i].','.$_POST['pw_val_'.$i].');';
                $dsql->sendRequest($request);
            }
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


    
    $i=0;

    $sql ='SELECT * from wod_game where id = '.$_POST['type_being'];
    $dsql->sendRequest($sql);
    $dsql->res_tab_assoc($line);
    if(!empty($line['powertable']))
    {
        
     $dsql->sendRequest('delete from char2power where id_char='.$_POST['id']);
     if($line['powerCompulsory']==1)
     {
        $i=1;
        $tmp=$_POST['pw_val_'.$i];
        do
        {
            if(!empty($_POST['pw_val_'.$i]))
            {
                $request='insert into char2power VALUES('.$lastid.','.$_POST['pw_'.$i].','.$_POST['pw_val_'.$i].');';
                $dsql->sendRequest($request);
            }
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
}

    
        $dsql->sendRequest('delete from tags2char where id_char='.$_POST['id']);
        $tab = explode(',',$_POST['tag']);
        $lastTagId=-1;
        foreach($tab as $value)
        {
            
            $dsql->sendRequest('select id from tags where name="'.$value.'"');
            if($dsql->getCount()==0)
            {
                $dsql->sendRequest('insert into tags VALUES(DEFAULT,"'.$value.'")');
                $lastTagId=$dsql->nextId();
            }
            else
            {
                $dsql->res_tab_assoc($tag);
                $lastTagId=$tag['id'];
            }
        
            $dsql->sendRequest('insert into tags2char VALUES('.$lastTagId.','.$lastid.')');
            
            
        }
 header('location: /');
}



?>
