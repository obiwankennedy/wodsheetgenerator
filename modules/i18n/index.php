<?php
print_r($_POST);
print_r($currentPath);
if(!empty($currentPath[1]))
{
    require_once('i18n.php');
        
}
else
{
$title = 'Translation Page';  
$forbidden_key=array('id');

if(!empty($_POST['validate']))
{
    $sql='describe i18n';
$dsql->sendRequest($sql);
$fields=array();
    while($dsql->res_tab_assoc($line))
    {
            $fields[]=$line['Field'];
    }
    $i=0;
    
    while(!empty($_POST['id'][$i]))
    {
        $sql='update i18n set ';
        
        foreach($fields as $fieldname)
        {
            if(!isInside($fieldname,$forbidden_key))
            {
                
               $sql.= $fieldname.'="'.$_POST[$fieldname.'_'.$_POST['id'][$i]].'",';
               }
        }
        $sql=substr($sql,0,-1);
         $sql.=' where id='.$_POST['id'][$i];
         //$page .=$sql.'<br/>';
        $dsql->sendRequest($sql);
        $i++;
        
    }
    $page.='<p style="color:green">'.tr('translation successed').'</p>';
    $page.=redirect(5000,HOME.'/i18n');
    $body='onLoad="redirection_temp()"';
    
}
else
{
$sql='select * from i18n';
$dsql->sendRequest($sql);
$page .='<div><form method="post" action="#"><table>';

while($dsql->res_tab_assoc($line))
{
        $page.='<tr>';
        
        $id = $line['id'];
        
        foreach ($line as $key => $value)
        {
            if(!isInside($key,$forbidden_key))
            {
                $page .= '<td><input name="'.$key.'_'.$id.'" value="'.$value.'"/><td>
                ';
            }
            else
            {
                $page .= '<td><input type="hidden" name="id[]" value="'.$value.'"/><td>
                ';
            }
            
        }
    $page.='</tr>
    ';
}
$page .='</table><input type="submit" name="validate" value="translate"/></form></div>';
}
}
?>