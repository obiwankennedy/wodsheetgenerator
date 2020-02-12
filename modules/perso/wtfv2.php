<?php
$fieldTrad_werewolf = array('ig_concept'=>'concept',
'ig_vice'=>'vice',
'ig_name'=>'nom',
'ig_vertue'=>'vertu',
'field_top'=>'Auspice',
'field_middle'=>'Tribu',
'field_bottom'=>'loge',
'at_int'=>'intelligence',
'at_ast'=>'astuce',
'at_res'=>'résolution',
'at_force'=>'force',
'at_dex'=>'dextérité',
'at_vig'=>'vigueur',
'at_pre'=>'présence',
'at_mani'=>'manipulation',
'at_cal'=>'calme',
'tam_0'=>'artisanat',
'tam_1'=>'érudition',
'tam_2'=>'informatique',
'tam_3'=>'investigation',
'tam_4'=>'médecine',
'tam_5'=>'occulte',
'tam_6'=>'politique',
'tam_7'=>'science',
'tap_0'=>'arme blanche',
'tap_1'=>'Arme à feu',
'tap_3'=>'bagarre',
'tap_4'=>'conduite',
'tap_5'=>'furtivité',
'tap_6'=>'larcin',
'tap_2'=>'sport',
'tap_7'=>'survie',
'tas_0'=>'animaux',
'tas_1'=>'empathie',
'tas_2'=>'expression',
'tas_3'=>'intimidation',
'tas_4'=>'persuasion',
'tas_5'=>'relationnel',
'tas_6'=>'sagesse de la rue',
'tas_7'=>'subterfuge',
'mhealth'=>'santé',
'chealth'=>'santé actuelle',
'mvolonte'=>'volonté',
'cvolonte'=>'volonté actuelle',
'menergy'=>'Essence',
'current_vitae'=>'Essence actuelle',
'mindex'=>'Instinct Primal',
'mmoral'=>'Harmonie',
'height'=>'Taille',
'defense'=>'défense',
'initiative'=>'initiative',
'armure'=>'armure',
'speed'=>'vitesse',
'creation_date'=>'date de création',
'background'=>'Histoire',
'birthday'=>'Date de naissance',
'death'=>'Mort',
'father'=>'père',
'currentdate'=>'date actuelle',
'appearage'=>'âge apparent',
'ig_age'=>'âge',
'weight'=>'poids',
'type'=>'type',
'eye'=>'yeux',
'skin'=>'peau',
'haircolor'=>'couleur des cheveux',
'haircut'=>'coiffure',
'howhairly'=>'pilosité',
'odeur'=>'odeur',
'voice'=>'voix',
'style'=>'style',
'fashion_style'=>'style vestimentaire',
'particular_sign'=>'signe particulier',
'scars'=>'cicatrice',
'allergies'=>'allergies',
'nickname'=>'surnom',
'best_friend'=>'meilleur ami',
'worst_ennemy'=>'pire ennemi',
'city'=>'ville',
'refuge'=>'refuge',
'pw'=>'Listes de Don',
'presentation'=>'présentation');


function displayVice($i)
{
  return $i;
        global $dsql;
        $sql ='SELECT * from wod_vice where id='.$i;
        $dsql->sendRequest($sql);

        $dsql->res_tab_assoc($line);
        return $line['name'];

}

function displayVertue($i)
{
  return $i;
        global $dsql;
        $sql ='SELECT * from wod_vertue where id='.$i;
        $dsql->sendRequest($sql);
        $dsql->res_tab_assoc($line);
        return $line['name'];
}
function listTribu($i)
{
     global $dsql;
    $dsql->sendRequest('SELECT * from lg_tribu where id='.$i);
    $dsql->res_tab_assoc($line);
    return $line['name'];
}
function listAuspice($i)
{
    if(Empty($i))
    return;

     global $dsql;
    $dsql->sendRequest('SELECT * from lg_auspice where id='.$i);
    $dsql->res_tab_assoc($line);
    return $line['name'];
}

$dsql->sendRequest('SELECT * FROM characters where id='.$currentPath[1]);

$dsql->res_tab_assoc($line);


function addColor($value)
{
    return '[color=#FF9900] '.$value.'[/color]';
}

function displayCompCell($line, $i)
{
    $keyComp='ta';
    $key='spe_ta';
    if(($i+1)%3==0)
    {
      $key.='s';
      $keyComp.='s';
    }
    else if(($i+1)%3==2)
    {
      $key.='p';
      $keyComp.='p';
    }
    else if(($i+1)%3==1)
    {
      $key.='m';
      $keyComp.='m';
    }
    $key.='_';
    $keyComp.='_';
    $key.=(int)($i/3);
    $keyComp.=(int)($i/3);



    $result = $fieldTrad_werewolf[$keyComp].':'.$line[$keyComp];


    if(!empty($line[$key]))
    {
        $result .= '( '.$line[$key].' )';
    }
    return $result;


}




$page.='


<h3>[b]Info générales[/b]</h3>
[b]Nom[/b]:'.addColor(($line['ig_name'])).'<br/>
[b]Sang[/b]:'.addColor(displayVertue($line['ig_vertue'])).'<br/>
[b]Auspice[/b]:'.addColor(listAuspice($line['field_top'])).'<br/>
[b]âge[/b]:'.addColor($line['ig_age']).'<br/>
[b]Os[/b]:'.addColor(displayVice($line['ig_vice'])).'<br/>
[b]Tribu[/b]:'.addColor(listTribu($line['field_middle'])).'<br/>
[b]concept[/b]:'.addColor(($line['ig_concept'])).'<br/>
[b]loge[/b]:'.addColor(($line['field_bottom'])).'<br/>





<h3>[b]Attributs[/b]</h3>
[table cellspacing="1"]

[tr]
[td][b]intelligence[/b]:[color=#ff9900]'.$line['at_int'].'[/color][/td]
[td][b]force[/b]:[color=#ff9900] '.$line['at_force'].'[/color][/td]
[td][b]présence[/b]:[color=#ff9900] '.$line['at_pre'].'[/color][/td]
[/tr]<br/>

[tr]
[td][b]astuce[/b]:[color=#ff9900] '.$line['at_ast'].'[/color][/td]
[td][b]dextérité[/b]:[color=#ff9900] '.$line['at_dex'].'[/color][/td]
[td][b]manipulation[/b]:[color=#ff9900] '.$line['at_mani'].'[/color][/td]
[/tr]<br/>

[tr]
[td][b]résolution[/b]:[color=#ff9900] '.$line['at_res'].'[/color][/td]
[td][b]vigueur[/b]:[color=#ff9900] '.$line['at_vig'].'[/color][/td]
[td][b]calme[/b]:[color=#ff9900] '.$line['at_cal'].'[/color][/td]
[/tr]<br/>
[/table]







<h3>[b]Compétences[/b]</h3>
[table cellspacing="1"]
[tr]
[td]Compétences Mentales[/td]
[td]Compétences Physiques[/td]
[td]Compétences Sociales[/td]
[/tr]<br/>

[tr]
[td][b]artisanat[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]arme blanche[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]animaux[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[/tr]<br/>

[tr]
[td][b]érudition[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]Arme à feu[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]empathie[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[/tr]<br/>

[tr]
[td][b]informatique[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]sport[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]expression[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[/tr]<br/>

[tr]
[td][b]investigation[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]bagarre[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]intimidation[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[/tr]<br/>

[tr]
[td][b]médecine[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]conduite[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]persuasion[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[/tr]<br/>

[tr]
[td][b]occulte[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]furtivité[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]relationnel[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[/tr]<br/>

[tr]
[td][b]politique[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]larcin[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]sagesse de la rue[/b]:[color=#ff9900] '.displayCompCell($line, $i++).' [/color][/td]
[/tr]<br/>

[tr]
[td][b]science[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]survie[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[td][b]subterfuge[/b]:[color=#ff9900] '.displayCompCell($line, $i++).'[/color][/td]
[/tr]<br/>
[/table]<br/>





';
$page .= '
<h3>[b]Les 5 formes[/b]</h3>



[table cellspacing="1"]
[tr]<br/>
[td][b]HISHU[/b][/td]<br/>
[td][b]DALU[/b][/td]<br/>
[td][b]GAURU[/b][/td]<br/>
[td][b]URSHUL[/b][/td]<br/>
[td][b]URHANE[/b][/td]<br/>
[/tr]<br/>
[tr]<br/>
[td](Humain)[/td]<br/>
[td](Presque humain)[/td]<br/>
[td](Homme-Loup)[/td]<br/>
[td](Presque Loup)[/td]<br/>
[td](Loup)[/td]<br/>
[/tr]<br/>
[tr]<br/>
[td][b]Force [/b]:'.addColor(($line['at_force'])).'[/td]<br/>
[td][b]Force (+1)[/b]:'.addColor(($line['at_force']+1)).'[/td]<br/>
[td][b]Force (+3)[/b]:'.addColor(($line['at_force']+3)).'[/td]<br/>
[td][b]Force (+2)[/b]:'.addColor(($line['at_force']+2)).'[/td]<br/>
[td][b]Force [/b]:'.addColor(($line['at_force'])).'[/td]<br/>
[/tr]<br/>
[tr]<br/>
[td][b]Vigueur[/b]'.addColor(($line['at_vig'])).'[/td]<br/>
[td][b]Vigueur (+1)[/b]'.addColor(($line['at_vig']+1)).'[/td]<br/>
[td][b]Vigueur (+2)[/b]'.addColor(($line['at_vig']+2)).'[/td]<br/>
[td][b]Vigueur (+2)[/b]'.addColor(($line['at_vig']+2)).'[/td]<br/>
[td][b]Vigueur (+1)[/b]'.addColor(($line['at_vig']+1)).'[/td]<br/>
[/tr]<br/>
[tr]<br/>
[td] [/td]<br/>
[td][b]Manipulation (-1)[/b]'.addColor(($line['at_mani']-1)).'[/td]<br/>
[td] [/td]<br/>
[td][b]Manipulation (-1)[/b]'.addColor(($line['at_mani']-1)).'[/td]<br/>
[td][b]Manipulation (-1)[/b]'.addColor(($line['at_mani']-1)).'[/td] [/td]<br/>
[/tr]<br/>
[tr]<br/>
[td][b]Dexterite [/b]'.addColor(($line['at_dex'])).'[/td]<br/>
[td][b]Dexterite [/b]'.addColor(($line['at_dex'])).'[/td]<br/>
[td][b]Dexterite (+1)[/b]'.addColor(($line['at_dex']+1)).'[/td]<br/>
[td][b]Dexterite (+2)[/b]'.addColor(($line['at_dex']+2)).'[/td]<br/>
[td][b]Dexterite (+2)[/b]'.addColor(($line['at_dex']+2)).'[/td]<br/>
[/tr]<br/>
[tr]<br/>
[td][b]Taille[/b]:'.addColor(($line['hand_taille'])).'[/td]<br/>
[td][b]Taille (+1)[/b]:'.addColor(($line['hand_taille']+1)).'[/td]<br/>
[td][b]Taille (+2)[/b]:'.addColor(($line['hand_taille']+2)).'[/td]<br/>
[td][b]Taille (+1)[/b]:'.addColor(($line['hand_taille']+1)).'[/td]<br/>
[td][b]Taille (-1)[/b]:'.addColor(($line['hand_taille']-1)).'[/td]<br/>
[/tr]<br/>
[tr]<br/>
[td][b]Defense[/b]:'.addColor($line['hand_def']).'[/td]<br/>
[td][b]Defense[/b]:'.addColor($line['hand_def']).'[/td]<br/>
[td][b]Defense[/b]:'.addColor(min(($line['at_dex']+1),$line['at_ast'])).'[/td]<br/>
[td][b]Defense[/b]:'.addColor(min(($line['at_dex']+2),$line['at_ast'])).'[/td]<br/>
[td][b]Defense[/b]:'.addColor(min(($line['at_dex']+2),$line['at_ast'])).'[/td]<br/>
[/tr]<br/>
[tr]<br/>
[td][b]Initiative[/b]:'.addColor(($line['hand_init'])).'[/td]<br/>
[td][b]Initiative[/b]:'.addColor(($line['hand_init'])).'[/td]<br/>
[td][b]Initiative(+1)[/b]:'.addColor(($line['hand_init']+1)).'[/td]<br/>
[td][b]Initiative(+2)[/b]:'.addColor(($line['hand_init']+2)).'[/td]<br/>
[td][b]Initiative(+2)[/b]:'.addColor(($line['hand_init']+2)).'[/td]<br/>
[/tr]<br/>
[tr]<br/>
[td][b]Vitesse[/b]:'.addColor(($line['hand_vitesse'])).'[/td]<br/>
[td][b]Vitesse (+1)[/b]:'.addColor(($line['hand_vitesse']+1)).'[/td]<br/>
[td][b]Vitesse (+4)[/b]:'.addColor(($line['hand_vitesse']+4)).'[/td]<br/>
[td][b]Vitesse (+7)[/b]:'.addColor(($line['hand_vitesse']+7)).'[/td]<br/>
[td][b]Vitesse (+5)[/b]:'.addColor(($line['hand_vitesse']+5)).'[/td]<br/>
[/tr]<br/>
[tr]<br/>
[td][b]Armure[/b]:'.addColor($line['hand_arm']).'[/td]<br/>
[td][b]Armure[/b]:'.addColor($line['hand_arm']).'[/td]<br/>
[td][b]Armure[/b]:'.addColor($line['hand_arm']).' + 1/1[/td]<br/>
[td][b]Armure[/b]:'.addColor($line['hand_arm']).'[/td]<br/>
[td][b]Armure[/b]:'.addColor($line['hand_arm']).'[/td]<br/>
[/tr]<br/>
[tr]<br/>
[td][b]Perception[/b]:'.addColor(($line['at_ast']+$line['at_cal'])).'[/td]<br/>
[td][b]Perception (+2)[/b]:'.addColor(($line['at_ast']+$line['at_cal']+1)).'[/td]<br/>
[td][b]Perception (+3)[/b]:'.addColor(($line['at_ast']+$line['at_cal']+3)).'[/td]<br/>
[td][b]Perception (+3)[/b]:'.addColor(($line['at_ast']+$line['at_cal']+3)).'[/td]<br/>
[td][b]Perception (+4)[/b]:'.addColor(($line['at_ast']+$line['at_cal']+4)).'[/td]<br/>
[/tr][/table]<br/>
[color=white][u][b]Background[/b][/u] : [/color]<br/>
[quote]'.addColor($line['background']).'[/quote]';

     $page.='<h3>[b]Renommée:[/b]</h3>';
     $dsql->sendRequest('select * from char2power inner join lg_renomme on id_pow=lg_renomme.id where id_char='.$currentPath[1]);
     while($dsql->res_tab_assoc($line))
     {
         $page.=$line['name'].':'.addColor($line['value']).'<br/>';
     }






?>
