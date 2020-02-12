<?php 
//include_once("../../session/session_lib.php");

if(!define("_SYSTEM_TTFONTS", "/home/www/rolisteam/tenebrae/include/pdf/tfpdf/font/unifont/CtL"))
{
    die("error to define system font"._SYSTEM_TTFONTS);
}


require_once('include/pdf/tfpdf/tfpdf.php');
require_once('security/session_lib.php');
require_once('include/connection/driversql.inc.php');
$dsql= new driversql();
$dsql->init();
require_once('data/character.php');
require_once('include/libphp/lib.php');

//define("FPDF_FONTPATH", "/home/www/rolisteam/tenebrae/include/pdf/tfpdf/font/unifont/NWoD/CtL/");
class PDF extends tFPDF
{
    public $pj;
    public $dsql;
    public $vicesList;
    public $vertusList;
    public $advantageList;
	public $kithList;
	public $contratList;
	public $SeemingList;
	public $courtList;
    
    function Header()
    {
        $this->Image("data/ctl/ctl-000.jpg",0,0,210,300);
        $this->dsql = new driversql();
        $this->dsql->init();
		//$this->dsql->setDebug(true);
        
        $this->listAdvantages();
        $this->listvices();
        $this->listvertues();
		$this->listKith();
		$this->listSeeming();
		$this->listContrats();
        $this->listCourt();
    }
    function listAdvantages()
    {
        $this->dsql->sendRequest('SELECT * from wod_advantage');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->advantageList[$line['id']]=$line['name'];
        }
    }
	function listKith()
    {
        $this->dsql->sendRequest('SELECT * from cl_kith');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->kithList[$line['id']]=$line['name'];
        }
    }
	function listSeeming()
    {
        $this->dsql->sendRequest('SELECT * from cl_seeming');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->SeemingList[$line['id']]=$line['name'];
        }
    }
	function listContrats()
    {
        $this->dsql->sendRequest('SELECT * from cl_contrat');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->contratList[$line['id']]=$line['name'];
        }
    }
    function listCourt()
    {
        $this->dsql->sendRequest('SELECT * from cl_court');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->courtList[$line['id']]=$line['name'];
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
		
		
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
		$this->Cell(0,$height,'Attributs','B',0,'C');
		$this->Ln();	
		
		$this->SetFont('akira','',10);
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
		$height=6;
		$nameSize=20;
		$valueSize=42;

		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
        $this->Cell($nameSize,$height,'Nom');
		$this->SetFont('akira','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->pj->getField('ig_name'));
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
        $this->Cell($nameSize,$height,'Vertue');
		$this->SetFont('akira','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->vertuesList[$this->pj->getField('ig_vertue')]);
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
        $this->Cell($nameSize,$height,'Seeming');
		$this->SetFont('akira','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->SeemingList[$this->pj->getField('field_top')]);
        $this->Ln();


		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
       $this->Cell($nameSize,$height,'Joueur');
		$this->SetFont('akira','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_player'));
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
       $this->Cell($nameSize,$height,'Vice');
		$this->SetFont('akira','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->vicesList[$this->pj->getField('ig_vice')]);
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
       $this->Cell($nameSize,$height,'Kith');
		$this->SetFont('akira','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->kithList[$this->pj->getField('field_middle')]);
       $this->Ln();

		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
       $this->Cell($nameSize,$height,'Chronique');
		$this->SetFont('akira','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,'');
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
       $this->Cell($nameSize,$height,'Concept');
		$this->SetFont('akira','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_concept'));
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
       $this->Cell($nameSize,$height,'Court');
		$this->SetFont('akira','',10);
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

		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
		$this->Cell(($nameSize+$valueSize),$height,'Talents','B',0,'C');
		

		$myY= $this->getY();
        $myX= $this->getX();
		$this->Ln();
		$this->Ln();
		$this->SetFont('goudy','',14);
		$this->Cell($nameSize+$valueSize,$height,'Mental',0,0,'C');
		$this->Ln();
		$this->SetFont('akira','',8);
		$this->SetTextColor(0,0,0);		
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -3)',0,0,'C');
		$this->Ln();
		$this->Line($this->getX()+$nameSize+$valueSize+1,$this->getY()-10,$this->getX()+$nameSize+$valueSize+1,$this->getY()+150);
		
		$this->SetFont('akira','',8);
		$this->SetTextColor(0,0,0);
	    foreach($mentalSkills as $key=> $skill)
        {
            $title = $skill;
            $tmp = $this->pj->getField('spe_tam_'.$key);
            if(!empty($tmp))
                $title.=': ('.$tmp.')';

            $this->Cell($nameSize,$height,$title);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tam_'.$key)),0,0,'C');
            $this->Ln();
        }
     	$this->SetFont('goudy','',14);
		$this->SetTextColor(0,150,0);
		$this->Cell($nameSize+$valueSize,$height,'Physique',0,0,'C');
        $this->Ln();
		$this->SetFont('akira','',8);
        $this->SetTextColor(0,0,0);
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -1)',0,0,'C');
		$this->Ln();
         
	    foreach($physicalSkills as $key=> $skill)
        {
            $title = $skill;
            $tmp = $this->pj->getField('spe_tap_'.$key);
            if(!empty($tmp))
                $title.=': ('.$tmp.')';

            $this->Cell($nameSize,$height,$title);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tap_'.$key)),0,0,'C');
            $this->Ln();
        }
        $this->SetFont('goudy','',14);
        $this->SetTextColor(0,150,0);
        $this->Cell($nameSize+$valueSize,$height,'Social',0,0,'C');
        $this->Ln();

        $this->SetFont('akira','',8);
        $this->SetTextColor(0,0,0);     
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -1)',0,0,'C');
		$this->Ln();

		foreach($socialSkills as $key=> $skill)
        {
            $title = $skill;
            $tmp = $this->pj->getField('spe_tas_'.$key);
            if(!empty($tmp))
                $title.=': ('.$tmp.')';

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
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
		$this->Cell($widthName+$widthValue,$height,'Santé',0,0,'C');
		$this->Ln();
		$this->SetFont('akira','',10);
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
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
		$this->Cell($widthName+$widthValue,$height,'Volonté',0,0,'C');
		$this->Ln();
		$max=8;
		$volonte=$this->pj->getField('mvolonte');
//		echo $volonte," doheo";
		if($volonte>$max)
			$max=$volonte;
		
		$this->SetFont('akira','',10);
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
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
		$this->Cell($widthName,$height,'Glamour',0,0,'C');
		$max = 10;
		$this->Ln();
		$this->SetFont('akira','',10);
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

		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
        $this->Cell($widthName,$height,'Clarity',0,0,'C');
        $this->Ln();
        $this->SetFont('akira','',10);
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
        $length=$this->GetStringWidth('Experience:');
        $this->Ln();
        $this->Cell($length,$height,'Taille:',0,0,'L');
        $this->Cell($widthName-$length,$height,''.($this->pj->getField('hand_taille')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,'Vitesse:',0,0,'L');
        $this->Cell($widthName-$length,$height,''.($this->pj->getField('at_dex')+$this->pj->getField('at_force')+$this->pj->getField('hand_taille')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,'Defense:',0,0,'L');
        $this->Cell($widthName-$length,$height,''.min($this->pj->getField('at_dex'),$this->pj->getField('at_ast')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,'Armure:',0,0,'L');
        $this->Cell($widthName-$length,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,'Initiative:',0,0,'L');
        $this->Cell($widthName-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_dex')),'B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,'Experience:',0,0,'L');
        $this->Cell($widthName-$length,$height,'','B',0,'L');

    }
	function displayBloodPotency()
	{
		$height=5;
		$widthName=58;
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
		$this->Cell($widthName,$height,'Wyrd',0,0,'C');
		$max = 10;
		$this->Ln();
		$this->SetFont('akira','',10);
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
		
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
		$this->Cell($widthName+$widthValue,$height,'Contrats',0,0,'C');
		$this->Ln();
		
		$this->SetFont('akira','',8);
		$this->SetTextColor(0,0,0);
		$i=0;
	        $tmp=$this->pj->getField('pw_'.$i);
        	while(!empty($tmp)||($i<5))
		{
		    $tmp_val=$this->pj->getField('pw_val_'.$i);	
			if(!empty($tmp_val))
			{
		            	$length=$this->GetStringWidth(digitToRound($this->pj->getField('pw_val_'.$i)));
				$this->Cell($widthName-$length,$height,$this->contratList[$this->pj->getField('pw_'.$i)],'B');
				$this->Cell($length,$height,digitToRound($this->pj->getField('pw_val_'.$i)));
				$this->Ln();
			}
	            $i++;
        	    $tmp=$this->pj->getField('pw_'.$i);
		}
		$this->Ln();

		$widthName=58;
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
		$this->Cell($widthName,$height,'Handicaps',0,0,'C');
		$this->Ln();
		$this->SetFont('akira','',8);
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
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
		$this->Cell($widthName,$height,'Équipement',0,0,'C');
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
		
		
		$this->SetFont('goudy','',16);
		$this->SetTextColor(0,150,0);
        $this->Cell(1,$height,'',0,0,'C');
	    $this->Cell($widthName,$height,'Autres traits','B',0,'C');
        $this->Ln();	
        $this->Ln();	
        $widthName=58;
		
		$this->Cell($widthName,$height,'Atouts',0,0,'C');
		$myY= $this->getY();
		$myX= $this->getX();
		$this->Ln();
		
		$this->SetFont('akira','',8);
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
            $this->Cell($widthName,$height,$this->advantageList[$this->pj->getField('av_'.$i)],'B');
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


$pdf->SetTitle('Fiche de personnage: '.$char->getField('name'),true);
$pdf->SetAuthor('Renaud Guezennec',true);
$pdf->SetCreator('Tenebrae - www.tenebrae-mundis.com',true);

$pdf->setPj($char);

$pdf->SetMargins(0,0,0);
$pdf->AddFont('goudy','','goudy.ttf',true);

//$pdf->AddFont('akira','','CtL/AKIRA___.ttf',true);
$pdf->AddFont('akira','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('casab','','CtL/CASAB.TTF',true);
$pdf->AddFont('frankent','','CtL/FRANKENT.TTF',true);
$pdf->AddFont('kendo','','CtL/KendoITC.ttf',true);
//$pdf->AddFont('rackhamita','','CtL/RackhamItalic.pfb',true);
//$pdf->AddFont('rackham','','CtL/Rackham.pfb',true);
$pdf->AddFont('ruben','','CtL/ruben___.TTF',true);
$pdf->AddFont('solemnit','','CtL/SOLEMNIT.TTF',true);
//$pdf->AddFont('univers0','','CtL/UNIVERS0.TTF',true);
//$pdf->AddFont('burnth59','','CtL/Burnth59.pfm',true);
$pdf->AddFont('chanltun','','CtL/CHANLTUN.TTF',true);
$pdf->AddFont('gad','','CtL/gad.ttf',true);
//$pdf->AddFont('pisan','','CtL/PISAN.TTF',true);
//$pdf->AddFont('rackamita2','','CtL/RackhamItalic.pfm',true);
//$pdf->AddFont('rackham2','','CtL/Rackham.pfm',true);
//$pdf->AddFont('scythe','','CtL/scythe.ttf',true);
//$pdf->AddFont('sonys','','CtL/sonys.ttf',true);
//$pdf->AddFont('zombie','','CtL/ZOMBIE.TTF',true);
//$pdf->SetFont('akira','',12);

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



//$myX2+=
//$myX+=$pdf->displayAtout($myX+$myX2,$myY);

$pdf->Output($char->getField('ig_name').'.pdf','D');

//◼ ◻ 


