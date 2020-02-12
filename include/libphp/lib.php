<?php
define('MJ',"maitre de jeu");
define('PJ',"joueur");
define('ADMIN',"admin");
define('HOME',"http://nwod.rolisteam.org");

function isInside($str,$array)
{
    foreach($array as $value)
    {
        if($value===$str)
        {
            return true;
        }
    }
return false;
}
function currentUserIsRegisted()
{
    if(!empty($_SESSION['user']['id']))
    {
        return True; 
    }
    else
    {
        return False;
    }
}

function redirect($time,$dest)
{
    //<body onLoad="redirection_temp()"> 
        $result = '<script type="text/javascript">
delay = "'.$time.'" ;
url = "'.$dest.'" ;
function redirection_temp() { self.setTimeout("self.location.href = url;",delay) ; }
</script>';

return $result;
    
}
function displayListCharacter($dsql,$hit,$bTags)
{
	$string='<table class="listCharact">';
    
    global $lang;

	while($dsql->res_tab_assoc($character))
	{
        
        $name=$character['ig_name'];
        if(empty($name))
        {
            $name='inconnu';
        }
		$string.='<tr>
				<td><img class="logo" src="'.beingtype2icon($character['type_being']).'" alt="logo" /></td><td class="large">'.$name.'</td>';
                if($bTags)
                {
                    $res = $dsql->sendRequest2('select * from tags inner join tags2char on tags.id = tags2char.id_tag where tags2char.id_char='.$character['id']);
     
                    $tagsLine ='';
                    while($dsql->res_tab_assoc2($tags,$res))
                    {
                        $tagsLine .= $tags['name'].', ' ;
                }
                //remove comma at the end of line
                    $tagsLine=substr($tagsLine,0,-2);
                    $string.='<td><span class="smalltext">'.$tagsLine.'</span></td> ';
                }
                //bbc and edit
				$string.='
                <td><a href="'.$lang.'/pdf/'.$character['id'].'"><img class="logo" alt="logo" src="/include/resources/icon/pdf-icon.png"/></a></td>
                <td class="smalltext">[<a href="/perso/'.$character['id'].'">bbc</a>] </td>
                <td class="smalltext">[<a href="/html/'.$character['id'].'">HTML</a>] </td>';
                if(currentUserIsRegisted())
                {
                    $string.='<td class="smalltext"><a href="/new/'.$character['id'].'"><img class="logo" alt="edit" src="/include/resources/icon/editIcon.gif"/></a></td>';
                }
                
                if($hit)
                {
                    $string.='<td class="smalltext">['.$character['counthit'].'&nbsp;'.tr('_Hits_').']</td>';
                }
                
			$string.='</tr>';

}

   /* $string.='<tr><td>'.tr('_type_being').'</td><td>'.tr('_name_').'</td>';
    if($bTags)
    {
        $string.='<td>'.tr('_Tags_').'</td>';
    }
    $string.='<td>'.tr('_pdf_').'</td><td>'.tr('_BBCode_').'</td><td>'.tr('_Edit_').'</td>';
    if($hit)
    {
        $string.='<td>'.tr('_Hits_').'</td>';
    }
    $string.='</tr>';*/
    
    
	$string.='</table>';
return $string;


}    

function beingtype2icon($id)
{

	switch($id)
	{
		case 1://humain
		return '/include/resources/logo/humain.png';
		case 2://vampire
		return '/include/resources/logo/vampire.png';
		case 3://mage
		return '/include/resources/logo/mage.png';
		case 4://loup garou
		return '/include/resources/logo/loupgarou.png';
		case 5://loup garou
		return '/include/resources/logo/changeling.png';
	}
}

function digitToRound($i)
{
    $full='●';	
   $empty='○';
   if(empty($i))
       $i=0;
    $return = "";
    if((is_numeric($i))&&($i<10))
    {  
        for($j=0;$j<$i;$j++)
            $return.=$full;


        if($i<5)
        {  
            for($k =$i;$k<5;$k++)
                $return.=$empty;
        }

        return $return;
    }
    else
    return $i;
}

function averageColor($color)
{
	$bgRed =221;
	$bgGreen =221;
	$bgBlue =221;
	
	
	$colorRed =	hexdec(substr($color,0,2));
	$colorGreen =	hexdec(substr($color,2,2));
	$colorBlue =	hexdec(substr($color,4));
	//echo $colorRed," ",$colorGreen," ",$colorBlue,"<br/>";
	
	
	$return = dechex(($bgRed*4 + $colorRed)/5);

	$return .=dechex(($bgGreen*4 + $colorGreen)/5);
	$return .=dechex(($bgBlue*4 + $colorBlue)/5);
	
	return $return;
	
}
function displayAtoutHtmlCode($id)
{
    global $dsql;

    $sql = 'Select * from wod_advantage inner join char2advantage on wod_advantage.id = char2advantage.id_advantage where char2advantage.id_char='.$id;
    $dsql->sendRequest($sql);
    $string='';
    while($dsql->res_tab_assoc($line))
    {
          $string.='<tr><td>'.$line['name'].'</td>
<td>'.digitToRound($line['value']).'<td></tr>';  
    }

return $string;
}
function displayAtoutBBCode($id)
{
    global $dsql;

    $sql = 'Select * from wod_advantage inner join char2advantage on wod_advantage.id = char2advantage.id_advantage where char2advantage.id_char='.$id;
    $dsql->sendRequest($sql);
    $string='';
    while($dsql->res_tab_assoc($line))
    {
          $string.='[tr][td]'.$line['name'].'[/td]
[td][size=15]'.digitToRound($line['value']).'[/size][/td][/tr]';  
    }

return $string;
}
function is_lang($lang)
{
    global $dsql;
    $sql='describe i18n';
    $forbidden_key=array('id','wordkey');
    $dsql->sendRequest($sql);
    $found=false;
    while($dsql->res_tab_assoc($line))
    {
         if((!isInside($line['Field'],$forbidden_key))&&($lang==$line['Field']))
            {
                $found=true;
            }
            
    }
    
    return $found;
}
/*
$fieldTrad_gen = array(type_being '=>' ',
ig_name'=>' ', 
ig_vertue'=>' ',
field_top'=>' ',
ig_age'=>' ',
ig_vice'=>' ',
field_middle'=>' ',
ig_player'=>' ',
ig_concept'=>' ',
ig_biography'=>' ',
field_bottom'=>' ',
at_int'=>' ',
at_force '=>' ',
at_pre'=>' ', 
at_ast'=>' ',
at_dex'=>' ', 
at_mani'=>' ',
at_res'=>' ', 
at_vig'=>' ',
at_cal'=>' ',
tam_0'=>' ', 
spe_tam_0'=>' ',
tam_1 '=>' ',
spe_tam_1'=>' ',
tam_2 '=>' ',
spe_tam_2'=>' ',
tam_3 '=>' ',
spe_tam_3'=>' ',
tam_4 '=>' ',
spe_tam_4'=>' ',
tam_5 '=>' ',
spe_tam_5'=>' ',
tam_6 '=>' ', 
spe_tam_6'=>' ',
tam_7 '=>' ', 
spe_tam_7'=>' ',
tap_0 '=>' ',
spe_tap_0'=>' ',
tap_1 '=>' ',
spe_tap_1'=>' ',
tap_2 '=>' ',
spe_tap_2'=>' ', 
tap_3 '=>' ',
spe_tap_3'=>' ',
tap_4 '=>' ',
spe_tap_4'=>' ',
tap_5 '=>' ',
spe_tap_5'=>' ',
tap_6 '=>' ',
spe_tap_6'=>' ',
tap_7 '=>' ',
spe_tap_7'=>' ',
tas_0 '=>' ',
spe_tas_0'=>' ',
tas_1 '=>' ',
spe_tas_1'=>' ',
tas_2 '=>' ',
spe_tas_2'=>' ',
tas_3 '=>' ',
spe_tas_3'=>' ',
tas_4 '=>' ',
spe_tas_4'=>' ',
tas_5 '=>' ',
spe_tas_5'=>' ',
tas_6 '=>' ', 
spe_tas_6'=>' ',
tas_7 '=>' ',
spe_tas_7'=>' ',
handicap'=>' ',
hand_taille '=>' ',
hand_vitesse '=>' ',
hand_init '=>' ',
hand_def '=>' ',
hand_arm '=>' ',
mhealth '=>' ',
chealth '=>' ',
mvolonte '=>' ',
cvolonte '=>' ',
menergy '=>' ',
mmoral '=>' ',
mindex '=>' ',
background '=>' ',
latest_modification '=>' ',
counthit '=>' ');

*/
$fieldTrad = array('concept'=>'concept',
'vice'=>'vice','vertu'=>'vertu',
'clan'=>'clan','ligue'=>'ligue',
'coterie'=>'coterie',
'intelligence'=>'intelligence',
'astuce'=>'astuce',
'resolution'=>'résolution','force'=>'force','dexterity'=>'dexterité','vigueur'=>'vigueur',
'presence'=>'présence',
'manipulation'=>'manipulation',
'calme'=>'calme',
'artisanat'=>'artisanat',
'erudition'=>'érudition',
'strategie'=>'strategie',
'investigation'=>'investigation',
'medecine'=>'medecine',
'occulte'=>'occulte',
'politique'=>'politique',
'science'=>'science','arme_blanche'=>'arme_blanche','arme_feu'=>'arme_feu','bagarre'=>'bagarre','conduite'=>'conduite','furtivite'=>'furtivité','larcin'=>'larcin','sport'=>'sport','survie'=>'survie','animaux'=>'animaux','empathie'=>'empathie','expression'=>'expression','intimidation'=>'intimidation','persuasion'=>'persuasion','relationnel'=>'relationnel','sagesse_de_la_rue'=>'sagesse_de_la_rue','subterfuge'=>'subterfuge','health'=>'santé','current_health'=>'santé actuelle','volonte'=>'volonté','current_volonte'=>'volonté actuelle','vitae'=>'vitae','current_vitae'=>'vitae actuelle','blood_power'=>'puissance du sang','humanity'=>'humanité','height'=>'Taille','defense'=>'défense','initiative'=>'initiative','armure'=>'armure','speed'=>'vitesse','creation_date'=>'date de création','background'=>'Histoire','birthday'=>'Date de naissance','death'=>'Mort','father'=>'Sir','currentdate'=>'date actuelle','appearage'=>'age apparent','realage'=>'age réel','weight'=>'poids','type'=>'type','eye'=>'yeux','skin'=>'peau','haircolor'=>'couleur des cheveux','haircut'=>'coiffure','howhairly'=>'pilosité','odeur'=>'odeur','voice'=>'voix','style'=>'style','fashion_style'=>'look vestimentaire','particular_sign'=>'signes particuliers','scars'=>'cicatrice','allergies'=>'allergies','nickname'=>'Surnom','best_friend'=>'Meilleur ami','worst_ennemy'=>'Pire Ennemi','city'=>'ville','refuge'=>'refuge','presentation'=>'présentation');



$attributs=array("intelligence","astuce","resolution","force","dexterity","vigueur","presence","manipulation","calme");

$competences=array('artisanat'
 ,'erudition'
 ,'strategie'
 ,'investigation'
 ,'medecine'
 ,'occulte'
 ,'politique'
 ,'science'
 ,'arme_blanche'
 ,'arme_feu'
 ,'bagarre'
 ,'conduite'
 ,'furtivite'
 ,'larcin'
 ,'sport'
 ,'survie'
 ,'animaux'
 ,'empathie'
 ,'expression'
 ,'intimidation'
 ,'persuasion'
 ,'relationnel'
 ,'sagesse_de_la_rue'
 ,'subterfuge');
 
 //Instance of sql driver for the whole site.
if(file_exists( 'include/connection/driversql.inc.php'))
{
	require_once('include/connection/driversql.inc.php');
}
else
	require_once('../include/connection/driversql.inc.php');
	
$dsql = new driversql();
$dsql->init();


function getLang($lang)
{   
    if(empty($lang))
    {
        $lang='en';
    }
    global $dsql;
    global $currentLang;
    $sql='select wordkey,'.$lang.' from i18n';
    $dsql->sendRequest($sql);
    
    $status=false;
    while($dsql->res_tab_assoc($line))
    {
        $currentLang[$line['wordkey']]=$line[$lang];
        $status=true;
    }
    return $status;
}

function tr($key)
{
   global $dsql; 
   global $currentLang;
    $result= $currentLang[addslashes($key)];
    if(empty($currentLang[addslashes($key)]))
    {
        $sql='select * from i18n where wordkey="'.addslashes($key).'"';
        $res =  $dsql->sendRequest2($sql);
        $result= $key;

        if($dsql->getCount2($res)==0)
        {
            $res = $dsql->sendRequest2("Insert Into i18n (id,wordkey)values(default,'".addslashes($key)."');");
        }        
    }
       
    return $result;

}

?>
