<?php

$dsql->sendRequest('SELECT * FROM characters where id='.$currentPath[1]);

$dsql->res_tab_assoc($line);
//print_r($line);


switch($line['type_being'])
{
    case 4: //werewolf
        include_once('wtf.php');
        break;
    case 2://vampire
        include_once('vtr.php');
        break;
    case 1://human
        include_once('htv.php');
        break;
    default:
    break;
}


?>
