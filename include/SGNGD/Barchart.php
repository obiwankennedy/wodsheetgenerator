<?php
/*
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
 */

/**
 * \author:Renaud Guezennec 
 * Contact me: http://renaudguezennec.homelinux.org/index,1,3.html
 * 
 * 
 * \class BarChart
 * \brief This class displays a BarChart. 
 * \version 0.1
 * \date 28/03/2009
 */
class BarChart extends Chart
{
	public $max;///< maximum value of the Y range
	public $min;///< minimum value of the Y range
	public $drawingZone; ///< Array representing the drawing zone
	public $axisX;///< Array: geometry of X Axis
	public $axisY;///< Array: geometry of Y Axis
	public $graduationH;///< Array of Lines for horizontal graduation
	public $graduationV;///< Array of lines for vertical graduation
	public $nb_grad;///< preferred number of graduation
	
	/**
	 * \fn public function __construct($m_title = null,$typecolor=NORMAL)
	 * \brief Constructor of BarChart
	 *
	 * \param $m_title : title of the graph 
	 * \param $typecolor : Color policy
	 * \return 
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
			 
	}
	/**
	 * \fn public function SetScale($sc)
	 * \brief define the Y scale, if it is not defined this value is calculated
	 *
	 * \param $sc : the scale (integer) 
	 * \return 
	 */
	public function SetScale($sc)
	{
		$this->nb_grad = $sc;
	}
	/**
	 * \fn public function AddData($title,$value,$color=null)
	 * \brief allows you to add a new value. A value in the Barchar is a bar.
	 *
	 * \param $title : the title of the new value, 
	 * \param $value : the numeric value ,
	 * \param $color : define the color of these data
	 * 
	 * 
	 */
	public function AddData($title,$value,$color=null)
	{
		$temp=array();
		$temp['title']=$title;
		$temp['value']=$value;
		if($this->colortype!=NORMAL)
		{
			$temp['color']=$color;	
		}
		
		$this->values[] = $temp;
		$this->count++;
	}
	/**
	 * \fn public function Compute()
	 * \brief Compute all data needed for the chart.
	 *
	 */
	public function Compute()
	{
		
		$this->ReckonColor();
		for($j=0;$j < $this->count;$j++)
		{
			$temp = $this->values[$j];
			if($j==0)
			{
				if($temp['value']>0)
				{
					$this->max=$temp['value'];
					$this->min=0;
				}
				else
				{
					$this->max=0;
					$this->min=$temp['value'];
				}
			}
			if($temp['value']<$this->min)
			$this->min   = $temp['value'];
			
			if($temp['value']>$this->max)
			$this->max = $temp['value'];
		}
		$this->distanceMax=abs($this->max)+abs($this->min);
		$this->drawingZone=array(($this->width*15/100),($this->height*5/100),($this->width-($this->width*20/100)),($this->height-($this->height*10/100)));
		if($this->distanceMax == 0)
		{
			$this->distanceMax=$this->drawingZone[3];
			 $this->max =$this->distanceMax/2;
		}
		//echo $this->distanceMax;
		$stepy=$this->drawingZone[3]/$this->distanceMax;
		if($this->count!=0)
		$stepx=$this->drawingZone[2]/$this->count;
		else
		$stepx=0;
		//echo $this->max.' ='.$stepy;
		$this->axisX=array($this->drawingZone[0],$this->drawingZone[1]+($this->max*$stepy),$this->drawingZone[0]+$this->drawingZone[2],$this->drawingZone[1]+($stepy*$this->max));
		$this->axisY=array($this->drawingZone[0],$this->drawingZone[1],$this->drawingZone[0],$this->drawingZone[1]+$this->drawingZone[3]);
		
		//$gradV = ($this->distanceMax*$stepy) / $this->nb_grad;
		$gradV = $this->nb_grad*$stepy;
		//echo $gradV/$stepy;
		for($p =$this->drawingZone[1];$p<=$this->axisY[3];$p +=$gradV )
		{
			if(round($this->axisX[1], 2)!=round($p, 10))
				$valeur = ($this->axisX[1]-$p)/$stepy;
			else 
				$valeur = 0;
			/*echo $stepy.' '.$valeur.' '.$this->axisX[1].' '.$p.'
			<br/>';*/
			$this->graduationV[]=array($this->axisY[0]-($this->width*0.005),$p,$this->axisY[0],$p,$valeur);
		}
	for($k=0;$k < $this->count;$k++)
		{
			$temp = $this->values[$k];
			
			if($temp['value']>0)
				$temp['rect']=array($this->drawingZone[0]+1+$stepx*$k,$this->axisY[1]+(($this->max-$temp['value'])*$stepy),$stepx-1,$stepy*$temp['value']);
			else if($temp['value']<0)
				$temp['rect']=array($this->drawingZone[0]+1+$stepx*$k,$this->axisX[1],$stepx-1,$stepy*abs($temp['value']));
			else
				$temp['rect']=array($this->drawingZone[0]+1+$stepx*$k,$this->axisX[1],$this->drawingZone[0]+1+$stepx*$k+$stepx-1,$this->axisX[1]);
			
			
			
			
			
			$this->values[$k]=$temp;
		}
	/*for($m = 0 ;$m<$this->count;$m++)
		{
          $page .='<line x1="'.($this->axisY[0]-5).'" y1="'.($this->axisY[1]+$this->).'" x2="'.$this->axisX[0].'" y2="'.$this->axisY[3].'" stroke="black" stroke-linecap="round"/>';			
		}*/
		
		
		//print_r($this->drawingZone);

	}
	/**
	 * \fn public function display()
	 * \brief generate the SVG code and return it.
	 *
	 * 
	 * \return the SVG code.
	 */
	public function display()
	{
		$page .= $this->start();
		
		$page .='<rect id="bg" x="0" y="0" width="'.$this->width.'" height="'.$this->height.'" style="fill: #fff; stroke: black;" />
		<line x1="'.$this->axisX[0].'" y1="'.$this->axisX[1].'" x2="'.$this->axisX[2].'" y2="'.$this->axisX[3].'" stroke="black" stroke-linecap="round"/>
		<line x1="'.$this->axisY[0].'" y1="'.$this->axisY[1].'" x2="'.$this->axisY[2].'" y2="'.$this->axisY[3].'" stroke="black" stroke-linecap="round"/>
		<text id="title" x = "'.($this->width/2).'" y = "'.($this->axisY[1]/2).'" fill = "navy" font-size = "10" > '.$this->title.' </text>';
		
		foreach($this->graduationV as $grad)
		{
          $page .='<line x1="'.($grad[0]).'" y1="'.($grad[1]).'" x2="'.$grad[2].'" y2="'.$grad[3].'" stroke="black" stroke-linecap="round"/>';
          $page .= '<text x = "'.($grad[0]-($this->width*0.05)).'" y = "'.($grad[1]+($this->height*0.005)).'" fill = "navy" font-size = "10"> '.$grad[4].' </text>';				
		}
		
		foreach($this->values as $one)
		{
			
			if($one['value']!=0)
			{
				
				
				$page .='
				<rect class="piece" title="'.$one['title'].': '.$one['value'].'" x="'.$one['rect'][0].'" y="'.$one['rect'][1].'" width="'.$one['rect'][2].'" height="'.$one['rect'][3].'" style="fill: '.$one['color'].'; stroke: black;" />
				';
				
				
			}
			else
			{
				$page .='
				<line class="piece" title="'.$one['title'].'" x1="'.$one['rect'][0].'" y1="'.$one['rect'][1].'" x2="'.$one['rect'][2].'" y2="'.$one['rect'][3].'" style="stroke: '.$one['color'].'; " />
				';
				
			}
			
			
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$page .=$this->end();
		
		
		return $page;
	}
}
?>
