<?php 
//include_once("../../session/session_lib.php");

define("_SYSTEM_TTFONTS", "/home/renaud/www/tenebrae/include/pdf/tfpdf/font/unifont/htv");


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
	public $fillcolor;
	
    function Header()
    {
        $this->Image("data/htv/mdt-000.png",0,0,210,300);
        $this->dsql = new driversql();
        $this->dsql->init();
		//$this->dsql->setDebug(true);
        $this->fillcolor=210;
		$this->SetFillColor($this->fillcolor,$this->fillcolor,$this->fillcolor);
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
		$width2=26;
		$width=34;
		
		$this->SetFont('PlasticMan','',16);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,$height,tr('Attributs','B',0,'C');
		$this->Ln();	
		
		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);

        $this->Cell($width2,$height,tr('Intelligence'));
		$this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,digitToRound($this->pj->getField('at_int')));
		$this->SetFont('EscalidoGothico','',10);
        $this->Cell($width2,$height,tr('Force'));
		$this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,digitToRound($this->pj->getField('at_force')));
		$this->SetFont('EscalidoGothico','',10);
        $this->Cell($width2,$height,tr('Présence'));
		$this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,digitToRound($this->pj->getField('at_pre')));
		$this->SetFont('EscalidoGothico','',10);
        $this->Ln();

        $this->Cell($width2,$height,tr('Astuce'));
		$this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,digitToRound($this->pj->getField('at_ast')));
		$this->SetFont('EscalidoGothico','',10);
        $this->Cell($width2,$height,tr('Dextérité'));
		$this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,digitToRound($this->pj->getField('at_dex')));
		$this->SetFont('EscalidoGothico','',10);
        $this->Cell($width2,$height,tr('Manipulation'));
		$this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,digitToRound($this->pj->getField('at_mani')));
		$this->SetFont('EscalidoGothico','',10);
        $this->Ln();


        $this->Cell($width2,$height,tr('Résolution'));
		$this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,digitToRound($this->pj->getField('at_res')));
		$this->SetFont('EscalidoGothico','',10);
        $this->Cell($width2,$height,tr('Vigueur'));
		$this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,digitToRound($this->pj->getField('at_vig')));
		$this->SetFont('EscalidoGothico','',10);
        $this->Cell($width2,$height,tr('Calme'));
		$this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,digitToRound($this->pj->getField('at_cal')));
		
		$this->Ln();
    }

    function displayInfo()
    {   
		$height=6;
		$nameSize=20;
		$valueSize=42;

		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($nameSize,$height,tr('Nom'));
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->pj->getField('ig_name'));
		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($nameSize,$height,tr('Concept'));
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->pj->getField('ig_concept'));
		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($nameSize,$height,tr('Chronique'));
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->pj->getField('field_top'));
        $this->Ln();


		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($nameSize,$height,tr('Age'));
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_age'));
		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($nameSize,$height,tr('Vertu'));
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->vertuesList[$this->pj->getField('ig_vertue')]);
		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($nameSize,$height,tr('Faction'));
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('field_middle'));
       $this->Ln();

		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($nameSize,$height,tr('Joueur'));
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_player'));
		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($nameSize,$height,tr('Vice'));
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->vicesList[$this->pj->getField('ig_vice')]);
		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($nameSize,$height,tr('Nom du groupe'));
		$this->SetFont('goudy','',10);
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

		$this->SetFont('PlasticMan','',15);
		$this->SetTextColor(0,0,0);
		$this->SetFillColor($this->fillcolor,$this->fillcolor,$this->fillcolor);
		$this->Cell(($nameSize+$valueSize),$height,'COMPETENCES','B',0,'C',TRUE);
		

		$myY= $this->getY();
        $myX= $this->getX();
		$this->Ln();
		$this->Ln();
		$this->SetFont('EscalidoGothico','',14);
		$this->Cell($nameSize+$valueSize,$height,'Mental',0,0,'C');
		$this->Ln();
		$this->SetFont('goudy','',8);
		$this->SetTextColor(0,0,0);		
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -3)',0,0,'C');
		$this->Ln();
		$this->Line($this->getX()+$nameSize+$valueSize+1,$this->getY()-10,$this->getX()+$nameSize+$valueSize+1,$this->getY()+150);
		
		$this->SetFont('goudy','',8);
		$this->SetTextColor(0,0,0);
	    foreach($mentalSkills as $key=> $skill)
        {
            $title = tr($skill);
            $tmp = $this->pj->getField('spe_tam_'.$key);
            if(!empty($tmp))
                $title.=': ('.tr($tmp).')';
			$this->SetFont('goudy','',8);
            $this->Cell($nameSize,$height,$title);
			$this->SetFont('DejaVu','',8);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tam_'.$key)),0,0,'C');
            $this->Ln();
        }
     	$this->SetFont('EscalidoGothico','',14);
		$this->SetTextColor(0,0,0);
		$this->Cell($nameSize+$valueSize,$height,'Physique',0,0,'C');
        $this->Ln();
		$this->SetFont('goudy','',8);
        $this->SetTextColor(0,0,0);
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -1)',0,0,'C');
		$this->Ln();
         
	    foreach($physicalSkills as $key=> $skill)
        {
            
            $title = tr($skill);
            $tmp = $this->pj->getField('spe_tap_'.$key);
            if(!empty($tmp))
                $title.=': ('.tr($tmp).')';
                
			$this->SetFont('goudy','',8);
            $this->Cell($nameSize,$height,$title);
			$this->SetFont('DejaVu','',8);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tap_'.$key)),0,0,'C');
            $this->Ln();
        }
        $this->SetFont('EscalidoGothico','',14);
        $this->SetTextColor(0,0,0);
        $this->Cell($nameSize+$valueSize,$height,'Social',0,0,'C');
        $this->Ln();

        $this->SetFont('goudy','',8);
        $this->SetTextColor(0,0,0);     
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -1)',0,0,'C');


		foreach($socialSkills as $key=> $skill)
        {
			$this->Ln();
            
            $title = tr($skill);
            $tmp = $this->pj->getField('spe_tas_'.$key);
            if(!empty($tmp))
                $title.=': ('.tr($tmp).')';
                
			$this->SetFont('goudy','',8);
            $this->Cell($nameSize,$height,$title);
			$this->SetFont('DejaVu','',8);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tas_'.$key)),0,0,'C');
            
        }
		$this->centralColumn($myX,$myY);
	}
	function displaySante($X,$Y)
	{
		$this->SetLeftMargin($X+2);
		$this->SetX($X);
		$this->SetY($Y);
        $this->Ln();
        $this->Ln();	
		$height=5;
		$widthValue=55;
		$this->SetFont('EscalidoGothico','',16);
		$this->SetTextColor(0,0,0);
		$this->Cell($widthValue,$height,tr('Santé'),0,0,'C');
		$this->Ln();
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
		$line1='';
		$line2='';
		$sante=$this->pj->getField('mhealth');
		$max=12;
		if($sante>$max)
			$max=$sante;
		$this->SetFont('DejaVu','',8);
		//$this->SetLeftMargin($X+6);
		$size=($widthValue)/$max;
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

		$widthValue=55;
		$this->SetFont('EscalidoGothico','',16);
		$this->SetTextColor(0,0,0);
		$this->Cell($widthValue,$height,tr('Volonté'),0,0,'C');
		$this->Ln();
		$max=8;
		$volonte=$this->pj->getField('mvolonte');
//		echo $volonte," doheo";
		if($volonte>$max)
			$max=$volonte;
		
		$this->SetFont('goudy','',10);
		$this->SetTextColor(0,0,0);
		
		$size=($widthValue)/$max;
		$this->SetFont('DejaVu','',8);
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
        $this->displayHumanity();
		//$this->displayBloodPotency();
	}

	
    function displayHumanity()
    {
        $height=5;
        
        $widthValue=55;

		$this->SetFont('EscalidoGothico','',16);
		$this->SetTextColor(0,0,0);
		$this->Cell($widthValue,$height,tr('Moralité'),0,0,'C');
        $this->Ln();
        $this->SetFont('goudy','',10);
        $this->SetTextColor(0,0,0);
		$volonte=$this->pj->getField('mmoral');
		$this->SetFont('DejaVu','',8);
        for($i=10;$i>0;$i--)
        {
			$this->Cell($height,$height,'');
			$this->SetFont('EscalidoGothico','',8);
            $this->Cell($height,$height,$i.' ','B',0,'C');
            $this->Cell($widthValue-$height-$height-$height-$height,$height,'','B',0,'C');
			
			$this->SetFont('DejaVu','',8);
			if($volonte==$i)
				$this->Cell($height,$height,'●','B',0,'C');
			else 
				$this->Cell($height,$height,'○','B',0,'C');

            $this->Ln();

        }
    
        $this->displayExperience();
    }
    function displayGenericInformation()
    {
        $height=5;
        
        $widthValue=55;
		$this->SetFont('EscalidoGothico','',10);
        $length=$this->GetStringWidth('Initiative:');
		$length+=2;
		
        $this->Cell($length,$height,tr('Taille:'),0,0,'L');
        $this->Cell($widthValue-$length,$height,''.($this->pj->getField('hand_taille')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Vitesse:'),0,0,'L');
        $this->Cell($widthValue-$length,$height,''.($this->pj->getField('at_dex')+$this->pj->getField('at_force')+5),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Defense:'),0,0,'L');
        $this->Cell($widthValue-$length,$height,''.min($this->pj->getField('at_dex'),$this->pj->getField('at_ast')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Armure:'),0,0,'L');
        $this->Cell($widthValue-$length,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Initiative:'),0,0,'L');
        $this->Cell($widthValue-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_dex')),'B',0,'L');


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
	function displayHandicap()
	{
		
		$widthValue=55;
		$height=5;
		$handicap=$this->pj->getField('handicap');
		$this->SetFont('EscalidoGothico','',16);
		$this->SetTextColor(0,0,0);
		$this->Cell($widthValue,$height,tr('Handicaps'),0,0,'C');
		$this->Ln();
		$this->SetFont('Goudy','',8);
		$length=$this->GetStringWidth($handicap);
		$tab=str_split($handicap,50);
		$this->Cell($widthValue,$height,$tab[0],'B',0,'C');
		$this->Ln();
		
		$this->Cell($widthValue,$height,$tab[1],'B',0,'C');
		$this->Ln();
		$this->Cell($widthValue,$height,$tab[2],'B',0,'C');
		$this->Ln();
	}
	function displayArmes()
	{
		$this->Ln();
		$widthName=65;
		$height=5;
		$widthValue=40;
		$this->SetFont('EscalidoGothico','',16);
		$this->SetTextColor(0,0,0);
		$this->SetFillColor($this->fillcolor,$this->fillcolor,$this->fillcolor);
		$this->Cell($widthName,$height,tr('Armes'),0,0,'L',TRUE);
		$this->Cell($height,$height,'');
		$this->Cell($widthValue,$height,tr('Modificateurs'),0,0,'C',TRUE);
		$this->Ln();
		$this->Cell($widthName,$height,'','B');
		$this->Cell($height,$height,'');
		$this->Cell($widthValue,$height,'','B');
		$this->Ln();
		$this->Cell($widthName,$height,'','B');
		$this->Cell($height,$height,'');
		$this->Cell($widthValue,$height,'','B');
		$this->Ln();
		$this->Cell($widthName,$height,'','B');
		$this->Cell($height,$height,'');
		$this->Cell($widthValue,$height,'','B');
	}
	function displayEquipement()
	{
		$this->Ln();
		$this->Ln();
		$widthName=65;
		$height=5;
		$widthValue=40;
		$this->SetFont('EscalidoGothico','',16);
		$this->SetTextColor(0,0,0);
		$this->SetFillColor($this->fillcolor,$this->fillcolor,$this->fillcolor);
		$this->Cell($widthName,$height,tr('Équipements'),0,0,'L',TRUE);
		$this->Cell($height,$height,'');
		$this->Cell($widthValue,$height,tr('Modificateurs'),0,0,'C',TRUE);
		$this->Ln();
		$this->Cell($widthName,$height,'','B');
		$this->Cell($height,$height,'');
		$this->Cell($widthValue,$height,'','B');
		$this->Ln();
		$this->Cell($widthName,$height,'','B');
		$this->Cell($height,$height,'');
		$this->Cell($widthValue,$height,'','B');
		$this->Ln();
		$this->Cell($widthName,$height,'','B');
		$this->Cell($height,$height,'');
		$this->Cell($widthValue,$height,'','B');
	}
	function centralColumn($myX,$myY)
	{
		$this->SetLeftMargin($myX+2);
		$this->SetX($myX);
		$this->SetY($myY);
		$height=5;
		$this->SetFillColor($this->fillcolor,$this->fillcolor,$this->fillcolor);
		$this->SetFont('PlasticMan','',15);
		$this->SetTextColor(0,0,0);
        $this->Cell(1,$height,'',0,0,'C');
	    $this->Cell(($widthName+$widthValue)*2,$height,tr('Autres Caracteristiques'),'B',0,'C',TRUE);
        $this->Ln();	

		$this->displayAtout();
		$this->displayHandicap();
		$this->displayGenericInformation();
		$x=$this->GetX();
		$this->Ln();	
		$this->displayArmes();
		$this->displayEquipement();
		
		$this->displaySante($x,$myY);
	}
	function displayExperience()
	{
	
		$widthValue=50;
		$height=5;
		$this->Ln();
		$this->SetFont('EscalidoGothico','',10);
		$this->SetTextColor(0,0,0);
		$length=$this->GetStringWidth(tr('Experience:'));
		$this->Cell($length,$height,tr('Expérience'),0,0,'L');
		$this->Cell($widthValue-$length,$height,'','B',0,'C');
		$this->Ln();
		
		$this->Cell($widthValue,$height,'','B',0,'C');
		$this->Ln();


	
	
	
	}
	function displayAtout()
	{
		
		$height=5;
$this->SetFillColor($this->fillcolor,$this->fillcolor,$this->fillcolor);
		$widthName=37;
		$widthValue=16;
		$this->Ln();
		$this->SetFont('EscalidoGothico','',16);
		$this->Cell($widthName+$widthValue,$height,tr('Atouts'),0,0,'C');
		$myX= $this->getX();
		$myY= $this->getY();
		$this->Ln();
		
		
		$this->SetTextColor(0,0,0);
        $i=0;
        $tmp=$this->pj->getField('av_'.$i);
        while($i<9)
        {
			$this->SetFont('Goudy','',8);
			if(!empty($this->advantageList[$this->pj->getField('av_'.$i)]))
				$this->Cell($widthName,$height,tr($this->advantageList[$this->pj->getField('av_'.$i)]),'B');
			else
				$this->Cell($widthName,$height,'','B');
				
			$this->SetFont('DejaVu','',8);
            $this->Cell($widthValue,$height,digitToRound($this->pj->getField('av_val_'.$i)));
            $this->Ln();
            $i++;
            $tmp=$this->pj->getField('av_'.$i);
        }

        
		$this->Ln();


	}

}
$pdf=new PDF();







//$char = new Character($_POST);



$pdf->SetTitle(tr('Fiche de personnage: ').$char->getField('name'),true);
$pdf->SetAuthor('Renaud Guezennec',true);
$pdf->SetCreator('Nwod Character Sheet - nwod.rolisteam.org',true);

$pdf->setPj($char);

$pdf->SetMargins(0,0,0);
$pdf->AddFont('goudy','','goudy.ttf',true);
$pdf->AddFont('PlasticMan','','PlasticMan.ttf',true);
$pdf->AddFont('escalidosteak','','EscalidoStreak.ttf',true);
$pdf->AddFont('escalidogothico','','EscalidoGothico.ttf',true);
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('goudy','',12);

$pdf->SetMargins(23,40);
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);


$pdf->displayInfo();
$pdf->jumpSection();

$pdf->displayAttribut();
$myY=$pdf->getY();
$pdf->displayTalent();
$myX=$pdf->getX();
//echo $myX," Y=",$myY;
//$pdf->centralColumn($myX,$myY);

$pdf->jumpSection();



//$pdf->displaySante($myX,$Y);
//$myX3+=$pdf->displaySpec($myX,$myY);




//$myX+=$pdf->displayAtout($myX+$myX2,$myY);


$pdf->Output($char->getField('ig_name').'.pdf','D');
//◼ ◻ 


