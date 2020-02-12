<?php
if(!currentUserIsRegisted())
{
    redirect(5000,HOME);
    $body='onLoad="redirection_temp()"';
    $page.='<span>'.tr('Forbidden Access').'</span>';
  
}
else
{
function displayGameType()
{
    global $dsql;
    $sql ='SELECT * from wod_game';
    $dsql->sendRequest($sql);
    $return='<select name="type_being" id="type_being" onchange="refreshContent();"><option></option>';
    while($dsql->res_tab_assoc($line))
    {
        if($_POST['type_being']==$line['id'])
            $selected='selected="selected"';
        $return.='<option value="'.$line['id'].'" '.$selected.'>'.tr($line['name']).'</option>';
        unset($selected);
    }
    $return.='</select>
';
    return $return;
}
function advantageChooser($i)
{
        global $dsql;
        $sql='SELECT wod_advantage.*,wod_game.name as game FROM wod_advantage join wod_game on wod_game.id=wod_advantage.id_game order by id_game,wod_advantage.name';
        $dsql->sendRequest($sql);
        $return='<td><select name="av_'.$i.'" id="av_'.$i.'" onchange="refreshContent();">
		<option></option>';
		//WTF - if id="ad_'.$i.'" is defined the sixth select will be hidden I don't know why. Maybe ajax librarie includes.
        $lastgroup='';
        while($dsql->res_tab_assoc($line))
        {
            if((empty($lastgroup))||($lastgroup!=$line['game']))
            {
                if($lastgroup!=$line['game'])
                    $return.='</optgroup>';
                $return.='<optgroup label="'.$line['game'].'">';
                $lastgroup=$line['game'];
            }

             if($_POST['av_'.$i]==$line['id'])
                      $selected='selected="selected"';
             $return.='
				<option value="'.$line['id'].'" '.$selected.'>'.tr($line['name']).'</option>';
             unset($selected);
        }
        $return.='</select></td><td><input class="mediumfield" name="av_val_'.$i.'" id="av_val_'.$i.'" value="'.$_POST['av_val_'.$i].'"/></td>
';
        return $return;

    
}          
function displayGamePower()
{
    global $dsql; 
    $sql ='SELECT * from wod_game where id = '.$_POST['type_being'];
    $dsql->sendRequest($sql);
    $dsql->res_tab_assoc($line);
    if(empty($line['powertable']))
        return '';

        $return='<h3>'.tr($line['namepower']).'</h3><table class="field">';
    if($line['powerCompulsory']==0)
    {
        $temp=array();
        $dsql->sendRequest('select * from '.$line['powertable']);
        while($dsql->res_tab_assoc($line))
        {
            $temp[]=$line;
        }
        $i=0;
        do
        {
        
            $return.='<tr><td><select onchange="refreshContent();" name="pw_'.$i.'"><option></option>';
            foreach($temp as $key=>$value)
            {
                if($_POST['pw_'.$i]==$value['id'])
                        $selected='selected="selected"';

                    $return.='<option value="'.$value['id'].'" '.$selected.'>'.tr($value['name']).'</option>';
                    unset($selected);
            }
            $return.='</select>:</td><td><input name="pw_val_'.$i.'" value="'.$_POST['pw_val_'.$i].'"/></td></tr>';
        }while(!empty($_POST['pw_'.$i++]));
      }
      else
      {
            $dsql->sendRequest('select * from '.$line['powertable'].' order by id');
            $i=0;
            while($dsql->res_tab_assoc($line))
            {

                $return.='<tr><td><input type="hidden" name="pw_'.$line['id'].'" value="'.$line['id'].'"/>'.tr($line['name']).'</td><td><input name="pw_val_'.$line['id'].'" value="'.$_POST['pw_val_'.$line['id']].'"/></td></tr>'; 
                $i++;
            }

      }
$return.='</table>';


    return $return;







}
function displayTags()
{
    global $dsql;
    $tagString='';
    if(!empty($_POST['id']))
    {
        $dsql->sendRequest('Select * from tags inner join tags2char  on tags.id=tags2char.id_tag where tags2char.id_char='.$_POST['id']);
    
        while($dsql->res_tab_assoc($tags))
        {
            $tagString.=tr($tags['name']).',';
        }
        $tagString=substr($tagString,0,-1);
 }

    $text='<h3>Tags</h3>';
    $text.= '<input name="tag" id="tag" value="'.$tagString.'" />';
    return       $text;
   
}
function displayBiography()
{
    return '<h2>'.tr('Biographie').'</h2><textarea name="background">'.$_POST['background'].'</textarea>';
}
function displayHandicap()
{
    return '<textarea name="handicap">'.$_POST['handicap'].'</textarea>';
}
function displayInfoPhysique()
{
    $return.='<h3>'.tr('Informations Générales').'</h3><table class="field"><tr><td>'.tr('Taille:').' </td><td><input class="mediumfield" name="hand_taille" value="'.$_POST['hand_taille'].'"/></td></tr>
              <tr><td>'.tr('Vitesse: ').'</td><td><input class="mediumfield" name="hand_vitesse" value="'.($_POST['at_dex']+$_POST['at_force']+5).'"/></td></tr>
              <tr><td>'.tr('Initiative: ').'</td><td><input class="mediumfield" name="hand_init" value="'.($_POST['at_dex']+$_POST['at_cal']).'"/></td></tr>
              <tr><td>'.tr('Défense: ').'</td><td><input class="mediumfield" name="hand_def" value="'.($_POST['at_dex']<$_POST['at_ast']?$_POST['at_dex']:$_POST['at_ast']).'"/></td></tr>
              <tr><td>'.tr('Armure: ').'</td><td><input class="mediumfield" name="hand_arm" value="'.($_POST['hand_arm']).'"/></td></tr>
              </table>';


    return $return;
}

function displayVice()
{
        global $dsql;
        $sql ='SELECT * from wod_vice';
        $dsql->sendRequest($sql);
        $return='<select onchange="checkInfoFrame()" name="ig_vice" id="ig_vice"><option></option>';
        while($dsql->res_tab_assoc($line))
        {
             if($_POST['ig_vice']==$line['id'])
                      $selected='selected="selected"';
             $return.='<option value="'.$line['id'].'" '.$selected.'>'.tr($line['name']).'</option>';
             unset($selected);
        }
        $return.='</select>';
        return $return;
}

function displayVertue()
{
        global $dsql;
        $sql ='SELECT * from wod_vertue';
        $dsql->sendRequest($sql);
        $return='<select onchange="checkInfoFrame()" name="ig_vertue" id="ig_vertue"><option></option>';
        while($dsql->res_tab_assoc($line))
        {
             if($_POST['ig_vertue']==$line['id'])
                      $selected='selected="selected"';
             $return.='<option value="'.$line['id'].'" '.$selected.'>'.tr($line['name']).'</option>';
             unset($selected);
        }
        $return.='</select>';
        return $return;
}
function displayField($table,$id)
{
		if((!isset($table))||(empty($table)))
			return '<input onchange="checkInfoFrame()" name="'.$id.'" id="'.$id.'" value="'.$_POST[$id].'"/>';
		
        global $dsql;
        $sql ='SELECT * from '.$table;
        $dsql->sendRequest($sql);
        $return='<select  onchange="checkInfoFrame()" name="'.$id.'" id="'.$id.'" ><option></option>';
        while($dsql->res_tab_assoc($line))
        {
             if($_POST[$id]==$line['id'])
                      $selected='selected="selected"';
             $return.='<option value="'.$line['id'].'" '.$selected.'>'.tr($line['name']).'</option>';
             unset($selected);
        }
        $return.='</select>';
        return $return;
}
function displaySkillsTab($skills,$prefix)
{
    $return ='<tr class="tiny"><th></th><th>Points</th><th>Spécialité</th></tr>';
    foreach($skills as $key=>$line)
     {
           $return .='<tr>
               <td>'.$line.':</td>
               <td><input onkeypress="return isNumberKey(event)" name="'.$prefix.'_'.$key.'" value="'.$_POST[$prefix.'_'.$key].'"/></td>
               <td><input class="nonshortfield" name="spe_'.$prefix.'_'.$key.'" value="'.$_POST['spe_'.$prefix.'_'.$key].'" /></td>
           </tr>';
     }
     return $return;
}

function displayAdvantageV2($idGame,$isVertue)
{
    global $dsql;
    $sql ='SELECT * from v2_info_value where idgame ='.$idGame.';';
    $dsql->sendRequest($sql);
    $dsql->res_tab_assoc($line);
    if($isVertue)
    {
        $return = '<td>'.tr($line['vertuName']).'</td><td><input name="ig_vertue" id="ig_vertue" /></td>'; 
    }
    else
    {
        $return = '<td>'.tr($line['viceName']).'</td><td><input name="ig_vice" id="ig_vice" /></td>'; 
    }
    return $return;
}

$mentalSkills=array('Artisanat','Erudition','Informatique','Investigation','Medecine','Occultisme','Politique','Science');
$physicalSkills=array('Armes Blanches','Armes à Feu','Athlétisme','Bagarre','Conduite','Furtivité','Larcin','Survie');
$socialSkills=array('Animaux','Empathie','Expression','Intimidation','Persuasion','Relationnel','Sag. de la Rue','Subterfuge');

//$dsql->setDebug(TRUE);
//print_r($_POST);

$page .= '<div><div id="middle"><form method="post" action="/pdf" id="general">
<p><span>Type:</span>
';

$edit=False;
if(isset($currentPath[1]))
{
    $dsql->sendRequest('SELECT * FROM characters where id='.$currentPath[1]);
    $dsql->res_tab_assoc($line);
    $_POST = $_POST  + $line;
    
    $dsql->sendRequest('SELECT * FROM char2power where id_char='.$currentPath[1]);
    $i=0;
    while($dsql->res_tab_assoc($line))
    {
          $_POST['pw_val_'.$line['id_pow']]=$line['value'];
          $i++;
    }


    $dsql->sendRequest('SELECT * FROM char2advantage where id_char='.$currentPath[1]);
    $i=0;
    while($dsql->res_tab_assoc($line))
    {
         $_POST['av_'.$i]=$line['id_advantage'];
          $_POST['av_val_'.$i]=$line['value'];
          
          $i++;
    }
    $edit=True;
    $page .= '<input type="hidden" name="id" value="'.$currentPath[1].'"/>';
}

if($edit)
{
    $title = 'Modify Character';   
}
else
{
    $title = 'Add Character';   
}

$page .= displayGameType();

if(isset($_POST['type_being']))
{
	$dsql->sendRequest('select * from wod_field_game where id_kind='.$_POST['type_being']);
	$dsql->res_tab_assoc($line);
$page .= '<div id="ig_frame"><p id="dialoguser">'.tr('First, fullfill the general information').'</p><table class="field">
<tr>
<td>'.tr('Nom:').'</td><td><input id="ig_name" name="ig_name" onchange="checkInfoFrame()" value="'.$_POST['ig_name'].'"/></td>';
    if ($_POST['type_being'] < 9) {
        $page .= '<td>'.tr('Vertue:').'</td><td>'.displayVertue().'</td>';   
    } else {
       $page .= displayAdvantageV2($_POST['type_being'], true);
    }

$page .= '<td>'.tr($line['field_top']).':</td><td>'.displayField($line['top_base'],'field_top').'</td>
</tr>
<tr>
<td>'.tr('Age:').'</td><td><input id="ig_age" onchange="checkInfoFrame()" name="ig_age" value="'.$_POST['ig_age'].'"/></td>';
    if ($_POST['type_being'] < 9) {
        $page .= '<td>'.tr('Vice:').'</td><td>'.displayVice().'</td>';   
    } else {
       $page .= displayAdvantageV2($_POST['type_being'], false);
    }
$page .='<td>'.tr($line['field_middle']).':</td><td>'.displayField($line['middle_base'],'field_middle').'</td>
</tr>
<tr>
<td>'.tr('Player:').'</td><td><input id="ig_player" onchange="checkInfoFrame()" name="ig_player" value="'.$_POST['ig_player'].'"/></td>
<td>'.tr('Concept:').'</td><td><input id="ig_concept" onchange="checkInfoFrame()" name="ig_concept" value="'.$_POST['ig_concept'].'"/></td>    
<td>'.tr($line['field_bottom']).':</td><td><input onchange="checkInfoFrame()" id="field_bottom" name="field_bottom" value="'.$_POST['field_bottom'].'"/></td>
</tr>
</table></div>


<div id="at_frame"><h2>'.tr('Attributs').'</h2>
<table class="field">
<tr>
    <td>'.tr('Pouvoir:').'</td>
    <td>'.tr('Intelligence').'</td>
    <td><input name="at_int" onchange="checkAttributFrame()" onkeypress="return isNumberKey(event)" id="at_int" value="'.$_POST['at_int'].'"/></td>
    <td>'.tr('Force').'</td>
    <td><input name="at_force" onchange="checkAttributFrame()" onkeypress="return isNumberKey(event)" id="at_force" value="'.$_POST['at_force'].'"/></td>
    <td>'.tr('Présence').'</td>
    <td><input name="at_pre"  onchange="checkAttributFrame()" onkeypress="return isNumberKey(event)" id="at_pre" value="'.$_POST['at_pre'].'"/></td>
</tr>
<tr>
    <td>'.tr('Finesse:').'</td>
    <td>'.tr('Astuce').'</td>
    <td><input name="at_ast"  onchange="checkAttributFrame()" onkeypress="return isNumberKey(event)" id="at_ast" value="'.$_POST['at_ast'].'"/></td>
    <td>'.tr('Dextérité').'</td>
    <td><input name="at_dex"  onchange="checkAttributFrame()" onkeypress="return isNumberKey(event)" id="at_dex" value="'.$_POST['at_dex'].'"/></td>
    <td>'.tr('Manipulation').'</td>
    <td><input name="at_mani" onchange="checkAttributFrame()"  onkeypress="return isNumberKey(event)" id="at_mani" value="'.$_POST['at_mani'].'" /></td>
</tr>   
<tr>
    <td>'.tr('Résistance:').'</td>
    <td>'.tr('Résolution').'</td>
    <td><input name="at_res"  onchange="checkAttributFrame()" onkeypress="return isNumberKey(event)" id="at_res" value="'.$_POST['at_res'].'"/></td>
    <td>'.tr('Vigueur').'</td>
    <td><input name="at_vig"  onchange="checkAttributFrame()" onkeypress="return isNumberKey(event)" id="at_vig" value="'.$_POST['at_vig'].'"/></td>
    <td>'.tr('Calme').'</td>
    <td><input name="at_cal"  onchange="checkAttributFrame()" onkeypress="return isNumberKey(event)" id="at_cal" value="'.$_POST['at_cal'].'"/></td>
</tr>
</table></div>

<div id="skill_frame" class="contener" style="background-color: #FFF;">
<div class="onleft" style="float: left; width: 250px; background-color: #FFF;">
    <h2>'.tr('Talents').'</h2>
    <h3>'.tr('Mental').'</h3>
    <p class="nomarge">'.tr('(incompétent -3)').'</p>
    <table class="field">'.displaySkillsTab($mentalSkills,'tam'). '</table>
    <h3>'.tr('Physique').'</h3>
    <p>'.tr('(Incompétent -1)').' </p>
    <table class="field">'.displaySkillsTab($physicalSkills,'tap').'</table>
    <h3>'.tr('Social').'</h3>
    <p>'.tr('(Incompétent -1)').' </p>
    <table class="field">'.displaySkillsTab($socialSkills,'tas').'</table>
</div>
';

$page .='<div style="float:left; background-color: #FFF;">
<h2>Autres traits</h2><div style="float:left;"><h3>Avantages</h3><table class="field" style="width: 300px">';
$i=0;
do
{
    $page.= '<tr>'.advantageChooser($i).'</tr>
   ';
}while(!empty($_POST['av_'.$i++]));
$page.='</table>
<h3>'.tr('Handicap').'</h3>
'.displayHandicap().'';

$page.= displayGamePower();

$page.=displayInfoPhysique();







$dsql->sendRequest('select * from wod_game where id='.$_POST['type_being']);
$dsql->res_tab_assoc($line);

$volont=$_POST['at_res']+$_POST['at_cal'];
if(!empty($_POST['mvolonte']))
	$volont=$_POST['mvolonte'];
	
$sante=$_POST['at_vig']+$_POST['hand_taille'];
if(!empty($_POST['mhealth']))
	$sante=$_POST['mhealth'];


$page.=displayTags();

$page.=displayBiography();


//end of the middle column
$page .='</div>
<div style="float:left;" id="life_frame">
<h3>'.tr('Santé').'</h3>
<table class="field">
<tr><td>'.tr('Maximal:').'</td><td><input name="mhealth" onkeypress="return isNumberKey(event)" value="'.$sante.'"/></td></tr>
<tr><td>'.tr('Actuel:').'</td><td><input name="chealth" onkeypress="return isNumberKey(event)" value="'.$_POST['chealth'].'"/> </td></tr>
</table>
<h3>'.tr('Volonté').'</h3>
<table class="field">
<tr><td>'.tr('Maximal:').'</td><td><input name="mvolonte" onkeypress="return isNumberKey(event)" value="'.$volont.'"/></td></tr>
<tr><td>'.tr('Actuel:').'</td><td><input name="cvolonte" onkeypress="return isNumberKey(event)" value="'.$_POST['cvolonte'].'"/></td></tr>
</table>'.
(!empty($line['powerindex'])?'<h3>'.tr($line['powerindex']).'</h3>
<input name="mindex" onkeypress="return isNumberKey(event)" value="'.$_POST['mindex'].'"/><br/>':'').
(!empty($line['energy'])?'<h3>'.tr($line['energy']).'</h3>
<input name="menergy" onkeypress="return isNumberKey(event)" value="'.$_POST['menergy'].'"/><br/>':'');


if ($_POST['type_being'] == 9)//wtf v2 
{
    $page .= '<h3>'.tr("Spirit Touchstone").'</h3>
<input name="spirittouchstone" value="'.$_POST['spirittouchstone'].'"/><br/>';

$page .= '<h3>'.tr($line['morality']).'</h3>
<input name="mmoral" onkeypress="return isNumberKey(event)" value="'.$_POST['mmoral'].'"/><br/>';


    $page .= '<h3>'.tr("Déclencheur de Kuruth").'</h3>
    <label>'.tr("Passif").'</label><br/>
<textarea name="kPassive" value="'.$_POST['kPassive'].'"/><br/>
<label>'.tr("Commun").'</label><br/>
<textarea name="kCommon"  value="'.$_POST['kCommon'].'"/><br/>
<label>'.tr("Spécifique").'</label><br/>
<textarea name="kSpec"  value="'.$_POST['kSpec'].'"/><br/>';
}
else
{
$page .= '<h3>'.tr($line['morality']).'</h3>
<input name="mmoral" onkeypress="return isNumberKey(event)" value="'.$_POST['mmoral'].'"/><br/>';
}
//<!--Actuel:<input name="chealth" onkeypress="return isNumberKey(event)" value="'.$_POST['cenergy'].'"/-->;





/*

$(document).ready(function() {
$('#at_frame').hide();
$('#life_frame').hide();
$('#skill_frame').hide();

});*/



$page.='</div>   
</div>
<div class="clear"></div>
<input type="submit" name="generatepdf" value="'.tr('Générer Fiche').'" />
<input type="submit" name="save" value="'.($edit?tr('Mettre à jour'):tr('Enregistrer')).'"/>
';

//$dsql->setDebug(FALSE);  <script type="text/javascript" src="/include/js/after.js"></script>






















}
$page.='</p></form></div></div>';
//$menu="";
}
?>
