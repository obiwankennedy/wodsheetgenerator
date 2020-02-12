<?php 
//include_once("../../session/session_lib.php");

define("_SYSTEM_TTFONTS", "/home/renaud/www/tenebrae/include/pdf/tfpdf/font/unifont/mta/");


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
	public $renomList;
	public $clanList;
	
    function Header()
    {
        $this->Image("data/mta/mtabg.jpg",0,0,210,300);
        $this->dsql = new driversql();
        $this->dsql->init();
		//$this->dsql->setDebug(true);
        
        $this->listAdvantages();
        $this->listvices();
        $this->listvertues();
		$this->listRenomme();
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
        $this->dsql->sendRequest('SELECT * from mta_order');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->ligueList[$line['id']]=$line['name'];
        }
    }
	function listClan()
    {
        $this->dsql->sendRequest('SELECT * from mta_path');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->clanList[$line['id']]=$line['name'];
        }
    }
	function listRenomme()
    {
        $this->dsql->sendRequest('SELECT * from lg_renomme');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->renomList[$line['id']]=$line['name'];
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
		
			
		$this->SetFont('GoudyStM','',16);
		
		$this->Cell(0,$height,'Attributs',0,0,'C');
		$this->Ln();	
		
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);

        $this->Cell(31,$height,'Intelligence');
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_int')));
        $this->Cell(31,$height,'Force');
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_force')));
        $this->Cell(31,$height,'Présence');
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_pre')));
        $this->Ln();

        $this->Cell(31,$height,'Astuce');
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_ast')));
        $this->Cell(31,$height,'Dextérité');
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_dex')));
        $this->Cell(31,$height,'Manipulation');
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_mani')));
        $this->Ln();


        $this->Cell(31,$height,'Résolution');
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_res')));
        $this->Cell(31,$height,'Vigueur');
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_vig')));
        $this->Cell(31,$height,'Calme');
        $this->Cell(31,$height,digitToRound($this->pj->getField('at_cal')));
        $this->Ln();
    }

    function displayInfo()
    {   
		$height=6;
		$nameSize=20;
		$valueSize=42;

		$this->SetFont('GoudyStM','',16);
		
        $this->Cell($nameSize,$height,'Nom');
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->pj->getField('ig_name'));
		$this->SetFont('GoudyStM','',16);
		
        $this->Cell($nameSize,$height,'Vertue');
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->vertuesList[$this->pj->getField('ig_vertue')]);
		$this->SetFont('GoudyStM','',16);
		
        $this->Cell($nameSize,$height,'Path');
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->clanList[$this->pj->getField('field_top')]);
        $this->Ln();


		$this->SetFont('GoudyStM','',16);
		
       $this->Cell($nameSize,$height,'Joueur');
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_player'));
		$this->SetFont('GoudyStM','',16);
		
       $this->Cell($nameSize,$height,'Vice');
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->vicesList[$this->pj->getField('ig_vice')]);
		$this->SetFont('GoudyStM','',16);
		
       $this->Cell($nameSize,$height,'Order');
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->ligueList[$this->pj->getField('field_middle')]);
       $this->Ln();

		$this->SetFont('GoudyStM','',16);
		
       $this->Cell($nameSize,$height,'Chronique');
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,'');
		$this->SetFont('GoudyStM','',16);
		
       $this->Cell($nameSize,$height,'Concept');
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_concept'));
		$this->SetFont('GoudyStM','',16);
		
       $this->Cell($nameSize,$height,'Cabal');
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('field_bottom'));
       $this->Ln();
       $this->Ln();
	$this->Line($this->getX(),$this->getY(),$this->getX()+170,$this->getY());    
}
	function displayTalent()
	{
		
		$height=5;
		$nameSize=35;
		$valueSize=14;
		
        $mentalSkills=array('Artisanat','Erudition','Informatique','Investigation','Medecine','Occultisme','Politique','Science');
        $physicalSkills=array('Armes Blanches','Armes à Feu','Athlétisme','Bagarre','Conduite','Furtivité','Larcin','Survie');
        $socialSkills=array('Animaux','Empathie','Expression','Intimidation','Persuasion','Relationnel','Sag. de la Rue','Subterfuge');		

	$this->Line($this->getX(),$this->getY(),$this->getX()+170,$this->getY());    
		$this->SetFont('GoudyStM','',16);
		
		$this->Cell(($nameSize+$valueSize),$height,'Talents',0,0,'C');
		

		$myY= $this->getY();
        $myX= $this->getX();
		$this->Ln();
        $this->Ln();
		$this->SetFont('GoudyStM','',14);
		$this->Cell($nameSize+$valueSize,$height,'Mental',0,0,'C');
        $this->Ln(); 
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);		
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -3)',0,0,'C');
		$this->Ln();
		$this->Line($this->getX()+$nameSize+$valueSize+1,$this->getY()-15,$this->getX()+$nameSize+$valueSize+1,$this->getY()+155);
		
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $lengthSquare=$this->GetStringWidth('◻');
         $this->SetFont('DejaVu','',8);
	    foreach($mentalSkills as $key=> $skill)
        {
            $title = $skill;
            $spe=$this->pj->getField('spe_tam_'.$key);
            if(!empty($spe))
                $title.=': ('.$spe.')';
                
            $valueSize   = $this->GetStringWidth(digitToRound($this->pj->getField('tap_'.$key)));    
            $this->Cell($lengthSquare,$height,'◻');
            $length=$this->GetStringWidth($title);
            
            $this->SetFont('DejaVu','',8);
            $this->Cell($length,$height,$title);
            $this->Cell($nameSize-$length-$lengthSquare,$height,'','B',0,'C');
            
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tam_'.$key)),0,0,'C');
            $this->Ln();
        }
     	$this->SetFont('GoudyStM','',14);
		
		$this->Cell($nameSize+$valueSize,$height,'Physique',0,0,'C');
        $this->Ln();
		$this->SetFont('DejaVu','',8);
        $this->SetTextColor(0,0,0);
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -1)',0,0,'C');
		$this->Ln();
         
	    foreach($physicalSkills as $key=> $skill)
        {
            $title = $skill;
            $spe=$this->pj->getField('spe_tap_'.$key);
           if(!empty($spe))
                $title.=': ('.$spe.')';

            
            $this->Cell($lengthSquare,$height,'◻');
            $length=$this->GetStringWidth($title);
            
            $this->SetFont('DejaVu','',8);
            $this->Cell($length,$height,$title);
            $this->Cell($nameSize-$length-$lengthSquare,$height,'','B',0,'C');
            
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tap_'.$key)),0,0,'C');
            $this->Ln();
        }
        $this->SetFont('GoudyStM','',14);
        
        $this->Cell($nameSize+$valueSize,$height,'Social',0,0,'C');
        $this->Ln();

        $this->SetFont('DejaVu','',8);
        $this->SetTextColor(0,0,0);     
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -1)',0,0,'C');
		$this->Ln();

		foreach($socialSkills as $key=> $skill)
        {
            $title = $skill;
            $spe=$this->pj->getField('spe_tas_'.$key);
            if(!empty($spe))
                $title.=':('.$spe.')';


            
            $this->Cell($lengthSquare,$height,'◻');
            $length=$this->GetStringWidth($title);
            
            $this->SetFont('DejaVu','',8);
            $this->Cell($length,$height,$title);
            $this->Cell($nameSize-$length-$lengthSquare,$height,'','B',0,'C');
            
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tas_'.$key)),0,0,'C');
            $this->Ln();
        }

		$myY2= $this->getY();
		$myX2= $this->getX();
        $this->displayAtout($myX,$myY);
		
		
		$this->Ln();
		return $myY;
	}
	function displaySante($X,$Y)
	{
		$this->SetLeftMargin($X+5);
		$this->SetX($X);
		$this->SetY($Y);
        $this->Ln();
        $this->Ln();	
		$height=5;
		$widthName=28;
		$widthValue=30;
		$this->SetFont('GoudyStM','',16);
		
		$this->Cell($widthName+$widthValue,$height,'Santé','B',0,'C');
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
		$this->SetLeftMargin($X+5);
		$this->displayVolonte();
	}
	function displayVolonte()
	{
		$height=5;
		$widthName=28;
		$widthValue=30;
		$this->SetFont('GoudyStM','',16);
		
		$this->Cell($widthName+$widthValue,$height,'Volonté',0,0,'C');
		$this->Ln();
		$max=8;
		$volonte=$this->pj->getField('mvolonte');
		//echo $volonte," doheo";
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
        
		$this->displayMana();
	}

	function displayMana()
	{
		$height=5;
		$widthName=28;
		$widthValue=30;
		$this->SetFont('GoudyStM','',16);
		
		$this->Cell($widthName+$widthValue,$height,'Mana',0,0,'C');
		$max = 10;
		$this->Ln();
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
		
		$vitae=$this->pj->getField('menergy');
		if($vitae>$max)
			$max=$vitae;
			
		$size=($widthName+$widthValue)/$max;
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
        
		$this->displayGnosis();
	}
    function displayWisdom()
    {
        $height=5;
        $widthName=20;
        $widthValue=22;

		$this->SetFont('GoudyStM','',16);
		
		$this->Cell(58,$height,'Wisdom',0,0,'C');
        $this->Ln();
        $this->SetFont('DejaVu','',10);
        $this->SetTextColor(0,0,0);
		$volonte=$this->pj->getField('mmoral');
        for($i=10;$i>0;$i--)
        {
            $this->Cell($height,$height,$i.' ',0,0,'C');
            $this->Cell($widthName+$widthValue,$height,'','B',0,'C');
			if($volonte==$i)
				$this->Cell($height,$height,'●',0,0,'C');
			else 
				$this->Cell($height,$height,'○',0,0,'C');

            $this->Ln();

        }
    $this->displayArmure();
    }
	

	function displayGnosis()
	{
		$height=5;
		$widthName=28;
		$widthValue=30;
		$this->SetFont('GoudyStM','',16);
		
		$this->Cell($widthName+$widthValue,$height,'Gnosis',0,0,'C');
		$max = 10;
		$this->Ln();
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
		
		$bp=$this->pj->getField('mindex');
		if($bp>$max)
			$max=$bp;
			
		//echo " fzefjzb",$bp;
		$size=($widthName+$widthValue)/$max;
		for($i=0;$i<$max;$i++)
		{
			if($i<$bp)
				$line2='●';
			else
				$line2='○';
				
			$this->Cell($size,$height,$line2,0,0,'C');
		}
		$this->Ln();
		$this->displayWisdom();
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

	function displayArmure()
	{
		
		$height=7;
		$widthName=58;
		
		$this->Ln();
		$this->SetFont('GoudyStM','',16);
		
		$this->Cell($widthName,$height,'Armure',0,0,'C');
		$this->Ln();
        $this->SetFont('DejaVu','',8);
        $this->Cell($widthName/2,$height,'Type',0,0,'L');
		$this->Cell($widthName/2,$height,'Points',0,0,'R');
        $this->Ln();
        $this->Cell($widthName,$height,'','B',0,'R');
        $this->Ln();
        $this->SetFont('GoudyStM','',16);
        $this->Cell($widthName,$height,'Protective Spells',0,0,'C');
		$this->Ln();
        $this->SetFont('DejaVu','',8);
        $this->Cell($widthName/2,$height,'Name',0,0,'L');
		$this->Cell($widthName/2,$height,'Points',0,0,'R');
        $this->Ln();
        $this->Cell($widthName,$height,'','B',0,'R');
        $this->Ln();
        $this->Cell($widthName,$height,'','B',0,'R');
        $this->Ln();  
	}
	function displayhandicap()
	{
		$widthName=55;
		
		$height=5;
		$this->SetFont('GoudyStM','',16);
		
		$this->Cell($widthName,$height,'Handicaps',0,0,'C');
		$this->Ln();
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);

		$length=$this->GetStringWidth($handicap);
		$tab=str_split($handicap,50);
		$this->Cell($widthName,$height,$tab[0],'B',0,'C');
		$this->Ln();
		
		$this->Cell($widthName,$height,$tab[1],'B',0,'C');
		$this->Ln();
		$this->Cell($widthName,$height,$tab[2],'B',0,'C');
		$this->Ln();
		

		$this->infoGenerales();
		
	}
	function infoGenerales()
	{
		$height=5;
		$this->Ln();
		$widthName=55;

		//$this->SetFont('GoudyStM','',12);
		$this->SetFont('DejaVu','',8);
        
        $length=$this->GetStringWidth('Taille');
		$this->Cell($length,$height,'Taille',0,0,'C');
		$this->Cell($widthName-$length,$height,$this->pj->getField('hand_taille'),'B',0,'C');
		$this->Ln();
        
        $length=$this->GetStringWidth('Defense');
		$this->Cell($length,$height,'Défense',0,0,'C');
		$this->Cell($widthName-$length,$height,$this->pj->getField('hand_def'),'B',0,'C');
		$this->Ln();
        
        $length=$this->GetStringWidth('Initiative');
		$this->Cell($length,$height,'Initiative',0,0,'C');
		$this->Cell($widthName-$length,$height,$this->pj->getField('hand_init'),'B',0,'C');
		$this->Ln();
        
        $length=$this->GetStringWidth('Vitesse');
		$this->Cell($length,$height,'Vitesse',0,0,'C');
		$this->Cell($widthName-$length,$height,$this->pj->getField('hand_vitesse'),'B',0,'C');
		$this->Ln();
        
        $length=$this->GetStringWidth('Expérience');
		$this->Cell($length,$height,'Expérience',0,0,'C');
		$this->Cell($widthName-$length,$height,'','B',0,'C');
		$this->Ln();
    
		
		$this->displayArcana();
	}
	function displayArcana()
	{
		$height=5;
		$this->Ln();
		$widthName=55;

		$this->SetFont('GoudyStM','',16);
		
		$this->Cell($widthName,$height,'Arcana',0,0,'C');
		$this->Ln();
		$this->SetFont('DejaVu','',8);
        $this->dsql->sendRequest('select * from me_sphere;');
        
        while(  $this->dsql->res_tab_assoc($line))
        {
            $length=$this->GetStringWidth($line['name']);
            $length2=$this->GetStringWidth('●●●●●');
            $this->Cell($length,$height,$line['name'],0,0,'C');
            $this->Cell($widthName-$length-$length2,$height,'','B',0,'B');
            $this->Cell($length2,$height,digitToRound($this->pj->getField('pw_val_'.($line['id']-1))),0,0,'B');
            $this->Ln();
        }
		
	}
	function displayAtout($X,$Y)
	{
		
		$height=5;
        $this->SetLeftMargin($X+2);
		$this->SetX($X);
		$this->SetY($Y);
		$widthName=37;
		$widthValue=16;
		
		
		$this->SetFont('GoudyStM','',16);
		
        $this->Cell(1,$height,'',0,0,'C');
	    $this->Cell(($widthName+$widthValue)*2+10,$height,'Autres traits',0,0,'C');
        $this->Ln();	
        $this->Ln();
		
		$this->Cell($widthName+$widthValue,$height,'Atouts',0,0,'C');
		$myY= $this->getY();
		$myX= $this->getX();
		$this->Ln();
		
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);
//        echo $this->pj->getCountSpec();
        $i=0;
        $tmp=$this->pj->getField('av_'.$i);
        while(!empty($tmp)||($i<9))
        {
            $this->Cell($widthName,$height,$this->advantageList[$this->pj->getField('av_'.$i)],'B');
            $this->Cell($widthValue,$height,digitToRound($this->pj->getField('av_val_'.$i)));
            $this->Ln();
            $i++;
            $tmp=$this->pj->getField('av_'.$i);

        }
        $this->Ln();
		$this->displayhandicap();
//        $this->displayDiscipline($this->getX(),$this->getY());
		$this->displaySante($myX,$Y);
    	return $widthName+$widthValue;
	}

    function displayDons($X,$Y)
    {
       $this->SetLeftMargin($X+5);
       $this->setY($Y); 
//       $this->setXmargin($X);
        $width=120;
        $height=5;
        $this->SetFont('GoudyStM','',14);
		$this->Cell($width,$height,'Rotes','0',0,'C');
        $this->Ln();

        $this->SetFont('DejaVu','',10);
        $length1 = 12;
        $this->Cell($length1,$height,'Dots',0,0,'L');
        $length2 = 22;
        $this->Cell($length2+2,$height,'Arcana',0,0,'L');
        $length3 = 51;
        $this->Cell($length3,$height,'Name',0,0,'L');
        $length4 = 22;
        $this->Cell($length4,$height,'Dice Pool',0,0,'L');
        $length5 = 12;
        $this->Cell($length5,$height,'Page #',0,0,'R');
        $this->Ln();
        
        
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        
        
        $this->SetFont('GoudyStM','',14);
		$this->Cell($width,$height,'Weapons','0',0,'C');
        $this->Ln();
        
        
        $this->SetFont('DejaVu','',10);
        $length1 = 44;
        $this->Cell($length1,$height,'Type',0,0,'L');
        $length2 = 33;
        $this->Cell($length2,$height,'Damage Range',0,0,'L');
        $length3 = 16;
        $this->Cell($length3,$height,'Clip',0,0,'L');
        $length4 = 16;
        $this->Cell($length4,$height,'Size',0,0,'L');
        $length5 = 12;
        $this->Cell($length5,$height,'Special',0,0,'L');
        $this->Ln();
                     $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        
        
        $this->SetFont('GoudyStM','',14);

		$this->Cell($width,$height,'Enchanted Items','0',0,'C');
        $this->Ln();

        $this->SetFont('DejaVu','',10);
        $this->Cell(33,$height,'Type',0,0,'L');
       

        $this->Cell(53,$height,'Power',0,0,'L');
        $length3 = $this->GetStringWidth('Dice Pool');
        $this->Cell(22,$height,'Dice Pool',0,0,'L');
        $length4 = $this->GetStringWidth('Mana');
        
        $this->Cell(12,$height,'Mana',0,0,'L');
        $this->Ln();

        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        
        $this->SetFont('GoudyStM','',14);
        $length1 = 15;
		$this->Cell($width,$height,'Equipement','0',0,'C');
        $this->Ln();

        $this->SetFont('DejaVu','',10);
        $this->Cell($width/2,$height,'Type',0,0,'L');
        $this->Cell($width/2,$height,'Dice Mod.',0,0,'R');
        $this->Ln();
        
                $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        
        
        $this->SetFont('GoudyStM','',14);
        $length1 = 15;
		$this->Cell($width,$height,'Familiar','0',0,'C');
        $this->Ln();
        
        $width=50;
        $this->SetFont('DejaVu','',10);
                
        $length4 = $this->GetStringWidth('Type:');
        $this->Cell($length4,$height,'Type:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
                $this->Cell(10,$height,'',0,0,'C');
        $length4 = $this->GetStringWidth('Size:');
        $this->Cell($length4,$height,'Size:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Ln();
        
        $length4 = $this->GetStringWidth('Description:');
        $this->Cell($length4,$height,'Description:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
                $this->Cell(10,$height,'',0,0,'C');
        $length4 = $this->GetStringWidth('Influence:');
        $this->Cell($length4,$height,'Influence:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Ln();

        $length4 = 0;
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Cell(10,$height,'',0,0,'C');
                
        $this->Cell($width/2,$height,'Numina',0,0,'L');
        $this->Cell($width/2,$height,'Cost',0,0,'R');
        $this->Ln();
        
         $length4 = 0;
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Cell(10,$height,'',0,0,'C');
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Ln();
        
        
         $length4 = $this->GetStringWidth('Power:');
        $this->Cell($length4,$height,'Power:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
         $this->Cell(10,$height,'',0,0,'C');
        $length4 = 0;
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Ln();
        
             $length4 = $this->GetStringWidth('Finesse:');
        $this->Cell($length4,$height,'Finesse:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
         $this->Cell(10,$height,'',0,0,'C');
        $length4 = 0;
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Ln();
        
                $length4 = $this->GetStringWidth('Resistance:');
        $this->Cell($length4,$height,'Resistance:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
                $this->Cell(10,$height,'',0,0,'C');
        $length4 = $this->GetStringWidth('Ban:');
        $this->Cell($length4,$height,'Ban:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Ln();
        
        
        
        $length4 = $this->GetStringWidth('Skills:');
        $this->Cell($length4,$height,'Skills:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Cell(10,$height,'',0,0,'C');
        $length4 = $this->GetStringWidth('Corpus/Health');
        $this->Cell($width,$height,'Corpus/Health',0,0,'C');
        $this->Ln();
        
        $length4 = 0;
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Cell(10,$height,'',0,0,'C');
        for($i = 0; $i < 15; $i++)
        {
                    $this->Cell($width/15,$height,'○',0,0,'C');
        }
        $this->Ln();
        
                $length4 = 0;
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Cell(10,$height,'',0,0,'C');
        $this->SetFont('DejaVu','',11);
        for($i = 0; $i < 15; $i++)
        {
                    $this->Cell($width/15,$height,'◻',0,0,'C');
        }
        //$this->Cell($width-$length4,$height,'◻◻◻◻◻◻◻◻◻◻◻◻◻◻◻',0,0,'C');
        $this->SetFont('DejaVu','',10);
        $this->Ln();
        
        
        
        
                $length4 = $this->GetStringWidth('Intiative:');
        $this->Cell($length4,$height,'Intiative:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Cell(10,$height,'',0,0,'C');
        $length4 = $this->GetStringWidth('Willpower');
        $this->Cell($width,$height,'Willpower',0,0,'C');
        $this->Ln();
        
        
        
         $length4 = $this->GetStringWidth('Defense:');
        $this->Cell($length4,$height,'Defense:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Cell(10,$height,'',0,0,'C');
        for($i = 0; $i < 10; $i++)
        {
                    $this->Cell($width/10,$height,'○',0,0,'C');
        }
        $this->Ln();
        
        $length4 = $this->GetStringWidth('Speed:');
        $this->Cell($length4,$height,'Speed:',0,0,'L');
        $this->Cell($width-$length4,$height,'','B',0,'C');
        $this->Cell(10,$height,'',0,0,'C');
        for($i = 0; $i < 10; $i++)
        {
                    $this->Cell($width/10,$height,'◻',0,0,'C');
        }
        $this->Ln();
        


        $this->Cell($width+10,$height,'',0,0,'C');
        $length4 = $this->GetStringWidth('Essence');
        $this->Cell($width,$height,'Essence',0,0,'C');
        $this->Ln();

        $this->Cell($width+10,$height,'',0,0,'C');
        for($i = 0; $i < 10; $i++)
        {
                    $this->Cell($width/10,$height,'◻',0,0,'C');
        }
        $this->Ln();
        
    }
    function displayTotem()
    {
        $this->SetLeftMargin(20);
		$this->SetX(5);
        
        $this->Ln();
        $width=50;
        $Y = $this->getY();

        $height=5;
        $this->SetFont('GoudyStM','',14);
	
        $this->Cell($width,$height,'Active Spells',0,0,'C');
        $X = $this->getX();
        $this->Ln();
        
        $this->SetFont('DejaVu','',7);
        $this->Cell($width,$height,'Max = Gnosis + 3',0,0,'C');
        $this->Ln();
        $this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        
        
        $this->SetFont('GoudyStM','',14);
                $this->Ln();
                $this->Ln();
	    $this->Cell($width,$height,'Spells Cast',0,0,'C');
        $this->Ln();
        $this->Cell($width,$height,'Upon Self',0,0,'C');
        $this->Ln();
        
        $this->SetFont('DejaVu','',7);
        $this->Cell($width,$height,'Spell tolerance = Vigueur;',0,0,'C');
        $this->Ln();
        $this->Cell($width,$height,'(-1 dice per extra spell)',0,0,'C');
        $this->Ln();
        $this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        
        
         $this->SetFont('GoudyStM','',14);
                $this->Ln();
                $this->Ln();
	    $this->Cell($width,$height,'Nimbus',0,0,'C');
        $this->Ln();       
        $this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');


        
        $this->SetFont('GoudyStM','',14);
                $this->Ln();
                $this->Ln();
	    $this->Cell($width,$height,'Paradox Marks',0,0,'C');
        $this->Ln(); 
        $this->SetFont('DejaVu','',8);
        $length = $this->GetStringWidth('Bedlam:');
        $this->Cell($length,$height,'Bedlam:',0,0,'L');
        $this->Cell($width-$length,$height,'','B',0,'C');
        $this->Ln(); 
        $length = $this->GetStringWidth('Brand:');
        $this->Cell($length,$height,'Brand:',0,0,'L');
        $this->Cell($width-$length,$height,'','B',0,'C');
        
                $this->SetFont('GoudyStM','',14);
                $this->Ln();
                $this->Ln();
	    $this->Cell($width,$height,'Dedicated',0,0,'C');
        $this->Ln();
        $this->Cell($width,$height,'Magical Tool',0,0,'C');
        $this->Ln();
        
        $this->SetFont('DejaVu','',8);
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
         $length = $this->GetStringWidth('Arcana Based Tools:');
        $this->Cell($length,$height,'Arcana Based Tools:',0,0,'L');
        $this->Cell($width-$length,$height,'','B',0,'C');
        $this->Ln(); 
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
       
        
        $this->SetFont('GoudyStM','',14);
                        $this->Ln();
                $this->Ln();
	    $this->Cell($width,$height,'Expérience',0,0,'C');
        $this->Ln();
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
                        $this->Ln();
                $this->Ln();
        $this->SetFont('GoudyStM','',14);
	    $this->Cell($width,$height,'Arcana Expérience',0,0,'C');
        $this->Ln();
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
        $this->Ln();
        
	$this->Line($X+2,$Y+2,$X+2,$this->getY());
    $this->displayDons($X,$Y);
    }

}
$pdf=new PDF();



$pdf->SetTitle('Fiche de personnage: '.$char->getField('name'),true);
$pdf->SetAuthor('Renaud Guezennec',true);
$pdf->SetCreator('Tenebrae - www.tenebrae-mundis.com',true);

$pdf->setPj($char);

$pdf->SetMargins(0,0,0);
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('GoudyStM','','goudy.ttf',true);


$pdf->SetFont('DejaVu','',12);

$pdf->SetMargins(20,20);
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);


$pdf->displayInfo();

$myX=$pdf->getX();
$pdf->displayAttribut();
$pdf->displayTalent();

$pdf->jumpSection();

$myY=$pdf->getY();



$pdf->AddPage();

$pdf->displayTotem();







//$pdf->Output($char->getField('ig_name').'.pdf','D');
$pdf->Output();
//◼ ◻ 


