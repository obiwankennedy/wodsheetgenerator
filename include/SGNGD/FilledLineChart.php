<?php
/**!
 *
 *  Copyright 2008 Renaud Guezennec
 *
 *  This file is part of SGNGD.
 *
 *  SGNGD is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.type filter text
 *
 *  SDNGD distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with SGNGD.  If not, see <http://www.gnu.org/licenses/>.
 *
 * 
 * 
 */

/**
 * \author:Renaud Guezennec 
 * Contact me: http://renaudguezennec.homelinux.org/index,1,3.html
 * 
 * 
 * \class FilledLineChart
 * \brief displays an under filled line 
 * \todo change the data storage mechanism  
 * \version 0.1
 * \date 28/03/2009
 */
class FilledLineChart extends Chart
{
	public $max;
	public $min;
	public $drawingZone;
	public $axeX;
	public $axeY;
	public $graduationH;
	public $graduationV;
	public $nb_grad;
	public $valuenumber;
	public $db;
	public $persis;
//    public $values;	
    
    
	public function __construct($m_title = null,$persistent = false,$typecolor=NORMAL)
	{
			 $this->canvasx=0;
             $this->persis = $persistent;
            
			 $this->canvasy=0;
			 $this->width=650;
			 $this->height=450;
//			 $this->values=array();
			 $this->legend=false;
			 $this->colortype=$typecolor;
			 $this->startColor= new Color(255,255,255);
			 $this->endColor = new Color(0,0,0);
			 $this->count = 0;
			 $this->nb_grad = 4;
			 $this->title = $m_title;
			 $this->valuenumber = 100;
			 $this->current = -1;
			 //$this->initialpoint;
             if($this->persis)
             {
				if($this->db = sqlite_popen('filledline', 0666, $mon_message_erreur))
				{
					$sql = "select name from sqlite_master where type='table'";
					if(sqlite_query($this->db,$sql,SQLITE_ASSOC,$msg))
					{
						
						
						
					}
					else
					{
							 sqlite_query($this->db,'CREATE TABLE Tablecurrent (current integer(10))');
							 sqlite_query($this->db,"INSERT INTO Tablecurrent VALUES ('-1')");
							 sqlite_query($this->db,'CREATE TABLE Tablecount (countinteger(10))');
							 sqlite_query($this->db,"INSERT INTO Tablecount VALUES ('-1')");
					}
		   		
    		 	}
    		 	else
		 	    {
		      		die ($mon_message_erreur);
	    	 	}
    			if(!isset($_SESSION['Filledline']['current']))
			    {
			 	    $_SESSION['Filledline']['current'] =-1;
			    }
             }
             else
             {
                $this->values = array();
             }

			 
	}
	public function SetScale($sc)
	{
		$this->nb_grad = $sc;
	}
	public function AddData($value)
	{
            if($this->persis)
             {

                $this->current = $_SESSION['Filledline']['current'];
                $this->count = $_SESSION['Filledline']['count'];
            
                if($this->count!=$this->valuenumber)
                    $this->count++;
            
                if($this->current>=$this->valuenumber)
                    $this->current = 0;
                else
                    $this->current++;
                if((!isset($_SESSION['Filledline']['max']))||($_SESSION['Filledline']['max']<$value))
                 {
                    $_SESSION['Filledline']['max'] =$value;
                 }
                
                 if(!isset($_SESSION['Filledline']['min']))
                 {
                    $_SESSION['Filledline']['min'] =0;
                 }
                 else if($_SESSION['Filledline']['min']>$value)
                        $_SESSION['Filledline']['min'] =$value;
                 $this->max = $_SESSION['Filledline']['max'];
                 $this->min =$_SESSION['Filledline']['min'];
                 $_SESSION['Filledline']['data'][$this->current]=$value;

                    
                $_SESSION['Filledline']['current']=$this->current;
                $_SESSION['Filledline']['count']=$this->count;
            }
            else
            {
                if(count($this->values)==0)
                {
                    $this->min = $value;
                    $this->max=$value;

                }

                if($value<$this->min)
                    $this->min=$value;
                if($value>$this->max)
                    $this->max=$value;
               $this->values[] = $value;

            }
	}
	public function Compute()
	{
		
//	if($this->persis)
  //  {
	
		$this->distanceMax=abs($this->max)+abs($this->min);
		$this->drawingZone=array(($this->width*15/100),($this->height*5/100),($this->width-($this->width*20/100)),($this->height-($this->height*10/100)));
		if($this->distanceMax == 0)
		{
			$this->distanceMax=$this->drawingZone[3];
		    $this->max =$this->distanceMax/2;
		}
		//echo $this->distanceMax;
		$stepy=$this->drawingZone[3]/$this->distanceMax;
		
		if($this->valuenumber!=0)
		    $stepx=$this->drawingZone[2]/$this->valuenumber;
		else
    		$stepx=0;
		//echo $this->max.' ='.$stepy;
		$this->axeX=array($this->drawingZone[0],$this->drawingZone[1]+($this->distanceMax*$stepy),$this->drawingZone[0]+$this->drawingZone[2],$this->drawingZone[1]+($stepy*$this->distanceMax));
		$this->axeY=array($this->drawingZone[0],$this->drawingZone[1],$this->drawingZone[0],$this->drawingZone[1]+$this->drawingZone[3]);
		
        $gradV = ($this->distanceMax*$stepy) / $this->nb_grad;
//		$gradV = $this->nb_grad*y;
		//echo $this->nb_grad," ",$stepy;
		$stepvalue=  $this->max - $this->min ;
		$stepvalue = round($stepvalue/$this->nb_grad,0);
		
		for($i = 0;$i<=$this->max;$i=$i+$stepvalue)
		{
			$value=($this->axeX[1]-($i*$stepy));
			$this->graduationV[]=array($this->axeX[0],$value,$this->axeX[0]-5,$value,$i);
		}
		
		
		
		
		//for($p =$this->drawingZone[1];$p<=$this->axeY[3];$p +=$gradV )
		//{
			// echo $this->axeY[3]," ",$this->drawingZone[1]," ",$this->axeY[3]," ",$p," ",$gradV,"<br/> ";
			//if(round($this->axeX[1], 2)!=round($p, 10))
				//$valeur = ($this->axeX[1]-$p);
			/*else 
				$valeur = 0;*/

          //  $this->graduationV[]=array($this->axeX[0],$valeur,$this->axeX[0]-5,$valeur,"value");
	//	}
        
 //       print_r($this->graduationV);
	if(!$this->persis)	
    {
        foreach($this->values as $key => $tmp)
		{
				/*    $index = $this->current-$k;
				if($index<0)//$this->valuenumber
				$index += $this->valuenumber;*/
				$stepx = $this->drawingZone[2]/(count($this->values)-1);
				//                 $tmp = $this->values[$k];
				$temp=array();
				$temp['value']= $tmp;
				$temp['rect']=array($this->axeX[2]-$stepx*($key),$this->axeX[3]-($tmp*$stepy));
				$this->values[$key]=$temp;
		}
	}
	else
	{  
			for($k=$this->count-1;$k >0 ;$k--)
			{
				$index = $this->current-$k;
				if($index<0)//$this->valuenumber
					$index += $this->valuenumber;
					$tmp = $_SESSION['Filledline']['data'][$index];
				//if($temp['value']>0)
				$temp=array();
				$temp['value']= $tmp;
				$temp['rect']=array($this->axeX[2]-$stepx*$k,$this->axeX[3]-($tmp*$stepy));
				$this->values[$this->count-(1+$k)]=$temp;
			}
	}
}
	
	public function display()
	{
		$page .= $this->start();
		
		$page .='<rect id="bg" x="0" y="0" width="'.$this->width.'" height="'.$this->height.'" style="fill: #DDD; stroke: black;" />
		<line x1="'.$this->axeX[0].'" y1="'.$this->axeX[1].'" x2="'.$this->axeX[2].'" y2="'.$this->axeX[3].'" stroke="black" stroke-linecap="round"/>
		<line x1="'.$this->axeY[0].'" y1="'.$this->axeY[1].'" x2="'.$this->axeY[2].'" y2="'.$this->axeY[3].'" stroke="black" stroke-linecap="round"/>
		<text id="title" x = "'.($this->width/2).'" y = "'.($this->axeY[1]/2).'" fill = "navy" font-size = "10" > '.$this->title.' </text>
		<defs>
			<linearGradient id="degrade" x1="10%" y1="100%" x2="100%" y2="100%">
				<stop offset="0%" id="stop1"/>
				<stop offset="100%" id="stop2"/>
			</linearGradient>
		</defs>';
		
		foreach($this->graduationV as $grad)
		{

          $page .='<line x1="'.($grad[0]).'" y1="'.($grad[1]).'" x2="'.$grad[2].'" y2="'.$grad[3].'" stroke="black" stroke-linecap="round"/>';
          $page .= '<text x = "'.($grad[0]-($this->width*0.05)).'" y = "'.($grad[1]+($this->height*0.005)).'" fill = "navy" font-size = "10"> '.$grad[4].' </text>';				
		}
		$page .='<g class="piece" style="fill: '.$one['color'].'; stroke: black;"><path d="m';
//print_r($this->values);
		$last=0;
		for($i =0;$i<count($this->values); $i++)
		{
			$one = $this->values[$i];
 //           print_r($one);
			if($i==0)
				$page .=$one['rect'][0].','.$this->axeX[3].' ';
				$page .='L'.$one['rect'][0].','.$one['rect'][1].' ';
		
			if($i==count($this->values)-1)
				$last = $one['rect'][0];
			
			
		}
		
		$page .='L'.$last.','.$this->axeX[3].'"/></g>';
		
		
		
		
		
		
		
		
		
		
		
		
		
		$page .=$this->end();
		
		
		return $page;
	}
}
?>
