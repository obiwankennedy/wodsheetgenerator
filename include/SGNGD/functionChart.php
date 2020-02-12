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
 */


define("NONE","0");
define("LIN","1");
define("SQU","2");
/**
 * \author:Renaud Guezennec 
 * Contact me: http://renaudguezennec.homelinux.org/index,1,3.html
 * 
 * 
 * \class functionChart extends Chart
 * \brief plots a mathematical function 
 * \version 0.1
 * \date 28/03/2009
*	\todo: change remove all variable which a french name.
 */
class functionChart extends Chart
{
	
	public $max;///< Maximum of the data value (Y axis)
	public $min;///< Minimum of the data value (Y axis)
	public $drawingZone;///< Array describing the usable zone.
	public $axeX;///< Array of all required data for the X axis
	public $axeY;///< Array of all required data for the Y axis
	public $graduationH;///< Array of all required data for the Horizontal graduation
	public $graduationV;///< Array of all required data for the vectical graduation
	public $nb_grad;///< int number of graduation
	public $functionptr; ///< pointer to function (the data)
	public $interpolation;///< define the interpolation mode. NOT YET USED
	public $xbegin;///< define the starting x value to draw the function.
	public $xend;///< define the ending x value to draw the function.
	public $xstep;///< define the x step between two points.
	public $xtitle;///< define the title of the axi x 
	public $ytitle;///< define the title of the axi y
	public $indexesArray;///< define the title of the axi y
/**
 * 
 * \fn __construct
 * \brief set the default values to all members . 
 * \param $m_title : string the title of the Chart,$typecolor = constante Colour policy
 */
	public function __construct($m_title = null,$typecolor=NORMAL)
	{
			$this->canvasx=0;
			$this->canvasy=0;
			$this->width=650;
			$this->height=450;
			$this->values=array();
			$this->legend=false;
			$this->colortype=$typecolor;
			$this->startColor= new Color(255,255,255);
			$this->endColor = new Color(0,0,0);
			$this->count = 0;
			$this->nb_grad = 4;
			$this->title = $m_title;
			$this->interpolation = 0;
			$this->functionptr=array();
			$this->xbegin=-5;
			$this->xend=5;
			$this->xstep=1;
			$this->ytitle = "";
			$this->xtitle = "";
			$this->indexesArray = null;
	}
/**
 * 
 * \fn setparams($x1,$x2,$step)
 * \brief set the interval informations. X1 must be greater than X2. 
 * \param $x1 : double 
 * \param $x2 : double
 *	\param $step : double
 */
	public function setparams($x1,$x2,$step)
	{
		
		if($x1>$x2)
			die("Error the start x must be greater than the end");
			
			$this->xbegin=$x1;
			$this->xend=$x2;
			$this->xstep=$step;
	}
	public function setIndexes($indexesArray)
	{
			$this->indexesArray=$indexesArray;
	}
/**
* 
* \fn setXTitle($title)
* \brief set the interval informations. X1 must be greater than X2. 
* \param $x1 : double 
* \param $x2 : double
*	\param $step : double
*/
	public function setXTitle($title)
	{
		
			$this->xtitle = $title;
	}
	/**
* 
* \fn setXTitle($title)
* \brief set the interval informations. X1 must be greater than X2. 
* \param $x1 : double 
* \param $x2 : double
*	\param $step : double
*/
	public function setYTitle($title)
	{
		
			$this->ytitle = $title;
	}
	
/**
 * 
 * \fn setparams($x1,$x2,$step)
 * \brief set the interval informations. X1 must be greater than X2. 
 * \param $x1 : double ,$x2 : double,$step : double
 */
	public function SetScale($sc)
	{
		$this->nb_grad = $sc;
	}
	public function interpolationlinaire($v1, $v2, $mu)
	{
		return($v1*(1-$mu)+$v2*$mu);
	}
	 public function interpolationCubique( $y0, $y1, $y2, $y3, $mu)
  	{
     
  
     $mu2 = $mu*$mu;
     $a0 = $y3 - $y2 - $y0 + $y1;
     $a1 = $y0 - $y1 - $a0;
     $a2 = $y2 - $y0;
     $a3 = $y1;
  
     return ($a0*$mu*$mu2+$a1*$mu2+$a2*$mu+$a3);
  	}
	
	public function AddData($title,$valueptr,$type=NONE,$color=null)
	{
		$temp=array();
		$values = array();
		$temp['title']=$title;
		$temp['funct']=$valueptr;
		$temp['inter']=$type;
		if($this->colortype!=NORMAL)
		{
			$temp['color']=$color;	
		}
		$k = 0;
		if($this->indexesArray ==null)
		{
			for($i = $this->xbegin;$i<=$this->xend;$i=round($i+$this->xstep,2))
			{
				
				$values[$i]=round($valueptr($i),3);
				
				$temp2 = $values[$i];
				if($k==0)
				{

						$this->max=$temp2;
						$this->min=$temp2;

				}
				if($temp2<$this->min)
				$this->min   = $temp2;
				
				if($temp2>$this->max)
				$this->max = $temp2;
				
				$k++;
			}
		}
		else
		{
			
			foreach($this->indexesArray as $index)
			{
				
				$values[$index]=round($valueptr($index),3);
				
				$temp2 = $values[$index];

				if($k==0)
				{

						$this->max=$temp2;
						$this->min=$temp2;

				}
				if($temp2<$this->min)
				$this->min   = $temp2;
				
				if($temp2>$this->max)
				$this->max = $temp2;
				
				$k++;
			}
			
		}
	//	echo $k," ",count($values),"<br/>";
	//	echo count($values)," ",$k,"<br/>";

		$temp['values']=$values;
		
		
			$this->values[] = $temp;
		
			
		$this->count++;
	}
	

	public function Compute()
	{

		$this->ReckonColor();
		
		if($this->min<0)
			$this->distanceMaxY=abs($this->max)+abs($this->min);
		else
			$this->distanceMaxY=abs($this->max);
		//echo $this->distanceMaxY, " ",$this->max," ",$this->min;
		if($this->indexesArray ==null)
		{
			$this->distanceMaxX=abs($this->xend)+abs($this->xbegin);
		}
		else
			$this->distanceMaxX=abs($this->indexesArray[count($this->indexesArray)-1])+abs($this->indexesArray[0]);
			
		$this->drawingZone=array(($this->width*15/100),($this->height*5/100),($this->width-($this->width*20/100)),($this->height-($this->height*10/100)));
		if($this->distanceMaxY == 0)
		{
			$this->distanceMaxY=$this->drawingZone[3];
			 $this->maxY =$this->distanceMaxY/2;
		}
		if($this->distanceMaxX == 0)
		{
			$this->distanceMaxX=$this->drawingZone[2];
			 $this->maxX =$this->distanceMaxX/2;
		}
		
		$stepy=$this->drawingZone[3]/$this->distanceMaxY;
		
		if($this->count!=0)
			$stepx=$this->drawingZone[2]/$this->distanceMaxX;
		else
			$stepx=0;

		$this->axeX=array($this->drawingZone[0],$this->drawingZone[1]+($this->max*$stepy),$this->drawingZone[0]+$this->drawingZone[2],$this->drawingZone[1]+($stepy*$this->max));
		
		if($this->indexesArray ==null)
			$this->axeY=array($this->drawingZone[0]+(abs($this->xbegin)*$stepx),$this->drawingZone[1],$this->drawingZone[0]+(abs($this->xbegin)*$stepx),$this->drawingZone[1]+$this->drawingZone[3]);
		else
			$this->axeY=array($this->drawingZone[0]+(abs($this->indexesArray[0])*$stepx),$this->drawingZone[1],$this->drawingZone[0]+(abs($this->indexesArray[0])*$stepx),$this->drawingZone[1]+$this->drawingZone[3]);
		
		
		
		
		
			$gradV = $this->nb_grad*$stepy;
			//echo $this->distanceMaxY;
		for($p =0;$p<=$this->distanceMaxY;$p+=$this->nb_grad/*$this->drawingZone[1];$p<=$this->axeY[3];$p +=$gradV*/ )
		{
			if(round($this->axeY[1], 2)!=round($p, 10))
				$valeur = $p;
			else 
				$valeur = 0;

			$this->graduationV[]=array($this->axeY[0]-($this->width*0.005),$this->axeX[1]-($p*$stepy),$this->axeY[0],$this->axeX[1]-($p*$stepy),$valeur);
		}

	

		/*	if($this->indexesArray ==null)
			{*/
				for($k=0;$k < $this->count;$k++)
					{
						$one = $this->values[$k];
						
						$newtab =array();
						
						foreach($one['values'] as $key => $value)
						{
							//echo $key," ",$value,"<br/>";
							if($key>=0)
								$key=$key*$stepx+$this->axeY[0];
							else if($key<0)
								$key=$this->axeY[0]-abs($key)*$stepx;
						
							if($value>=0)
								$value=$this->axeX[1] - $value*$stepy;
							else if($value<0)
								$value=abs($value)*$stepy+$this->axeX[1];
						
							$newtab[$key]=$value;
						}
					
			/*}
			else
			{
					foreach($this->indexesArray as $index)
					{
						$one = $this->values[$index];
						
						$newtab =array();
						echo count($one['values'])," ",$k,"<br/>";
						foreach($one['values'] as $key => $value)
						{
							if($key>=0)
								$key=$key*$stepx+$this->axeY[0];
							else if($key<0)
								$key=$this->axeY[0]-abs($key)*$stepx;
						
							if($value>=0)
								$value=$this->axeX[1] - $value*$stepy;
							else if($value<0)
								$value=abs($value)*$stepy+$this->axeX[1];
						
							$newtab[$key]=$value;
						}
			}*/
			
			
			$this->values[$k]['newvalues']=$newtab;

		}
	

	}
	
	public function display()
	{
		$page .= $this->start();
		
		$page .='<rect id="bg" x="0" y="0" width="'.$this->width.'" height="'.$this->height.'" style="fill: #fff; stroke: black;" />'.
		'<line x1="'.$this->axeX[0].'" y1="'.$this->axeX[1].'" x2="'.$this->axeX[2].'" y2="'.$this->axeX[3].'" stroke="black" stroke-linecap="round"/>'.//X axy
		'<line x1="'.$this->axeY[0].'" y1="'.$this->axeY[1].'" x2="'.$this->axeY[2].'" y2="'.$this->axeY[3].'" stroke="black" stroke-linecap="round"/>'. // y axy
		'<text id="title" x = "'.($this->width/2).'" y = "'.($this->axeY[1]/2).'" fill = "navy" font-size = "10" > '.$this->title.' </text>';
		
		foreach($this->graduationV as $grad)
		{
          $page .='<line x1="'.($grad[0]).'" y1="'.($grad[1]).'" x2="'.$grad[2].'" y2="'.$grad[3].'" stroke="black"  stroke-linecap="round"/>';
          $page .= '<text x = "'.($grad[0]-($this->width*0.005)).'" y = "'.($grad[1]+($this->height*0.005)).'" fill = "navy" text-anchor="end" font-size = "10"> '.$grad[4].' </text>';				
		}
		
		if(!empty($this->xtitle))
		{
			$page .= '<text x = "'.($this->axeX[0]+$this->axeX[2]/2).'" y = "'.($this->axeX[1]+($this->height*0.035)).'" fill = "navy" text-anchor="end" font-size = "10"> '.$this->xtitle.' </text>';				
		}
		if(!empty($this->ytitle))
		{
			 $page .='<g style="writing-mode:tb;glyph-orientation-vertical:0;">'.
					  '<text x ="'.($this->axeY[0]-($this->width*0.085)).'" y="'.(($this->axeY[1]+$this->axeY[3])/2).'" fill = "navy" text-anchor="middle" font-size = "10">'.$this->ytitle.'</text></g>';
		}
	/*foreach($this->graduationH as $grad)
	{
        $page .='<line x1="'.($grad[0]).'" y1="'.($grad[1]).'" x2="'.$grad[2].'" y2="'.$grad[3].'" stroke="black" stroke-linecap="round"/>';
 
	}*/
	
		foreach($this->values as $one)
		{
			
			$page .='<g class="polyline2"><polyline  stroke-width="1"
    points="';
			foreach($one['newvalues'] as $key => $value)
			{
				$page .=($key).','.($value).' ';
			}
			
			$page .='" /></g> ';
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$page .=$this->end();
		
		
		return $page;
	}
}
?>
