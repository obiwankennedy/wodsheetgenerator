<?php 
//include_once("../../session/session_lib.php");

//define("_SYSTEM_TTFONTS", "/home/renaud/www/tenebrae/include/pdf/tfpdf/font/unifont/");


require_once('../include/pdf/tfpdf/tfpdf.php');
require_once('../security/session_lib.php');
require_once('../include/libphp/lib.php');

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
        $this->Image("lg-000.jpg",0,0,600,840);

    
    }

    function displayInfo()
    {   
        $height=18;
        $this->Ln($height);
        $this->Ln($height);
        $text='Le_Sage vous propose une partie de:';
		$length=$this->GetStringWidth($text);
		$this->Cell($length,$height,$text);
        $this->Ln($height);

        $this->Image("werewolf.jpg",190,150,200,364);//250*455
		
        $text='        Loup-Garou: Les Dechus';
        //$this->setY( $this->getY()+173);
        //$this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
		$this->SetFont('Treefrog','',28);
		$this->SetTextColor(132,91,75);
		$length=$this->GetStringWidth($text);

		$this->Cell($length,$height,$text,0,0,'C');
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
                $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
                $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        $this->Ln($height);
        
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        $this->SetFont('DejaVu','',12);
        $text='À propos du jeu:';
        $length=$this->GetStringWidth($text);
        $this->Cell($length,$height,$text,'B',0,'L');

        $this->Ln($height);
        $this->SetFont('DejaVu','',10);
        $text='Le jeu vous propose d’incarner les membres d’une meute de Loups-Garous. Contrairement à ce que le cinéma';
        $length=$this->GetStringWidth($text);
        $this->Cell($length,$height,$text,0,0,'L');
        $this->Ln($height);
         $text='ou la littérature prétend. vous n’êtes pas les victimes d’une malédiction mais les descendants d’une antique';
        $length=$this->GetStringWidth($text);
        $this->Cell($length,$height,$text,0,0,'L');
        $this->Ln($height);
        $text='race de créatures protégeant l’équilibre précaire du monde.';
        $length=$this->GetStringWidth($text);
        $this->Cell($length,$height,$text,0,0,'L');
        $this->Ln($height);
        $this->Ln($height);   
        $this->Ln($height); 

        $text='Le scénario:';
        $this->SetFont('DejaVu','',12);
        $length=$this->GetStringWidth($text);
        $this->Cell($length,$height,$text,'B',0,'L');
        $this->SetFont('DejaVu','',10);
        $this->Ln($height);


        $text='Promenons-nous dans les bois quand le loup n’y est pas ! Oui mais… Pourquoi est-il parti ? Que cache ';
        $length=$this->GetStringWidth($text);
        $this->Cell($length,$height,$text,0,0,'L');
        $this->Ln($height);
        $text='cette forêt si mystérieuse ? Le monde des esprits y règne peut-être ? Est-ce une créature surnaturelle ?';
        $length=$this->GetStringWidth($text);
        $this->Cell($length,$height,$text,0,0,'L');
        $this->Ln($height);
        $text='Je vous propose une petite descente dans les contes pour enfants. Certains pourraient dissimuler quelles vérités…';
        $length=$this->GetStringWidth($text);
        $this->Cell($length,$height,$text,0,0,'L');
        $this->Ln($height);
        $text='';
        $length=$this->GetStringWidth($text);
        $this->Cell($length,$height,$text,0,0,'L');
        $this->Ln($height);






		$this->SetTextColor(0,0,0);
        $this->SetFont('DejaVu','',10);
		$this->SetTextColor(0,0,0);
        
        
        
        
        
        
        
        
        
        
        
        
	}
	

}
$pdf=new PDF('P','pt');




$pdf->SetTitle('Fiche de personnage: ',true);
$pdf->SetAuthor('Renaud Guezennec',true);
$pdf->SetCreator('Tenebrae - www.tenebrae-mundis.com',true);



$pdf->SetMargins(0,0,0);
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('Treefrog','','Treefrog.ttf',true);


$pdf->SetFont('DejaVu','',12);

$pdf->SetMargins(20,20);
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);

$pdf->displayInfo();

$pdf->Output('test.pdf','D');




