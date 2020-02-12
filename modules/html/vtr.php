<?php


function displayDiscipline($id)
{
            global $dsql;
            $sql = 'Select * from vp_discipline inner join char2power on vp_discipline.id = char2power.id_pow where char2power.id_char='.$id;
            $dsql->sendRequest($sql);
            $string='';
            while($dsql->res_tab_assoc($line))
            {
                  $string.='<tr><td>'.$line['name'].'</td>
<td>'.digitToRound($line['value']).'</td></tr>';  
            }
        
        return $string;
}
function displayVice($i)
{
        global $dsql;
        $sql ='SELECT * from wod_vice where id='.$i;
        $dsql->sendRequest($sql);
        
        $dsql->res_tab_assoc($line);
        return $line['name'];
        
}

function displayVertue($i)
{
        global $dsql;
        $sql ='SELECT * from wod_vertue where id='.$i;
        $dsql->sendRequest($sql);
        $dsql->res_tab_assoc($line);
        return $line['name'];
}
function listLigue($i)
{
    global $dsql;
    if(!empty($i))
    {
     
        $dsql->sendRequest('SELECT * from vp_ligue where id='.$i);
        $dsql->res_tab_assoc($line);
        return $line['name'];
    }
    return "";
}
function listClan($i)
{
     global $dsql;
    $dsql->sendRequest('SELECT * from vp_clans where id='.$i);
    $dsql->res_tab_assoc($line);
    return $line['name'];
}

function displaySpecialite($i)
{
    global $line;
    $key='spe_ta';
    if(($i+1)%3==0)
    {
      $key.='s';
    }
    else if(($i+1)%3==2)
    {
      $key.='p';
    }
    else if(($i+1)%3==1)
    {
      $key.='m';
    }
    $key.='_';
    $key.=(int)($i/3);
    if(!empty($line[$key]))
    {
        return '( '.$line[$key].' )';
    }
    return "";

    
}

$dsql->sendRequest('SELECT * FROM characters where id='.$currentPath[1]);

$dsql->res_tab_assoc($line);
/*


Array ( [id] => 75 [type_being] => 4 [ig_name] => Eugène Chatel [ig_vertue] => 5 [field_top] => 5 [ig_age] => [ig_vice] => 3 [field_middle] => 4 [ig_player] => [ig_concept] => [ig_biography] => [field_bottom] => [at_int] => 2 [at_force] => 3 [at_pre] => 2 [at_ast] => 4 [at_dex] => 1 [at_mani] => 1 [at_res] => 2 [at_vig] => 3 [at_cal] => 3 [tam_0] => 1 [spe_tam_0] => [tam_1] => 0 [spe_tam_1] => [tam_2] => 1 [spe_tam_2] => [tam_3] => 2 [spe_tam_3] => [tam_4] => 2 [spe_tam_4] => [tam_5] => 3 [spe_tam_5] => esprit [tam_6] => 0 [spe_tam_6] => [tam_7] => 2 [spe_tam_7] => [tap_0] => 1 [spe_tap_0] => klaive [tap_1] => 0 [spe_tap_1] => [tap_2] => 0 [spe_tap_2] => [tap_3] => 1 [spe_tap_3] => Dalu [tap_4] => 0 [spe_tap_4] => [tap_5] => 1 [spe_tap_5] => [tap_6] => 0 [spe_tap_6] => [tap_7] => 1 [spe_tap_7] => [tas_0] => 1 [spe_tas_0] => [tas_1] => 0 [spe_tas_1] => [tas_2] => 0 [spe_tas_2] => [tas_3] => 2 [spe_tas_3] => [tas_4] => 2 [spe_tas_4] => [tas_5] => 0 [spe_tas_5] => [tas_6] => 0 [spe_tas_6] => [tas_7] => 0 [spe_tas_7] => [handicap] => [hand_taille] => 5 [hand_vitesse] => 9 [hand_init] => 4 [hand_def] => 1 [hand_arm] => 0 [mhealth] => 8 [chealth] => 0 [mvolonte] => 5 [cvolonte] => 0 [menergy] => 0 [mmoral] => 0 [mindex] => 0 [background] => ) 


*/
$id=$line['id'];
$i=0;
$page.='<span class="valuevtr">Nom, prénom, surnom</span> : '.$line['ig_name'].'<br/>

<span class="valuevtr">Clan</span> : '.listClan($line['field_top']).'<br/>

<span class="valuevtr">Lignée</span> : '.$line[''].'<br/>

<span class="valuevtr">Ligue</span> : '.listLigue($line['field_middle']).'<br/>

<span class="valuevtr">Age</span> : '.$line[''].'<br/>

Age apparent: '.$line['ig_age'].'<br/>
Age vampirique : '.$line['ig_age'].'<br/>

<span class="valuevtr">Puissance du Sang</span> : '.$line[''].'<br/>

<span class="valuevtr">Humanité</span> : '.$line['mmoral'].'<br/>

<span class="valuevtr">Santé</span> : '.$line['mhealth'].'<br/>

<span class="valuevtr">Vitesse</span> : '.$line['hand_vitesse'].'<br/>

<span class="valuevtr">Initiative</span> : '.$line['hand_init'].'<br/>

<span class="valuevtr">Défense</span> : '.$line['hand_def'].'<br/>

<span class="valuevtr">Volonté</span> : '.$line['mvolonte'].'<br/>

<span class="valuevtr">Vertu</span> : '.displayVertue($line['ig_vertue']).'<br/>

<span class="valuevtr">Vice</span> : '.displayVice($line['ig_vice']).'<br/>

<span class="valuevtr">Signes distinctifs</span> : '.$line[''].'<br/>

<span class="valuevtr">Atouts</span> : 

<table>
'.displayAtoutHtmlCode($id).'
</table>
<br/>
<h3>Attributs</h3>
<table><tr><td colspan="2" width="33%">MENTAL(4) </td>
<td colspan="2" width="33%">PHYSIQUE(5) </td>
<td colspan="2" width="33%">SOCIAL(3) </td>
</tr>
<tr><td>Intelligence </td>
<td>'.digitToRound($line['at_int']).' </td>
<td>Force </td>
<td>'.digitToRound($line['at_force']).' </td>
<td>Présence  </td>
<td>'.digitToRound($line['at_pre']).' </td>
</tr>
<tr><td>Astuce </td>
<td>'.digitToRound($line['at_ast']).' </td>
<td>Dextérité </td>
<td>'.digitToRound($line['at_dex']).' </td>
<td>Manipulation </td>
<td>'.digitToRound($line['at_mani']).' </td>
</tr><br/>
<tr><td>Résolution </td>
<td>'.digitToRound($line['at_res']).' </td>
<td>Vigueur </td>
<td>'.digitToRound($line['at_vig']).' </td>
<td>Calme </td>
<td>'.digitToRound($line['at_cal']).' </td>
</tr>
</table>

<h3>Capacités</h3>
<table><tr><td colspan="2" width="33%">Mental(7) (-3 si incompétent)
</td>
<td colspan="2" width="33%">Physique(11) (-1 si incompétent) </td>
<td colspan="2" width="33%">Social(4) (-1 si incompétent) </td>
</tr>
<tr><td>Artisanat '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tam_0']).'</td>
<td>Armes blanches '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tap_0']).'</td>
<td>Animaux '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tas_0']).'</td>
</tr>
<tr><td>Erudition '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tam_1']).'</td>
<td>Armes à feu '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tap_1']).'</td>
<td>Empathie '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tas_1']).'</td>
</tr>
<tr><td>Informatique'.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tam_2']).'</td>
<td>Sports '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tap_2']).'</td>
<td>Expression '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tas_2']).'</td>
</tr><br/>
<tr><td>Investigation '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tam_3']).'</td>
<td>Bagarre '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tap_3']).'</td>
<td>Intimidation '.displaySpecialite($i++).' </td>
<td>'.digitToRound($line['tas_3']).'</td>
</tr>
<tr><td>Médecine '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tam_4']).'</td>
<td>Conduite '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tap_4']).'</td>
<td>Persuasion'.displaySpecialite($i++).' </td>
<td>'.digitToRound($line['tas_4']).'</td>
</tr>

<tr><td>Occulte '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tam_5']).'</td>
<td>Discrétion '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tap_5']).'</td>
<td>Entregent '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tas_5']).'</td>
</tr>
<tr><td>Politique '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tam_6']).'</td>
<td>Larcin '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tap_6']).'</td>
<td>Expérience de la Rue '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tas_6']).'</td>
</tr>
<tr><td>Science '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tam_7']).'</td>
<td>Survie '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tap_7']).'</td>
<td>Subterfuge '.displaySpecialite($i++).'</td>
<td>'.digitToRound($line['tas_7']).'</td>
</tr>
</table>


<h3>Disciplines</h3>

<table>'.displayDiscipline($id);



$page.='</table>
<br/>
<span class="valuevtr">Background</span> : <br/>
<br/>
[quote]'.$line['background'].'[/quote]';









?>
