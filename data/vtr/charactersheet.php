<?php 
//include_once("../../session/session_lib.php");

define("_SYSTEM_TTFONTS", "/home/renaud/www/tenebrae/include/pdf/tfpdf/font/unifont/vtr");


require_once('include/pdf/tfpdf/tfpdf.php');
require_once('security/session_lib.php');
require_once('include/connection/driversql.inc.php');
$dsql= new driversql();
$dsql->init();
require_once('data/character.php');
require_once('include/libphp/lib.php');

class PDF extends tFPDF
{
    public $pj;
    public $dsql;
    public $vicesList;
    public $vertusList;
    public $advantageList;
	public $ligueList;
	public $discipleList;
	public $clanList;
	
    function Header()
    {
        $this->Image("data/vtr/bg.jpg",0,0,210,300);
        $this->dsql = new driversql();
        $this->dsql->init();
		//$this->dsql->setDebug(true);
        
        $this->listAdvantages();
        $this->listvices();
        $this->listvertues();
		$this->listDiscipines();
		$this->listLigues();
		$this->listClan();
    }
    function listAdvantages()
    {
        $this->dsql->sendRequest('SELECT * from wod_advantage');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->advantageList[$line['id']]=$line['name'];
        }
    }
	function listLigues()
    {
        $this->dsql->sendRequest('SELECT * from vp_ligue');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->ligueList[$line['id']]=$line['name'];
        }
    }
	function listClan()
    {
        $this->dsql->sendRequest('SELECT * from vp_clans');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->clanList[$line['id']]=$line['name'];
        }
    }
	function listDiscipines()
    {
        $this->dsql->sendRequest('SELECT * from vp_discipline');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->discipleList[$line['id']]=$line['name'];
        }
    }
    function listvices()
    {
        $this->dsql->sendRequest('SELECT * from wod_vice');
                while($this->dsql->res_tab_assoc($line))
                {
                   $this->vicesList[$line['id']]=$line['name'];
                }
    }
    function listvertues()
    {
        $this->dsql->sendRequest('SELECT * from wod_vertue');
                while($this->dsql->res_tab_assoc($line))
                {
                   $this->vertuesList[$line['id']]=$line['name'];
                }
    }
    function setPj($pj)
    {
        $this->pj=$pj;
    }

    function displayAttribut()
    {
		$height=6;
		
		
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
		$this->Cell(0,$height,tr('Attributs'),'B',0,'C');
		$this->Ln();	
		
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);

        $this->Cell(31,$height,tr('Intelligence'));
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_int')));
        $this->Cell(31,$height,tr('Force'));
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_force')));
        $this->Cell(31,$height,tr('Présence'));
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_pre')));
        $this->Ln();

        $this->Cell(31,$height,tr('Astuce'));
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_ast')));
        $this->Cell(31,$height,tr('Dextérité'));
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_dex')));
        $this->Cell(31,$height,tr('Manipulation'));
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_mani')));
        $this->Ln();


        $this->Cell(31,$height,tr('Résolution'));
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_res')));
        $this->Cell(31,$height,tr('Vigueur'));
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_vig')));
        $this->Cell(31,$height,tr('Calme'));
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_cal')));
        $this->Ln();
    }

    function displayInfo()
    {   
        //$this->Image("data/vtr/logo.jpg",80,Null,80,20);
		$height=25;
        $this->Ln($height);
		$nameSize=20;
		$valueSize=42;
        $height=6;
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
        $this->Cell($nameSize,$height,tr('Nom'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->pj->getField('ig_name'));
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
        $this->Cell($nameSize,$height,tr('Vertue'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->vertuesList[$this->pj->getField('ig_vertue')]);
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
        $this->Cell($nameSize,$height,tr('Clan'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->clanList[$this->pj->getField('field_top')]);
        $this->Ln();


		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
       $this->Cell($nameSize,$height,tr('Joueur'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_player'));
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
       $this->Cell($nameSize,$height,tr('Vice'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->vicesList[$this->pj->getField('ig_vice')]);
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
       $this->Cell($nameSize,$height,tr('Ligue'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->ligueList[$this->pj->getField('field_middle')]);
       $this->Ln();

		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
       $this->Cell($nameSize,$height,tr('Chronique'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,'');
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
       $this->Cell($nameSize,$height,tr('Concept'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_concept'));
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
       $this->Cell($nameSize,$height,tr('Coterie'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('field_bottom'));
       $this->Ln();
    }
	function displayTalent()
	{
		
		$height=5;
		$nameSize=35;
		$valueSize=14;
		
        $mentalSkills=array('Artisanat','Erudition','Informatique','Investigation','Medecine','Occultisme','Politique','Science');
        $physicalSkills=array('Armes Blanches','Armes à Feu','Athlétisme','Bagarre','Conduite','Furtivité','Larcin','Survie');
        $socialSkills=array('Animaux','Empathie','Expression','Intimidation','Persuasion','Relationnel','Sag. de la Rue','Subterfuge');		

		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
		$this->Cell(($nameSize+$valueSize),$height,tr('Talents'),'B',0,'C');
		

		$myY= $this->getY();
        $myX= $this->getX();
		$this->Ln();
		$this->Ln();
		$this->SetFont('Cezanne','',14);
		$this->Cell($nameSize+$valueSize,$height,tr('Mental'),0,0,'C');
		$this->Ln();
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);		
		$this->cell($nameSize+$valueSize,$height,tr('(Incompétent -3)'),0,0,'C');
		$this->Ln();
		$this->Line($this->getX()+$nameSize+$valueSize+1,$this->getY()-10,$this->getX()+$nameSize+$valueSize+1,$this->getY()+150);
		
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);
	    foreach($mentalSkills as $key=> $skill)
        {
            $title = tr($skill);
            $tmp = $this->pj->getField('spe_tam_'.$key);
            if(!empty($tmp))
                $title.=': ('.tr($tmp).')';

            $this->Cell($nameSize,$height,$title);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tam_'.$key)),0,0,'C');
            $this->Ln();
        }
     	$this->SetFont('Cezanne','',14);
		$this->SetTextColor(150,0,0);
		$this->Cell($nameSize+$valueSize,$height,tr('Physique'),0,0,'C');
        $this->Ln();
		$this->SetFont('DejaVu','',8);
        $this->SetTextColor(0,0,0);
		$this->cell($nameSize+$valueSize,$height,tr('(Incompétent -1)'),0,0,'C');
		$this->Ln();
         
	    foreach($physicalSkills as $key=> $skill)
        {
            $title = tr($skill);
            $tmp = $this->pj->getField('spe_tap_'.$key);
            if(!empty($tmp))
                $title.=': ('.tr($tmp).')';

            $this->Cell($nameSize,$height,$title);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tap_'.$key)),0,0,'C');
            $this->Ln();
        }
        $this->SetFont('Cezanne','',14);
        $this->SetTextColor(150,0,0);
        $this->Cell($nameSize+$valueSize,$height,tr('Social'),0,0,'C');
        $this->Ln();

        $this->SetFont('DejaVu','',8);
        $this->SetTextColor(0,0,0);     
		$this->cell($nameSize+$valueSize,$height,tr('(Incompétent -1)'),0,0,'C');
		$this->Ln();

		foreach($socialSkills as $key=> $skill)
        {
            $title = tr($skill);
            $tmp = $this->pj->getField('spe_tas_'.$key);
            if(!empty($tmp))
                $title.=': ('.($tmp).')';

            $this->Cell($nameSize,$height,$title);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tas_'.$key)),0,0,'C');
            $this->Ln();
        }

		$myY2= $this->getY();
		$myX2= $this->getX();
        $this->displayAtout($myX,$myY);
		
		//$this->displaySante($myX,$myY);
		

		//$this->Ln();
		
		$this->Ln();
		return $myY;
	}
	function displaySante($X,$Y)
	{
		$this->SetLeftMargin($X+2);
		$this->SetX($X);
		$this->SetY($Y);
        $this->Ln();
        $this->Ln();	
		$height=5;
		$widthName=28;
		$widthValue=30;
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
		$this->Cell($widthName+$widthValue,$height,tr('Santé'),0,0,'C');
		$this->Ln();
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
		$line1='';
		$line2='';
		$sante=$this->pj->getField('mhealth');
		$max=12;
		if($sante>$max)
			$max=$sante;
		
		//$this->SetLeftMargin($X+6);
		$size=($widthName+$widthValue)/$max;
		for($i=0;$i<$max;$i++)
		{
			if($i<$sante)
				$line1 ='●';
			else
				$line1 ='○';
			$this->Cell($size,$height,$line1,0,0,'C');

		}
		
		$this->Ln();
		for($i=0;$i<$max;$i++)
		{
			$line2='◻';
			$this->Cell($size,$height,$line2,0,0,'C');
		}
		

		
		$this->Ln();
		$this->SetLeftMargin($X+2);
		$this->displayVolonte();
	}
	function displayVolonte()
	{
		$height=5;
		$widthName=28;
		$widthValue=30;
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
		$this->Cell($widthName+$widthValue,$height,tr('Volonté'),0,0,'C');
		$this->Ln();
		$max=8;
		$volonte=$this->pj->getField('mvolonte');
//		echo $volonte," doheo";
		if($volonte>$max)
			$max=$volonte;
		
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
		
		$size=($widthName+$widthValue)/$max;
		for($i=0;$i<$max;$i++)
		{
			if($i<$volonte)
				$line2='●';
			else
				$line2='○';
				
			$this->Cell($size,$height,$line2,0,0,'C');
		}
		$this->Ln();
        for($i=0;$i<$max;$i++)
        {
          $line2='◻';
          $this->Cell($size,$height,$line2,0,0,'C');
        }
			$this->Ln();
        
		$this->displayBloodPotency();
	}

	function displayVitae()
	{
		$height=5;
		$widthName=58;
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
		$this->Cell($widthName,$height,'Vitae',0,0,'C');
		$max = 10;
		$this->Ln();
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
		
		$vitae=$this->pj->getField('menergy');
		
		if($vitae>$max)
			$max=$vitae;
			
		$size=($widthName)/$max;
		for($i=0;$i<$max;$i++)
		{
			if($i<$vitae)
			    $line2='◼';
            else
                $line2='◻';
			$this->Cell($size,$height,$line2,0,0,'C');
		}
		$this->Ln();
		for($i=0;$i<$max;$i++)
		{
			$line2='◻';
			$this->Cell($size,$height,$line2,0,0,'C');
		}
		
		$this->Ln();
        $this->displayHumanity();
	}
    function displayHumanity()
    {
        $height=5;
        $widthName=58;

		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
        $this->Cell($widthName,$height,tr('Humanité'),0,0,'C');
        $this->Ln();
        $this->SetFont('DejaVu','',10);
        $this->SetTextColor(0,0,0);
		$volonte=$this->pj->getField('mmoral');
        for($i=10;$i>0;$i--)
        {
            $length = $this->GetStringWidth($i);

            $this->Cell($length,$height,$i.' ',0,0,'C');
            $length+=$this->GetStringWidth('●');
            $this->Cell($widthName-$length,$height,'','B',0,'C');
			if($volonte==$i)
				$this->Cell($this->GetStringWidth('●'),$height,'●',0,0,'C');
			else 
				$this->Cell($this->GetStringWidth('○'),$height,'○',0,0,'C');

            $this->Ln();

        }
    
        $this->displayGenericInformation();

    }
    function displayGenericInformation()
    {
        $height=5;
        $widthName=58;
        $length=$this->GetStringWidth(tr('Experience:'));
        $this->Ln();
        $this->Cell($length,$height,tr('Taille:'),0,0,'L');
        $this->Cell($widthName-$length,$height,''.($this->pj->getField('hand_taille')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Vitesse:'),0,0,'L');
        $this->Cell($widthName-$length,$height,''.($this->pj->getField('at_dex')+$this->pj->getField('at_force')+$this->pj->getField('hand_taille')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Defense:'),0,0,'L');
        $this->Cell($widthName-$length,$height,''.min($this->pj->getField('at_dex'),$this->pj->getField('at_ast')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Armure:'),0,0,'L');
        $this->Cell($widthName-$length,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Initiative:'),0,0,'L');
        $this->Cell($widthName-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_dex')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Experience:'),0,0,'L');
        $this->Cell($widthName-$length,$height,'','B',0,'L');

    }
	function displayBloodPotency()
	{
		$height=5;
		$widthName=58;
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
		$this->Cell($widthName,$height,tr('Puissance du sang'),0,0,'C');
		$max = 10;
		$this->Ln();
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
		
		$bp=$this->pj->getField('mindex');
		if($bp>$max)
			$max=$bp;
			
		//echo " fzefjzb",$bp;
		$size=($widthName)/$max;
		for($i=0;$i<$max;$i++)
		{
			if($i<$bp)
				$line2='●';
			else
				$line2='○';
				
			$this->Cell($size,$height,$line2,0,0,'C');
		}
		$this->Ln();
		$this->displayVitae();
	}
	function jumpSection()
	{
		$this->Ln();	
	}
	function SetCol($col)
	{
		$this->col=$col;
		$x=10+$col*65;
		$this->SetLeftMargin($x);
		$this->SetX($x);
	}
	function displayDiscipline($X,$Y)
	{
		
		$height=5;
        $this->SetLeftMargin($X);
		$this->SetX($X);
		$this->SetY($Y);
		$widthName=58;
		
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
		$this->Cell($widthName+$widthValue,$height,tr('Disciplines'),0,0,'C');
		$this->Ln();
		
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);
		$i=0;
        $tmp=$this->pj->getField('pw_'.$i);
        while(!empty($tmp)||($i<5))
		{
            $length=$this->GetStringWidth(digitToRound($this->pj->getField('pw_val_'.$i)));
			$this->Cell($widthName-$length,$height,$this->discipleList[$this->pj->getField('pw_'.$i)],'B');
			$this->Cell($length,$height,digitToRound($this->pj->getField('pw_val_'.$i)));
			$this->Ln();
            $i++;
            $tmp=$this->pj->getField('pw_'.$i);
		}
		$this->Ln();

		$widthName=58;
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
		$this->Cell($widthName,$height,'Handicaps',0,0,'C');
		$this->Ln();
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);

        $this->Ln();
          
        $this->Cell($widthName,$height,'','B');
        $this->Ln();
                            
        $this->Cell($widthName,$height,'','B');
        $this->Ln();
                                            
        $this->Cell($widthName,$height,'','B');	
		

		$this->displayEquipment();
		$this->Ln();
	}
	function displayEquipment()
	{
		$height=5;
		$this->Ln();
		$this->Ln();
		$widthName=58;
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
		$this->Cell($widthName,$height,tr('Équipement'),0,0,'C');
        $this->Ln();

        $this->Cell($widthName,$height,'','B');
        $this->Ln();

        $this->Cell($widthName,$height,'','B');
        $this->Ln();

        $this->Cell($widthName,$height,'','B');

	}
	function displayAtout($X,$Y)
	{
		
		$height=5;
        $this->SetLeftMargin($X+2);
		$this->SetX($X);
		$this->SetY($Y);
		$widthName=120;
		
		
		$this->SetFont('Cezanne','',16);
		$this->SetTextColor(150,0,0);
        $this->Cell(1,$height,'',0,0,'C');
	    $this->Cell($widthName,$height,tr('Autres traits'),'B',0,'C');
        $this->Ln();	
        $this->Ln();	
        $widthName=58;
		
		$this->Cell($widthName,$height,tr('Atouts'),0,0,'C');
		$myY= $this->getY();
		$myX= $this->getX();
		$this->Ln();
		
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);
//        echo $this->pj->getCountSpec();
        $i=0;
        $tmp=$this->pj->getField('av_'.$i);
        //$widthName=30;
        //$widthValue=18;
        $lenght=$this->GetStringWidth(digitToRound(5));
        $widthName-=$lenght;
        $widthValue=$lenght;

        while(!empty($tmp)||($i<5))
        {
            $this->Cell($widthName,$height,tr($this->advantageList[$this->pj->getField('av_'.$i)]),'B');
            $this->Cell($widthValue,$height,digitToRound($this->pj->getField('av_val_'.$i)));
            $this->Ln();
            $i++;
            $tmp=$this->pj->getField('av_'.$i);

        }
        $this->Ln();
        $this->displayDiscipline($this->getX(),$this->getY());
		$this->displaySante($myX,$Y);
		
    	return $widthName+$widthValue;
	}

}
$pdf=new PDF();

/*$char=array();
if(!empty($_GET['id']))
{
        $idchar=$_GET['id'];
    $dsql->sendRequest('select * from characters where id ='.$_GET['id']);
    $dsql->res_tab_assoc($line);
//    print_r($line);
//    echo "truc",$_GET['id'];
    $dsql->sendRequest('select * from char2power where id_char ='.$_GET['id']);
    $i=0;
    while($dsql->res_tab_assoc($pow))
    {
        $line['pw_'.$i]=$pow['id_pow'];
        $line['pw_val_'.$i]=$pow['value'];
        $i++;
    }
    $dsql->sendRequest('select * from char2advantage where id_char ='.$_GET['id']);
    $i=0;
    while($dsql->res_tab_assoc($pow))
    {
       $line['av_'.$i]=$pow['id_advantage'];
       $line['av_val_'.$i]=$pow['value'];
       $i++;
    }
    $char=new Character($line);
}   
else
    $char = new Character($_POST);*/
//$char->setSecret(true);
//print_r($_POST);
//$char->updateModications($dsql);


$pdf->SetTitle(tr('Fiche de personnage: ').$char->getField('name'),true);
$pdf->SetAuthor('Renaud Guezennec',true);
$pdf->SetCreator('Nwod Character Sheet - nwod.rolisteam.org',true);

$pdf->setPj($char);

$pdf->SetMargins(0,0,0);
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('Cezanne','','Cezanne.ttf',true);


$pdf->SetFont('DejaVu','',12);

$pdf->SetMargins(20,20);
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);


$pdf->displayInfo();
$pdf->jumpSection();
$myX=$pdf->getX();
$pdf->displayAttribut();
$pdf->displayTalent();

$pdf->jumpSection();

$myY=$pdf->getY();
//$myX3+=$pdf->displaySpec($myX,$myY);



$myX2+=
//$myX+=$pdf->displayAtout($myX+$myX2,$myY);

$pdf->Output($char->getField('ig_name').'.pdf','D');

//◼ ◻ 


