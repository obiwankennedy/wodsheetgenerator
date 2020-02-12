<?php


//mail('renaud@rolisteam.org','Test GET',implode($_GET,','));

$dsql->sendRequest('Select * from tags');
//$page.='{';
$results=array();
while($dsql->res_tab_assoc($line))
{

    //$page.='"item":{ "id":"'.$line['id'].'","name":"'.$line['name'].'"},';
    $results[]=array('id'=>$line['id'],'key'=>$line['name'],'value'=>$line['name']);
    $page.='"tag":"'.$line['name'].'",';

}
$page=substr($page,0,-1);
$page.='}';

//$page='tag,test,test2,java,javascript,chocolat,animal';
//mail('renaud@rolisteam.org','Test Page',$page);
//echo $page;

echo json_encode($results);

















?>