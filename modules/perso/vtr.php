<?php
/*function digitToRound($text)
{
    return $text;
}*/

function displayDiscipline($id)
{
            global $dsql;
            $sql = 'Select * from vp_discipline inner join char2power on vp_discipline.id = char2power.id_pow where char2power.id_char='.$id;
            $dsql->sendRequest($sql);
            $string='';
            while($dsql->res_tab_assoc($line))
            {
                  $string.='[tr][td]'.$line['name'].'[/td]
[td][size=15]'.digitToRound($line['value']).'[/size][/td][/tr]';  
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
$page.='[color=white][u][b]Nom, prénom, surnom[/b][/u] : [/color]'.$line['ig_name'].'<br/>

[color=white][u][b]Clan[/b][/u] : [/color]'.listClan($line['field_top']).'<br/>

[color=white][u][b]Lignée[/b][/u] : [/color]'.$line[''].'<br/>

[color=white][u][b]Ligue[/b][/u] : [/color]'.listLigue($line['field_middle']).'<br/>

[color=white][u][b]Age[/b][/u] : [/color]'.$line[''].'<br/>

Age apparent: '.$line['ig_age'].'<br/>
Age vampirique : '.$line['ig_age'].'<br/>

[color=white][u][b]Puissance du Sang[/b][/u] : [/color]'.$line[''].'<br/>

[color=white][u][b]Humanité[/b][/u] : [/color]'.$line['mmoral'].'<br/>

[color=white][u][b]Santé[/b][/u] : [/color]'.$line['mhealth'].'<br/>

[color=white][u][b]Vitesse[/b][/u] : [/color]'.$line['hand_vitesse'].'<br/>

[color=white][u][b]Initiative[/b][/u] : [/color]'.$line['hand_init'].'<br/>

[color=white][u][b]Défense[/b][/u] : [/color]'.$line['hand_def'].'<br/>

[color=white][u][b]Volonté[/b][/u] : [/color]'.$line['mvolonte'].'<br/>

[color=white][u][b]Vertu[/b][/u] : [/color]'.displayVertue($line['ig_vertue']).'<br/>

[color=white][u][b]Vice[/b][/u] : [/color]'.displayVice($line['ig_vice']).'<br/>

[color=white][u][b]Signes distinctifs[/b][/u] : [/color]'.$line[''].'<br/>

[color=white][u][b]Atouts[/b][/u] : [/color]<br/>
<br/>
[table border="1"]
'.displayAtoutBBCode($id).'
[/table]
<br/>
[color=white][size=15][b]Attributs[/size] :[/b][/color] (5/4/3) (préciser ici l\'attribut de clan que vous choisissez^^)<br/>
[table border="1" width="500"][tr][td colspan="2" width="33%"]MENTAL(4) [/td]<br/>
[td colspan="2" width="33%"]PHYSIQUE(5) [/td]<br/>
[td colspan="2" width="33%"]SOCIAL(3) [/td]<br/>
[/tr]<br/>
[tr][td]Intelligence [/td]<br/>
[td][size=15]'.digitToRound($line['at_int']).'[/size] [/td]
[td]Force [/td]
[td][size=15]'.digitToRound($line['at_force']).'[/size] [/td]
[td]Présence  [/td]
[td][size=15]'.digitToRound($line['at_pre']).'[/size] [/td]
[/tr]<br/>
[tr][td]Astuce [/td]
[td][size=15]'.digitToRound($line['at_ast']).'[/size] [/td]<br/>
[td]Dextérité [/td]
[td][size=15]'.digitToRound($line['at_dex']).'[/size] [/td]
[td]Manipulation [/td]
[td][size=15]'.digitToRound($line['at_mani']).'[/size] [/td]
[/tr]<br/>
[tr][td]Résolution [/td]
[td][size=15]'.digitToRound($line['at_res']).'[/size] [/td]
[td]Vigueur [/td]
[td][size=15]'.digitToRound($line['at_vig']).'[/size] [/td]
[td]Calme [/td]
[td][size=15]'.digitToRound($line['at_cal']).'[/size] [/td]
[/tr]<br/>
[/table]
<br/>
[color=white][size=15][b]Capacités :[/b][/size][/color] (11/7/4)
[table border="1" width="500"][tr][td colspan="2" width="33%"]Mental(7) (-3 si incompétent)
[/td]
[td colspan="2" width="33%"]Physique(11) (-1 si incompétent) [/td]
[td colspan="2" width="33%"]Social(4) (-1 si incompétent) [/td]
[/tr]<br/>
[tr][td]Artisanat '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tam_0']).'[/size][/td]<br/>
[td]Armes blanches '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tap_0']).'[/size][/td]<br/>
[td]Animaux '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tas_0']).'[/size][/td]<br/>
[/tr]<br/>
[tr][td]Erudition '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tam_1']).'[/size][/td]<br/>
[td]Armes à feu '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tap_1']).'[/size][/td]<br/>
[td]Empathie '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tas_1']).'[/size][/td]<br/>
[/tr]<br/>
[tr][td]Informatique'.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tam_2']).'[/size][/td]<br/>
[td]Sports '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tap_2']).'[/size][/td]<br/>
[td]Expression '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tas_2']).'[/size][/td]<br/>
[/tr]<br/>
[tr][td]Investigation '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tam_3']).'[/size][/td]<br/>
[td]Bagarre '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tap_3']).'[/size][/td]<br/>
[td]Intimidation '.displaySpecialite($i++).' [/td]<br/>
[td][size=15]'.digitToRound($line['tas_3']).'[/size][/td]<br/>
[/tr]<br/>
[tr][td]Médecine '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tam_4']).'[/size][/td]<br/>
[td]Conduite '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tap_4']).'[/size][/td]<br/>
[td]Persuasion'.displaySpecialite($i++).' [/td]<br/>
[td][size=15]'.digitToRound($line['tas_4']).'[/size][/td]<br/>
[/tr]<br/>
[tr][td]Occulte '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tam_5']).'[/size][/td]<br/>
[td]Discrétion '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tap_5']).'[/size][/td]<br/>
[td]Entregent '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tas_5']).'[/size][/td]<br/>
[/tr]<br/>
[tr][td]Politique '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tam_6']).'[/size][/td]<br/>
[td]Larcin '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tap_6']).'[/size][/td]<br/>
[td]Expérience de la Rue '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tas_6']).'[/size][/td]<br/>
[/tr]<br/>
[tr][td]Science '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tam_7']).'[/size][/td]<br/>
[td]Survie '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tap_7']).'[/size][/td]<br/>
[td]Subterfuge '.displaySpecialite($i++).'[/td]<br/>
[td][size=15]'.digitToRound($line['tas_7']).'[/size][/td]<br/>
[/tr]<br/>
[/table]


[color=white][size=15][b]Disciplines :[/b][/size][/color]

[table border="1" width="400"]'.displayDiscipline($id);



$page.='[/table]
<br/>
[color=white][u][b]Background[/b][/u] : [/color]<br/>
<br/>
[quote]'.$line['background'].'[/quote]';









?>
