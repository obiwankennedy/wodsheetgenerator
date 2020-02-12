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
*/

/**
 * \author:Renaud Guezennec 
 * Contact me: http://renaudguezennec.homelinux.org/index,1,3.html
 * 
 * 
 * \class KiviatChart
 * \brief displays a kiviat chart (Radar chart)
 * \version 0.1
 * \date 28/03/2009
 */
class KiviatChart extends Chart
{
	public $max;
	public $min;
	public $drawingZone;
	public $graduation;
	public $nb_grad;
	public $axis;
	public $nb_axes;
	public $lineAxis;
	public $middle;
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
			 $this->axis = array();
			 $this->max = -1;
			 $this->min = -1;
			 $this->nb_axes = -1;
			 $this->lineAxis = array();
			 $this->middle=array();
	}
	public function SetScale($sc)
	{
		$this->nb_grad = $sc;
	}
	public function setAxis($axes)
	{
		if((is_array($axes))&&(count($axes)>1))
		{
		 $this->axis = $axes;
		 $this->nb_axes= count($axes);
		}
	}
	public function AddData($title,$value,$color=null)
	{
		$temp=array();
		$temp['title']=$title;
		$temp['values']=$value;
		
		if( $this->nb_axes == -1)//I take the keys of data as axis name.
		{
			$this->nb_axes = count($value);
			foreach($value as $key => $temp2)
			{
				$this->axis[] = $key;
			}
			
		}
		
		if(count($value)!=$this->nb_axes)
			die("All values must have the same number of axis");
			
		if($this->colortype!=NORMAL)
		{
			$temp['color']=$color;	
		}
		foreach($value as $key => $temp3)
			{
				
				if($this->min==-1)
				{
					$this->min = $temp3;
					$this->max = $temp3;
				}
				
				if($temp3 < $this->min)
					$this->min = $temp3;
				
				if($temp3 > $this->max)
					$this->max = $temp3;
			}
		
		
		$this->values[] = $temp;
		$this->count++;
	}

	public function Compute()
	{
		
		$this->ReckonColor();
		$this->middle['x'] = $this->width/2;
		$this->middle['y'] = $this->height/2;
		
		
		
		
		
		$this->drawingZone=array(($this->width*15/100),($this->height*5/100),($this->width-($this->width*20/100)),($this->height-($this->height*10/100)));
		
		
		
		
		//angle between two axis
		$angle = 360/$this->nb_axes;
		
		$radius = $this->height / 3;

		$scale = $radius / $this->max;
		//echo $radius;
		$i = 0;
		$angledone = 0;
		foreach($this->axis as $tmp)
		{
			
			$line = array();
			$line['y'] =$radius*cos(deg2rad($angledone));
			$line['x'] =$radius*sin(deg2rad($angledone));
			//echo $line['y']," ",$line['x'],"<br/>";
			$line['title']= $tmp;
			$this->lineAxis[] = $line;
			$angledone += $angle;
			$i++;
		}
		
		/*********Graduation  **********************/
		
		
		$this->graduation = array();
		$pas = $this->max/$this->nb_grad;
		//echo $this->max;
		for($j = 0;$j<=$this->max;$j+=$pas)
		{
			$temparray = array();
			$temparray['y']=($j*$radius)/$this->max;
			$temparray['value']= $j;
			$this->graduation[] = $temparray; 
		}
		
		
		
		

		for($k=0;$k < $this->count;$k++)
		{
			$i = 0;
			$angledone = 0;
			$pointslist=array();
			$tabtemp = $this->values[$k]['values'] ;
			//print_r($tabtemp);
			foreach($tabtemp as $values)
			{
				//print_r($values);
				$point = array();
				$point['y'] =($values*$scale)*cos(deg2rad($angledone));
				$point['x'] =($values*$scale)*sin(deg2rad($angledone));
			
				
				$pointslist[] = $point;
				$angledone += $angle;
				$i++;
				
				
				
			}
			$pointslist[] = $pointslist[0];
			$this->values[$k]['path'] = $pointslist;
		}
		
		
		
		/*
		
		if($this->distanceMax == 0)
		{
			$this->distanceMax=$this->drawingZone[3];
			 $this->max =$this->distanceMax/2;
		}
		
		$stepy=$this->drawingZone[3]/$this->count;
		if($this->count!=0)
		$stepx=$this->drawingZone[2]/$this->distanceMax;
		else
		$stepx=0;
		
		
		$this->axeY=array($this->drawingZone[0],$this->drawingZone[1],$this->drawingZone[0],$this->drawingZone[1]+$this->drawingZone[3]);
		
		
		$gradV = $this->nb_grad*$stepy;
	
	for($k=0;$k < $this->count;$k++)
		{
			$temp = $this->values[$k];
			$temp['rect'] = array($this->axeY[0],$this->axeY[1]+$stepy*$k,$stepx*$temp['value'],$stepy);
			$this->values[$k]=$temp;
		}
	*/

	}
	
	public function display()
	{
		$page .= $this->start();
		
		
		
		
		$page .='<rect id="bg" x="0" y="0" width="'.$this->width.'" height="'.$this->height.'" style="fill: #DDD;" />
		<text id="title" x = "'.($this->width/2).'" y = "'.($this->drawingZone[1]/2).'" fill = "navy" font-size = "10" > '.$this->title.' </text>';
		
		
		
		
		
		
		
		
		$m = 0;
		foreach($this->lineAxis as $axe)
		{
			
			if((round($axe['x'],0)==0))
				$class='gradutatoinh';
			else if($axe['x']<0)
				$class='textleft';
			else
				$class='textright';
				
			//echo $axe['x'],",",$class,"<br/>";
				
			$page .= '<line x1="'.$this->middle['x'].'" y1="'.$this->middle['y'].'" x2="'.($this->middle['x']+$axe['x']).'" y2="'.($this->middle['y']-$axe['y']).'" stroke="black" stroke-linecap="round"/>
			<text class="'.$class.'" x = "'.($this->middle['x']+$axe['x']+(($axe['x'])/10)).'" y = "'.($this->middle['y']-$axe['y']-(($axe['y'])/10)).'" fill = "navy" font-size = "8" >'.$axe['title'].' </text>';
			
			
			$m++;
		}
		
		
		
		foreach($this->graduation as $grade)
		{
			
			
			$page .= '<line x1="'.$this->middle['x'].'" y1="'.($this->middle['y']-$grade['y']).'" x2="'.($this->middle['x']+5).'" y2="'.($this->middle['y']-$grade['y']).'" stroke-width="0.5" stroke="black" stroke-linecap="round"/>
			<text class="gradright" x = "'.($this->middle['x']+5).'" y = "'.($this->middle['y']-$grade['y']).'" fill = "navy" font-size = "8" >'.$grade['value'].' </text>';
			
			
			
		}
		foreach($this->values as $one)
		{
			
			$page .= '<g class="polyline"><polyline  fill= "'.$one['color'].'" stroke="'.$one['color'].'" stroke-width="1"  title="'.$one['title'].'" points="';
			$bo = false;
			foreach($one['path'] as $onevalue)
			{
				if($bo)
				{
					$page .= ' ';
					
				}	
				$page .= ($this->middle['x']+$onevalue['x']).','.($this->middle['y']-$onevalue['y']);
				$bo = true;
			}
			$page .= '"/><title>'.$one['title'].'</title></g>';
		}
		
		
		

		$page .=$this->end();
		
		
		return $page;
	}
}
?>
