<?php

define('MAX_LIST',5);


function displayPopular($dsql)
{
    $dsql->sendRequest('select * from characters order by counthit DESC limit '.MAX_LIST);
    return displayListCharacter($dsql,true,true);
}
function displayLatest($dsql)
{

    $dsql->sendRequest('select * from characters order by latest_modification DESC limit '.MAX_LIST);
    return displayListCharacter($dsql,true,true);
}




$page.='<div><div class="popular"><h2 class="entry-title">'.tr('Most Popular').'</h2>'.displayPopular($dsql).'</div>';
$page.='<div class="popular"><h2 class="entry-title">'.tr('Latest').'</h2>'.displayLatest($dsql).'</div></div>';















?>
