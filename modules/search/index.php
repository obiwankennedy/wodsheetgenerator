<?php

$title = 'The Character Finder';                               
$menu = substr($menu, 0,-6); 
$menu.='<h2 class="widget-title">'.tr('Filters').'</h2>';
$dsql->sendRequest('select * from wod_game');
$menu.='<form method="post" action="#">
<p><span>'.tr('Type de créature').':</span><select onchange="submit()" name="typebeing"><option value="">'.tr('all').'</option>';

while($dsql->res_tab_assoc($line))
{
    $selected='selected="selected"';
    if($_POST['typebeing']!=$line['id'])
         $selected='';
$menu.='<option value="'.$line['id'].'"  '.$selected.'>'.tr($line['name']).'</option>';
}
$menu.='</select></p></form>';

$menu.='<div>';
$menu.='<h2 class="widget-title">Tags</h2>';
$menu.='<ul>';
   $dsql->sendRequest('select * from tags');  
   while($dsql->res_tab_assoc($line))
{
$menu.='<li>'.tr($line['name']).'</li>';
  }
 $menu.= '</ul>';

$menu.='</div>';
$clauseWhere=False;
$where=' where '; 
if(!empty($_POST['typebeing']))
{
          $where.=' type_being = '.tr($_POST['typebeing']);
          $clauseWhere=True;
}






if($clauseWhere===False)
     $where='';

$page.='<div class="left_content"><h2 class="widget-title">'.tr('Resulting Selection').'</h2>';


$dsql->sendRequest('select * from characters '.$where);

$page.= displayListCharacter($dsql,true,true);
$page.='</div>';
?>
