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


function addColorHtml($value)
{
    return '<span class="wtfvalue"> '.$value.'</span>';
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



    $result = $fieldTrad_werewolf[$keyComp].''.$line[$keyComp];


    if(!empty($line[$key]))
    {
        $result .= '( '.$line[$key].' )';
    }
    return $result;


}




$page.='


<h3>Info générales</h3>
<span class="valueLable">Nom</span>:</td><td>'.addColorHtml(($line['ig_name'])).'<br/>
<span class="valueLable">vertu</span>:</td><td>'.addColorHtml(displayVertue($line['ig_vertue'])).'<br/>
<span class="valueLable">Auspice</span></td><td>:'.addColorHtml(listAuspice($line['field_top'])).'<br/>
<span class="valueLable">âge</span></td><td>:'.addColorHtml($line['ig_age']).'<br/>
<span class="valueLable">vice</span>:</td><td>'.addColorHtml(displayVice($line['ig_vice'])).'<br/>
<span class="valueLable">Tribu</span>:</td><td>'.addColorHtml(listTribu($line['field_middle'])).'<br/>
<span class="valueLable">concept</span>:</td><td>'.addColorHtml(($line['ig_concept'])).'<br/>
<span class="valueLable">loge</span>:</td><td>'.addColorHtml(($line['field_bottom'])).'<br/>





<h3>Attributs</h3>
<table>

<tr>
<td><span class="valueLable">intelligence</span>:</td><td>'.addColorHtml($line['at_int']).'</td>
<td><span class="valueLable">force</span>:</td><td>'.addColorHtml($line['at_force']).'</td>
<td><span class="valueLable">présence</span>:</td><td>'.addColorHtml($line['at_pre']).'</td>
<tr>

<tr>
<td><span class="valueLable">astuce</span>:</td><td>'.addColorHtml($line['at_ast']).'</td>
<td><span class="valueLable">dextérité</span>:</td><td>'.addColorHtml($line['at_dex']).'</td>
<td><span class="valueLable">manipulation</span>:</td><td>'.addColorHtml($line['at_mani']).'</td>
<tr>

<tr>
<td><span class="valueLable">résolution</span>:</td><td>'.addColorHtml($line['at_res']).'</td>
<td><span class="valueLable">vigueur</span>:</td><td>'.addColorHtml($line['at_vig']).'</td>
<td><span class="valueLable">calme</span>:</td><td>'.addColorHtml($line['at_cal']).'</td>
<tr>
</table>







<h3><span class="valueLable">Compétences</span></h3>
<table>
<tr>
<td  colspan="2">Compétences Mentales</td>
<td colspan="2">Compétences Physiques</td>
<td colspan="2">Compétences Sociales</td>
</tr>

<tr>
<td><span class="valueLable">artisanat</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">arme blanche</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">animaux</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
</tr>

<tr>
<td><span class="valueLable">érudition</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">Arme à feu</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">empathie</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
</tr>

<tr>
<td><span class="valueLable">informatique</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">sport</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">expression</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<tr>

<tr>
<td><span class="valueLable">investigation</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">bagarre</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">intimidation</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
</tr>

<tr>
<td><span class="valueLable">médecine</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">conduite</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">persuasion</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
</tr>

<tr>
<td><span class="valueLable">occulte</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">furtivité</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">relationnel</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
</tr>

<tr>
<td><span class="valueLable">politique</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">larcin</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">sagesse de la rue</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
</tr>

<tr>
<td><span class="valueLable">science</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">survie</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
<td><span class="valueLable">subterfuge</span>:</td><td>'.addColorHtml(displayCompCell($line, $i++)).'</td>
</tr>
</table>





';
$page .= '
<h3><span class="valueLable">Les 5 formes</span></h3>



<table>
<tr>
<td colspan="2"><span class="valueLable">HISHU</span></td>
<td colspan="2"><span class="valueLable">DALU</span></td>
<td colspan="2"><span class="valueLable">GAURU</span></td>
<td colspan="2"><span class="valueLable">URSHUL</span></td>
<td colspan="2"><span class="valueLable">URHANE</span></td>
</tr>
<tr>
<td colspan="2">(Humain)</td>
<td colspan="2">(Presque humain)</td>
<td colspan="2">(Homme-Loup)</td>
<td colspan="2">(Presque Loup)</td>
<td colspan="2">(Loup)</td>
</tr>
<tr>
<td><span class="valueLable">Force </span>:</td><td>'.addColorHtml(($line['at_force'])).'</td>
<td><span class="valueLable">Force (+1)</span>:</td><td>'.addColorHtml(($line['at_force']+1)).'</td>
<td><span class="valueLable">Force (+3)</span>:</td><td>'.addColorHtml(($line['at_force']+3)).'</td>
<td><span class="valueLable">Force (+2)</span>:</td><td>'.addColorHtml(($line['at_force']+2)).'</td>
<td><span class="valueLable">Force </span>:</td><td>'.addColorHtml(($line['at_force'])).'</td>
</tr>
<tr>
<td><span class="valueLable">Vigueur</span>:</td><td>'.addColorHtml(($line['at_vig']+1)).'</td>
<td><span class="valueLable">Vigueur (+1)</span>:</td><td>'.addColorHtml(($line['at_vig']+1)).'</td>
<td><span class="valueLable">Vigueur (+2)</span>:</td><td>'.addColorHtml(($line['at_vig']+2)).'</td>
<td><span class="valueLable">Vigueur (+2)</span>:</td><td>'.addColorHtml(($line['at_vig']+2)).'</td>
<td><span class="valueLable">Vigueur (+1)</span>:</td><td>'.addColorHtml(($line['at_vig']+1)).'</td>
</tr>
<tr>
<td> :</td><td></td>
<td><span class="valueLable">Manipulation (-1)</span>:</td><td>'.addColorHtml(($line['at_mani']-1)).'</td>
<td> :</td><td></td>
<td><span class="valueLable">Manipulation (-3)</span>:</td><td>'.addColorHtml(($line['at_mani']-3)).'</td>
<td>:</td><td> </td>
</tr>
<tr>
<td><span class="valueLable">Dexterite </span>:</td><td>'.addColorHtml(($line['at_dex'])).'</td>
<td><span class="valueLable">Dexterite </span>:</td><td>'.addColorHtml(($line['at_dex'])).'</td>
<td><span class="valueLable">Dexterite (+1)</span>:</td><td>'.addColorHtml(($line['at_dex']+1)).'</td>
<td><span class="valueLable">Dexterite (+2)</span>:</td><td>'.addColorHtml(($line['at_dex']+2)).'</td>
<td><span class="valueLable">Dexterite (+2)</span>:</td><td>'.addColorHtml(($line['at_dex']+2)).'</td>
<tr>
</tr>
<td><span class="valueLable">Taille</span>:</td><td>'.addColorHtml(($line['hand_taille'])).'</td>
<td><span class="valueLable">Taille (+1)</span>:</td><td>'.addColorHtml(($line['hand_taille']+1)).'</td>
<td><span class="valueLable">Taille (+2)</span>:</td><td>'.addColorHtml(($line['hand_taille']+2)).'</td>
<td><span class="valueLable">Taille (+1)</span>:</td><td>'.addColorHtml(($line['hand_taille']+1)).'</td>
<td><span class="valueLable">Taille (-1)</span>:</td><td>'.addColorHtml(($line['hand_taille']-1)).'</td>
</tr>
<tr>
<td><span class="valueLable">Defense</span>:</td><td>'.addColorHtml($line['hand_def']).'</td>
<td><span class="valueLable">Defense</span>:</td><td>'.addColorHtml($line['hand_def']).'</td>
<td><span class="valueLable">Defense</span>:</td><td>'.addColorHtml(min(($line['at_dex']+1),$line['at_ast'])).'</td>
<td><span class="valueLable">Defense</span>:</td><td>'.addColorHtml(min(($line['at_dex']+2),$line['at_ast'])).'</td>
<td><span class="valueLable">Defense</span>:</td><td>'.addColorHtml(min(($line['at_dex']+2),$line['at_ast'])).'</td>
</tr>
<tr>
<td><span class="valueLable">Initiative</span>:</td><td>'.addColorHtml(($line['hand_init'])).'</td>
<td><span class="valueLable">Initiative</span>:</td><td>'.addColorHtml(($line['hand_init'])).'</td>
<td><span class="valueLable">Initiative(+1)</span>:</td><td>'.addColorHtml(($line['hand_init']+1)).'</td>
<td><span class="valueLable">Initiative(+2)</span>:</td><td>'.addColorHtml(($line['hand_init']+2)).'</td>
<td><span class="valueLable">Initiative(+2)</span>:</td><td>'.addColorHtml(($line['hand_init']+2)).'</td>
</tr>
<tr>
<td><span class="valueLable">Vitesse</span>:</td><td>'.addColorHtml(($line['hand_vitesse'])).'</td>
<td><span class="valueLable">Vitesse (+1)</span>:</td><td>'.addColorHtml(($line['hand_vitesse']+1)).'</td>
<td><span class="valueLable">Vitesse (+4)</span>:</td><td>'.addColorHtml(($line['hand_vitesse']+4)).'</td>
<td><span class="valueLable">Vitesse (+7)</span>:</td><td>'.addColorHtml(($line['hand_vitesse']+7)).'</td>
<td><span class="valueLable">Vitesse (+5)</span>:</td><td>'.addColorHtml(($line['hand_vitesse']+5)).'</td>
</tr>
<tr>
<td><span class="valueLable">Armure</span>:</td><td>'.addColorHtml($line['hand_arm']).'</td>
<td><span class="valueLable">Armure</span>:</td><td>'.addColorHtml($line['hand_arm']).'</td>
<td><span class="valueLable">Armure</span>:</td><td>'.addColorHtml($line['hand_arm']).' + 1/1</td>
<td><span class="valueLable">Armure</span>:</td><td>'.addColorHtml($line['hand_arm']).'</td>
<td><span class="valueLable">Armure</span>:</td><td>'.addColorHtml($line['hand_arm']).'</td>
</tr>
<tr>
<td><span class="valueLable">Perception</span>:</td><td>'.addColorHtml(($line['at_ast']+$line['at_cal'])).'</td>
<td><span class="valueLable">Perception (+2)</span>:</td><td>'.addColorHtml(($line['at_ast']+$line['at_cal']+1)).'</td>
<td><span class="valueLable">Perception (+3)</span>:</td><td>'.addColorHtml(($line['at_ast']+$line['at_cal']+3)).'</td>
<td><span class="valueLable">Perception (+3)</span>:</td><td>'.addColorHtml(($line['at_ast']+$line['at_cal']+3)).'</td>
<td><span class="valueLable">Perception (+4)</span>:</td><td>'.addColorHtml(($line['at_ast']+$line['at_cal']+4)).'</td>
</tr></table><br/>
<h3>Background</span></h3>
<p>'.addColorHtml($line['background']).'<p>';
       
     $page.='<h3>Renommée:</h3>';
     $dsql->sendRequest('select * from char2power inner join lg_renomme on id_pow=lg_renomme.id where id_char='.$currentPath[1]);
     while($dsql->res_tab_assoc($line))
     {
         $page.=$line['name'].':'.addColorHtml($line['value']).'<br/>';
     }






?>
