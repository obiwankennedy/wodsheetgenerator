<?php 
//include_once("../../session/session_lib.php");

define("_SYSTEM_TTFONTS", "/home/renaud/www/tenebrae/include/pdf/tfpdf/font/unifont/wtf/");


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
        $this->Image("data/wtf/bg.jpg",0,0,210,300);
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
        $this->dsql->sendRequest('SELECT * from lg_tribu');
        while($this->dsql->res_tab_assoc($line))
        {
            $this->ligueList[$line['id']]=$line['name'];
        }
    }
	function listClan()
    {
        $this->dsql->sendRequest('SELECT * from lg_auspice');
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
		
			
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell(0,$height,'Attributs',0,0,'C');
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
		$this->Image("data/wtf/logo.jpg",80,Null,60,20); 
		$height=6;
		$nameSize=20;
		$valueSize=42;

		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
        $this->Cell($nameSize,$height,tr('Nom'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->pj->getField('ig_name'));
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
        $this->Cell($nameSize,$height,tr('Vertue'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->vertuesList[$this->pj->getField('ig_vertue')]);
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
        $this->Cell($nameSize,$height,tr('Auspice'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($valueSize,$height,$this->clanList[$this->pj->getField('field_top')]);
        $this->Ln();


		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
       $this->Cell($nameSize,$height,tr('Joueur'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_player'));
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
       $this->Cell($nameSize,$height,tr('Vice'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->vicesList[$this->pj->getField('ig_vice')]);
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
       $this->Cell($nameSize,$height,tr('Tribu'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->ligueList[$this->pj->getField('field_middle')]);
       $this->Ln();

		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
       $this->Cell($nameSize,$height,tr('Chronique'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,'');
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
       $this->Cell($nameSize,$height,tr('Concept'));
		$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
       $this->Cell($valueSize,$height,$this->pj->getField('ig_concept'));
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
       $this->Cell($nameSize,$height,tr('Loge'));
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
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell(($nameSize+$valueSize),$height,tr('Talents'),0,0,'C');
		

		$myY= $this->getY();
        $myX= $this->getX();
		$this->Ln();
$this->Ln();
		$this->SetFont('Treefrog','',14);
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
            $spe=$this->pj->getField('spe_tam_'.$key);
            if(!empty($spe))
                $title.=': ('.tr($spe).')';

            $this->Cell($nameSize,$height,$title);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tam_'.$key)),0,0,'C');
            $this->Ln();
        }
     	$this->SetFont('Treefrog','',14);
		$this->SetTextColor(132,91,75);
		$this->Cell($nameSize+$valueSize,$height,'Physique',0,0,'C');
        $this->Ln();
		$this->SetFont('DejaVu','',8);
        $this->SetTextColor(0,0,0);
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -1)',0,0,'C');
		$this->Ln();
         
	    foreach($physicalSkills as $key=> $skill)
        {
            $title = tr($skill);
            $spe=$this->pj->getField('spe_tap_'.$key);
           if(!empty($spe))
                $title.=': ('.tr($spe).')';

            $this->Cell($nameSize,$height,$title);
            $this->Cell($valueSize,$height,digitToRound($this->pj->getField('tap_'.$key)),0,0,'C');
            $this->Ln();
        }
        $this->SetFont('Treefrog','',14);
        $this->SetTextColor(132,91,75);
        $this->Cell($nameSize+$valueSize,$height,'Social',0,0,'C');
        $this->Ln();

        $this->SetFont('DejaVu','',8);
        $this->SetTextColor(0,0,0);     
		$this->cell($nameSize+$valueSize,$height,'(Incompétent -1)',0,0,'C');
		$this->Ln();

		foreach($socialSkills as $key=> $skill)
        {
            $title = tr($skill);
            $spe=$this->pj->getField('spe_tas_'.$key);
            if(!empty($spe))
                $title.=':('.tr($spe).')';

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
		$this->SetLeftMargin($X+5);
		$this->SetX($X);
		$this->SetY($Y);
        $this->Ln();
        $this->Ln();	
		$height=5;
		$widthName=28;
		$widthValue=30;
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell($widthName+$widthValue,$height,tr('Sante'),'B',0,'C');
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
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell($widthName+$widthValue,$height,tr('Volonte'),0,0,'C');
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
        
		$this->displayEssence();
	}

	function displayEssence()
	{
		$height=5;
		$widthName=28;
		$widthValue=30;
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell($widthName+$widthValue,$height,tr('Essence'),0,0,'C');
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
        
		$this->displayPrimalCall();
	}
    function displayHarmony()
    {
        $height=5;
        $widthName=20;
        $widthValue=22;

		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell(58,$height,tr('Harmonie'),0,0,'C');
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
    
        //$this->displayGenericInformation();
		$this->displayRenom();
    }
	
	/*function displayRenom()
	{
		
	}*/
    function displayGenericInformation()
    {
        $height=5;
        $widthName=28;
        $widthValue=30;
        $length=$this->GetStringWidth(tr('Experience:'));
        $this->Ln();
        $this->Cell($length,$height,tr('Taille:'),0,0,'L');
        $this->Cell($widthName+$widthValue-$length,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Vitesse:'),0,0,'L');
        $this->Cell($widthName+$widthValue-$length,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Defense:'),0,0,'L');
        $this->Cell($widthName+$widthValue-$length,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Armure:'),0,0,'L');
        $this->Cell($widthName+$widthValue-$length,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Initiative:'),0,0,'L');
        $this->Cell($widthName+$widthValue-$length,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($length,$height,tr('Experience:'),0,0,'L');
        $this->Cell($widthName+$widthValue-$length,$height,'','B',0,'L');

    }
	function displayPrimalCall()
	{
		$height=5;
		$widthName=28;
		$widthValue=30;
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell($widthName+$widthValue,$height,tr('Instinct Primal'),0,0,'C');
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
		$this->displayHarmony();
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

	function displayRenom()
	{
		
		/*$height=7;
		$widthName=58;
		
		$this->Ln();
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell($widthName,$height,'Renomme',0,0,'C');
		$this->Ln();
		
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);
		$i=0;
        $tmp=$this->pj->getField('pw_'.$i);
		$length=$this->GetStringWidth('○○○○○');
        foreach($this->renomList as $key=>$value)
		{
			$this->Cell($widthName-$length,$height,$value,'B');
			$this->Cell($length,$height,digitToRound($this->pj->getField('pw_val_'.$i)));
			$this->Ln();
            $i++;
            $tmp=$this->pj->getField('pw_'.$i);
		}
		$this->Ln();*/
         $height=7;
		$widthName=58;
		
		$this->Ln();
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell($widthName,$height,tr('Renomme'),0,0,'C');
		$this->Ln();
		
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);
		$i=0;
	        $tmp=$this->pj->getField('pw_'.$i);
		
		$length=$this->GetStringWidth('○○○○○');
        foreach($this->renomList as $key=>$value)
		{
			$this->Cell($widthName-$length,$height,tr($value),'B');
			$renom=$this->pj->getRenom($key);
			$score=(empty($renom['value']))?0:$renom['value'];
			$this->Cell($length,$height,digitToRound($score));
			$this->Ln();
            $i++;
            $tmp=$this->pj->getField('pw_'.$i);
		}
		$this->Ln();
	}
	function displayhandicap()
	{
		$widthName=55;
		
		$height=5;
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell($widthName,$height,tr('Handicaps'),0,0,'C');
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
		

		$this->displayAttack();
		
	}
	function displayAttack()
	{
		$height=5;
		$this->Ln();
		$widthName=55;

		$this->SetFont('Treefrog','',12);
		$this->SetTextColor(132,91,75);
		$this->Cell($widthName/2,$height,tr('Attaque'),0,0,'L');
		$this->Cell($widthName/2,$height,tr('Modificateurs'),0,0,'R');
		$this->Ln();
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);
		$this->Cell($widthName/2,$height,tr('Morsure'),0,0,'L');
		$this->Cell($widthName/2,$height,tr('(Gauru+2)'),0,0,'R');
		$this->Ln();
		$this->Cell($widthName/2,$height,tr('Griffes'),0,0,'L');
		$this->Cell($widthName/2,$height,tr('(Gauru+1)'),0,0,'R');
		$this->Ln();
		
		$this->Cell($widthName,$height,"",'B',0,'C');
		$this->Ln();
		
		$this->Cell($widthName,$height,"",'B',0,'C');
		$this->Ln();
		
		$this->Cell($widthName,$height,"",'B',0,'C');
		$this->Ln();
		
		$this->Cell($widthName,$height,"",'B',0,'C');
		$this->Ln();
		
		$this->Cell($widthName,$height,"",'B',0,'C');
		$this->Ln();
		
				$this->Cell($widthName,$height,"",'B',0,'C');
		$this->Ln();
		
		$this->displayEquipment();
	}
	function displayEquipment()
	{
		$height=5;
		$this->Ln();
		$widthName=55;

		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$this->Cell($widthName,$height,tr('Equipement'),0,0,'C');
		$this->Ln();
		
		$this->Cell($widthName,$height,'','B');
		//$this->Cell($height,$height,'');
		//$this->Cell($widthValue,$height,'','B');
		$this->Ln();
		$this->Cell($widthName,$height,'','B');
		//$this->Cell($height,$height,'');
		//$this->Cell($widthValue,$height,'','B');
		$this->Ln();
		$this->Cell($widthName,$height,'','B');
	//$this->Cell($height,$height,'');
		//$this->Cell($widthValue,$height,'','B');
		
	}
	function displayAtout($X,$Y)
	{
		
		$height=5;
        $this->SetLeftMargin($X+2);
		$this->SetX($X);
		$this->SetY($Y);
		$widthName=37;
		$widthValue=16;
		
		
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
        $this->Cell(1,$height,'',0,0,'C');
	    $this->Cell(($widthName+$widthValue)*2+10,$height,tr('Autres traits'),0,0,'C');
        $this->Ln();	
        $this->Ln();
		
		$this->Cell($widthName+$widthValue,$height,tr('Atouts'),0,0,'C');
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
            $this->Cell($widthName,$height,tr($this->advantageList[$this->pj->getField('av_'.$i)]),'B');
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
	function transformation()
	{
		$this->SetLeftMargin(5);
		$this->SetX(5);

		$width=40;
		$this->SetFont('Treefrog','',16);
		$this->SetTextColor(132,91,75);
		$height=5;
		$this->Cell($width,$height,'HISHU',0,0,'C');
		$this->Cell($width,$height,'DALU',0,0,'C');
		$this->Cell($width,$height,'GAURU',0,0,'C');
		$this->Cell($width,$height,'URSHUL',0,0,'C');
		$this->Cell($width,$height,'URHANE',0,0,'C');		
		$this->Ln();
		$this->SetFont('DejaVu','',8);
		$this->SetTextColor(0,0,0);
		
		$this->Cell($width,$height,tr('(Humain)'),'B',0,'C');
		$this->Cell($width,$height,tr('(Presque humain)'),'B',0,'C');
		$this->Cell($width,$height,tr('(Homme-Loup)'),'B',0,'C');
		$this->Cell($width,$height,tr('(Presque Loup)'),'B',0,'C');
		$this->Cell($width,$height,tr('(Loup)'),'B',0,'C');
		$this->Ln();
		$this->SetFont('Treefrog','',8);
		$this->Cell($width,$height,'','R',0,'C');

        
        
		$this->SetTextColor(132,91,75);
       $str=tr('Force (+1) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_force')+1),'R',0,'L');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);

    $str=tr('Force (+3) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_force')+3),'R',0,'L');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);

    $str=tr('Force (+2) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_force')+2),'R',0,'L');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);

    $str=tr('Dexterite (+2) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'0');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_dex')+2),0,0,'L');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);


$this->Ln();


        $this->Cell($width,$height,'','R',0,'C');

    $str=tr('Vigueur (+1) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_vig')+1),'R',0,'0');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);

    $str=tr('Dexterite (+1) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_dex')+1),'R',0,'0');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);

    $str=tr('Dexterite (+2) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_dex')+2),'R',0,'0');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);

    $str=tr('Vigueur (+1) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'0');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_vig')+1),0,0,'0');
        $this->SetFont('Treefrog','',8);

		$this->SetTextColor(132,91,75);
        $this->Ln(); 
        
        
        

        $this->Cell($width,$height,'','R',0,'C');
        $str=tr('Manipulation (-1) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
		$this->SetTextColor(0,0,0);
        $this->SetFont('DejaVu','',10);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_mani')-1),'R',0,'L');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);

        $str=tr('Vigueur (+2) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_vig')+2),'R',0,'L');
        $this->SetFont('Treefrog','',8);

		$this->SetTextColor(132,91,75);
        $str=tr('Vigueur (+2) : ');
        $lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_vig')+2),'R',0,'L');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);

        $this->Cell($width,$height,'',0,0,0);
        $this->Ln();

        $this->Cell($width,$height,'','R',0,'C');
        $this->Cell($width,$height,'','R',0,'L');
        $this->Cell($width,$height,'','R',0,'L');

    $str=tr('Manipulation (-3) : ');
$lenght=$this->GetStringWidth($str);
        $this->Cell($lenght,$height,$str,0,0,'L');
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->Cell($width-$lenght,$height,''.($this->pj->getField('at_mani')-3),'R',0,'L');
        $this->SetFont('Treefrog','',8);
		$this->SetTextColor(132,91,75);
        $this->Cell($width,$height,'',0,0,'L');
        $this->Ln(); 


		$this->SetTextColor(0,0,0);
		$this->SetFont('DejaVu','',8);
		
		$length = $this->GetStringWidth('Taille:');
		$this->Cell($length,$height,'Taille:',0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('hand_taille')),'BR',0,'C');
		
		$length = $this->GetStringWidth('Taille (+1):');
		$this->Cell($length,$height,'Taille (+1):',0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('hand_taille')+1),'BR',0,'C');
		
		$length = $this->GetStringWidth('Taille (+2):');
		$this->Cell($length,$height,'Taille (+2):',0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('hand_taille')+2),'BR',0,'C');
		
		$length = $this->GetStringWidth('Taille (+1):');
		$this->Cell($length,$height,'Taille (+1):',0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('hand_taille')+1),'BR',0,'C');
		
		$length = $this->GetStringWidth('Taille (-1):');
		$this->Cell($length,$height,'Taille (-1):',0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('hand_taille')-1),'B',0,'C');
		$this->Ln();
		
		
		
		$length = $this->GetStringWidth(tr('Defense:'));
		$this->Cell($length,$height,tr('Defense:'),0,0,'L');
        $this->Cell($width-$length,$height,''.min($this->pj->getField('at_dex'),$this->pj->getField('at_ast')),'BR',0,'C');
		$this->Cell($length,$height,tr('Defense:'),0,0,'L');
        $this->Cell($width-$length,$height,''.min($this->pj->getField('at_dex'),$this->pj->getField('at_ast')),'BR',0,'C');
		$this->Cell($length,$height,tr('Defense:'),0,0,'L');
        $this->Cell($width-$length,$height,''.min($this->pj->getField('at_dex')+1,$this->pj->getField('at_ast')),'RB',0,'C');
		$this->Cell($length,$height,tr('Defense:'),0,0,'L');
        $this->Cell($width-$length,$height,''.min($this->pj->getField('at_dex')+2,$this->pj->getField('at_ast')),'BR',0,'C');
		$this->Cell($length,$height,tr('Defense:'),0,0,'L');
        $this->Cell($width-$length,$height,''.min($this->pj->getField('at_dex')+2,$this->pj->getField('at_ast')),'B',0,'C');
		$this->Ln();
		
		
		$length = $this->GetStringWidth(tr('Initiative:'));
		$this->Cell($length,$height,tr('Initiative:'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_dex')),'BR',0,'C');
		$this->Cell($length,$height,tr('Initiative:'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_dex')),'BR',0,'C');
		
		$length = $this->GetStringWidth(tr('Initiative (+1):'));
		$this->Cell($length,$height,'Initiative (+1):',0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_dex')+1),'RB',0,'C');
		
		$length = $this->GetStringWidth('Initiative (+2):');
		$this->Cell($length,$height,tr('Initiative (+2):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_dex')+2),'RB',0,'C');
		$this->Cell($length,$height,tr('Initiative (+2):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_dex')+2),'B',0,'C');
        $this->Ln();
		
		$length = $this->GetStringWidth(tr('Vitesse:'));
        $this->Cell($length,$height,tr('Vitesse:'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_dex')+$this->pj->getField('at_force')+$this->pj->getField('hand_taille')),'BR',0,'C');
		
		$length = $this->GetStringWidth(tr('Vitesse (+1):'));
        $this->Cell($length,$height,tr('Vitesse (+1):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_dex')+$this->pj->getField('at_force')+$this->pj->getField('hand_taille')+1),'RB',0,'C');
		
		$length = $this->GetStringWidth(tr('Vitesse (+4):'));
        $this->Cell($length,$height,tr('Vitesse (+4):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_dex')+$this->pj->getField('at_force')+$this->pj->getField('hand_taille')+4),'BR',0,'C');		
		
		$length = $this->GetStringWidth('Vitesse (+7):');
        $this->Cell($length,$height,tr('Vitesse (+7):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_dex')+$this->pj->getField('at_force')+$this->pj->getField('hand_taille')+7),'BR',0,'C');		
		
		$length = $this->GetStringWidth('Vitesse (+5):');
        $this->Cell($length,$height,tr('Vitesse (+5):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_dex')+$this->pj->getField('at_force')+$this->pj->getField('hand_taille')+5),'B',0,'C');		
        $this->Ln();
		
        
        $length = $this->GetStringWidth(tr('Armure:'));
        $this->Cell($length,$height,tr('Armure:'),0,0,'L');
        $this->Cell($width-$length,$height,'','BR',0,'L');
		

        $this->Cell($length,$height,tr('Armure:'),0,0,'L');
        $this->Cell($width-$length,$height,'','BR',0,'L');
		

		$length2 = $this->GetStringWidth('1/1');
        $this->Cell($length,$height,tr('Armure:'),0,0,'L');
        $this->Cell($width-$length-$length2,$height,'','B',0,'L');
		$this->Cell($length2,$height,'1/1','BR',0,0);
		

        $this->Cell($length,$height,tr('Armure:'),0,0,'L');
        $this->Cell($width-$length,$height,'','RB',0,'L');
		

        $this->Cell($length,$height,tr('Armure:'),0,0,'L');
        $this->Cell($width-$length,$height,'','B',0,'L');
		
        $this->Ln();
		
		$length = $this->GetStringWidth(tr('Perception:'));
		
        $this->Cell($length,$height,tr('Perception:'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_ast')),'RB',0,'C');
		$length = $this->GetStringWidth(tr('Perception (+2):'));
		$this->Cell($length,$height,tr('Perception (+2):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_ast')+2),'RB',0,'C');
		$length = $this->GetStringWidth(tr('Perception (+3):'));
		$this->Cell($length,$height,tr('Perception (+3):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_ast')+3),'BR',0,'C');
		$length = $this->GetStringWidth(tr('Perception (+3):'));
		$this->Cell($length,$height,tr('Perception (+3):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_ast')+3),'BR',0,'C');
		$length = $this->GetStringWidth(tr('Perception (+4):'));
		$this->Cell($length,$height,tr('Perception (+4):'),0,0,'L');
        $this->Cell($width-$length,$height,''.($this->pj->getField('at_cal')+$this->pj->getField('at_ast')+4),'B',0,'C');
		
		$this->Ln();
/*		nduit le Délire;
les observateurs ont
+4 à leur jet de
Volonté pour résister*/
		$height=4;
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'',0,0,'C');
                $this->Ln();

		$this->Cell($width,$height,'','R',0,'C');
		$this->Cell($width,$height,tr('Induit la lubie'),'R',0,'C');
		$this->Cell($width,$height,tr('Rage Invoquée'),'R',0,'C');
		$this->Cell($width,$height,tr('Induit la lubie'),'R',0,'C');
		$this->Cell($width,$height,tr('Inflige dégâts létaux'),0,0,'C');
		$this->Ln();


                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,tr('Les observateurs ont'),'R',0,'C');
                $this->Cell($width,$height,tr('Induit une lubie totale'),'R',0,'C');
                $this->Cell($width,$height,tr('Les observateurs ont'),'R',0,'C');
                $this->Cell($width,$height,tr('par morsure'),0,0,'C');
                $this->Ln();


                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,tr('+4 à leur jet de'),'R',0,'C');
                $this->Cell($width,$height,tr('Penalités de blessure'),'R',0,'C');
                $this->Cell($width,$height,tr('+2 à leur jet de'),'R',0,'C');
                $this->Cell($width,$height,'',0,0,'C');
                $this->Ln();

                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,tr('Volonté pour résister.'),'R',0,'C');
                $this->Cell($width,$height,tr('ignorée et aucun'),'R',0,'C');
                $this->Cell($width,$height,tr('Volonté pour résister.'),'R',0,'C');
                $this->Cell($width,$height,'',0,0,'C');
                $this->Ln();

                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,tr('jet d’inconscience à'),'R',0,'C');
                $this->Cell($width,$height,tr('Inflige dégâts létaux.'),'R',0,'C');
                $this->Cell($width,$height,'',0,0,'C');
                $this->Ln();

                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,tr('faire. -2 contre la'),'R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'',0,0,'C');
                $this->Ln();

                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,tr('Rage Mortelle. Dégâts'),'R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'',0,0,'C');
                $this->Ln();

                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,tr('létaux.Echec à quasi'),'R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'',0,0,'C');
                $this->Ln();

                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,tr('tous les jets Mentaux'),'R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'',0,0,'C');
                $this->Ln();

                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,tr('et Sociaux.'),'R',0,'C');
                $this->Cell($width,$height,'','R',0,'C');
                $this->Cell($width,$height,'',0,0,'C');
                $this->Ln();
		$this->Ln();
		$this->Ln();
		$this->Line($this->getX(),$this->getY(), $this->getX()+200,$this->getY());
		$this->displayTotem();
	}
    function displayDons($X,$Y)
    {
       $this->SetLeftMargin($X+5);
       $this->setY($Y); 
//       $this->setXmargin($X);
        $width=140;
        $height=5;
        $this->SetFont('Treefrog','',14);
		$this->SetTextColor(132,91,75);
        $this->Cell($width,$height,tr('Dons et Rituels'),'0',0,'C');
        $this->Ln();

        $this->SetFont('Treefrog','',10);
        $length = $this->GetStringWidth(tr('Listes de dons:'));
        $this->Cell($length,$height,tr('Listes de dons:'),0,0,'L');
        $this->Cell($width-$length,$height,'','B',0,'C');
$this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
$this->Ln();
        $this->Cell($width,$height,'','B',0,'C');
$this->Ln();
        $this->Cell($width,$height,'','B',0,'C');

        $this->Ln();
        $this->SetFont('Treefrog','',10);
$this->SetTextColor(132,91,75);

        $length = $this->GetStringWidth(tr('Rang Maximum:'));
        $this->Cell($length,$height,tr('Rang Maximum:'),0,0,'L');
        $this->SetFont('DejaVu','',10);
        $this->SetTextColor(0,0,0);

        $length = $this->GetStringWidth('○○○○○');
        $this->Cell($length,$height,'○○○○○',0,0,'L');
$this->Ln();


        $this->SetFont('Treefrog','',10);
$this->SetTextColor(132,91,75);

        $this->Cell(60,$height,tr('Don'),0,0,'L');
        $this->Cell(60,$height,tr('Jet'),0,0,'L');
        $this->Cell(20,$height,tr('Page'),0,0,'C');
        $this->SetFont('DejaVu','',10);
        $this->SetTextColor(0,0,0);

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

        $this->SetFont('Treefrog','',10);
$this->SetTextColor(132,91,75);
$length = $this->GetStringWidth(tr('Rituels:'));
        $this->Cell($length,$height,tr('Rituels:'),0,0,'L');
        $this->SetFont('DejaVu','',10);
        $this->SetTextColor(0,0,0);
        $length = $this->GetStringWidth('○○○○○');
        $this->Cell($length,$height,'○○○○○',0,0,'L');
        $this->Ln();
        $this->SetFont('Treefrog','',10);
$this->SetTextColor(132,91,75);

        $this->Cell(60,$height,tr('Rite'),0,0,'L');
        $this->Cell(60,$height,tr('Jet'),0,0,'L');
        $this->Cell(20,$height,tr('Page'),0,0,'C');
	$this->SetFont('DejaVu','',10);
	$this->SetTextColor(0,0,0);

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

    $this->displayBackground();
}
  function displayBackground()
    {
        $text = $this->pj->getField('background');

        if(!empty($text ))
        {
            $this->AddPage();
                        $this->write(5,$text);
        }  
    }



    function displayTotem()
    {
        
        $width=50;
        $Y = $this->getY();

        $height=5;
        $this->SetFont('Treefrog','',14);
	$this->SetTextColor(132,91,75);
        $this->Cell($width,$height,tr('Totem'),'0',0,'C');
        $X = $this->getX();
        $this->Ln();

	        
        $this->SetFont('Treefrog','',10);
$this->Cell($width,$height,tr('Attributs:'),'0',0,'0');
        $this->Ln();
        $this->SetFont('DejaVu','',10);
	$this->SetTextColor(0,0,0);

        $this->Cell(5,$height,'',0,0,'0');
        $length = $this->GetStringWidth(tr('Pouvoir:'));
        $this->Cell($length,$height,tr('Pouvoir:'),0,0,'L');

        $this->Cell($width-$length-5,$height,'','B',0,'L');
        $this->Ln();




        $this->Cell(5,$height,'',0,0,'0');
        $length = $this->GetStringWidth(tr('Finesse:'));
        $this->Cell($length,$height,tr('Finesse:'),0,0,'L');
         $this->Cell($width-$length-5,$height,'','B',0,'L');



         $this->Ln();
         $this->Cell(5,$height,'',0,0,'0');
         $length = $this->GetStringWidth(tr('Résistance:'));
         $this->Cell($length,$height,tr('Résistance:'),0,0,'L');
         $this->Cell($width-$length-5,$height,'','B',0,'L');

         $this->Ln();

        $this->SetFont('Treefrog','',10);
$this->SetTextColor(132,91,75);
         $length = $this->GetStringWidth(tr('Volonte:'));
         $this->Cell($length,$height,tr('Volonte:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');

         $this->Ln();
         $length = $this->GetStringWidth(tr('Essence:'));
         $this->Cell($length,$height,tr('Essence:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');

		$this->SetFont('DejaVu','',10);
        $this->SetTextColor(0,0,0);
         $this->Ln();
         $length = $this->GetStringWidth(tr('Initiative:'));
         $this->Cell($length,$height,tr('Initiative:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');
         $this->Ln();
         $length = $this->GetStringWidth(tr('Défense:'));
         $this->Cell($length,$height,tr('Défense:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');
         $this->Ln();
         $length = $this->GetStringWidth(tr('Vitesse:'));
         $this->Cell($length,$height,tr('Vitesse:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');
         $this->Ln();
         $length = $this->GetStringWidth(tr('Taille:'));
         $this->Cell($length,$height,tr('Taille:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');

         $this->Ln();
         $length = $this->GetStringWidth(tr('Corpus:'));
         $this->Cell($length,$height,tr('Corpus:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');


         $this->Ln();
         $length = $this->GetStringWidth(tr('Influence:'));
         $length2 = $this->GetStringWidth('○○○○○');
         $this->Cell($length,$height,tr('Influence:'),0,0,'L');
         $this->Cell($width-$length-$length2,$height,'','B',0,'L');
         $this->Cell($length2,$height,'○○○○○',0,0,'C');
         $this->Ln();
         $this->Cell($width-$length2,$height,'','B',0,'L');
         $this->Cell($length,$height,'○○○○○',0,0,'C');
         $this->Ln();
         $this->Cell($width-$length2,$height,'','B',0,'L');
         $this->Cell($length,$height,'○○○○○',0,0,'C');
         $this->Ln();

         $length = $this->GetStringWidth(tr('Benedictions:'));
         $this->Cell($length,$height,tr('Benedictions:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');
         $this->Ln();
         $this->Cell($width,$height,'','B',0,'L');
        $this->Ln();
         $this->Cell($width,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'L');
        $this->Ln();
         $length = $this->GetStringWidth(tr('Bonus:'));
         $this->Cell($length,$height,tr('Bonus:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');
         $this->Ln();
         $this->Cell($width,$height,'','B',0,'L');
        $this->Ln();
         $this->Cell($width,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'L');
$this->Ln();
         $length = $this->GetStringWidth(tr('Interdit:'));
         $this->Cell($length,$height,tr('Interdit:'),0,0,'L');
         $this->Cell($width-$length,$height,'','B',0,'L');
         $this->Ln();
         $this->Cell($width,$height,'','B',0,'L');
        $this->Ln();
         $this->Cell($width,$height,'','B',0,'L');
        $this->Ln();
        $this->Cell($width,$height,'','B',0,'L');
        $this->Ln();
        //$this->SetFont('DejaVu','',10);

        //$this->SetFont('DejaVu','',10);
        //$this->SetFont('DejaVu','',10);
        //$this->SetFont('Treefrog','',8);
	$this->Line($X+2,$Y+2,$X+2,$this->getY());
        $this->displayDons($X,$Y);
    }

}
$pdf=new PDF();

//$idchar=$_SESSION['idchar'];
//if((checkSession(MJ))||(checkSession(ADMIN)))
 //$idchar=$_GET['idchar'];
//$dsql->sendRequest('select * from character where id ='.$idchar);



//$dsql->res_tab_assoc($line);
//$char = new Character($_POST);
//$char->setSecret(true);
//$char->updateModications($dsql);


$pdf->SetTitle(tr('Fiche de personnage: ').$char->getField('name'),true);
$pdf->SetAuthor('Renaud Guezennec',true);
$pdf->SetCreator('NWodCG - http://nwod.rolisteam.org',true);

$pdf->setPj($char);

$pdf->SetMargins(0,0,0);
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('Treefrog','','Treefrog.ttf',true);


$pdf->SetFont('DejaVu','',12);

$pdf->SetMargins(20,20);
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);


$pdf->displayInfo();
//$pdf->jumpSection();
$myX=$pdf->getX();
$pdf->displayAttribut();
$pdf->displayTalent();

$pdf->jumpSection();

$myY=$pdf->getY();



$pdf->AddPage();
$pdf->transformation();





//$myX+=$pdf->displayAtout($myX+$myX2,$myY);
$name = $char->getField('ig_name');
        if(empty($name))
        {
            $name='inconnu';
        }
$pdf->Output($char->getField('ig_name').'.pdf','D');

//◼ ◻ 


