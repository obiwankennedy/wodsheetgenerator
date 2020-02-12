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
 * \class Barchart3D
 * \brief This class displays a bar chart in 3D. 
 * \version 0.1
 * \date 28/03/2009
 */
class Barchart3D extends Chart
{
	public $max;
	public $min;
	public $drawingZone;
	public $axeX;
	public $axeY;
	public $graduationH;
	public $graduationV;
	public $nb_grad;
	public $draw_average;
	public $average;
	
	public function __construct($m_title = null,$draw_average = true,$typecolor=NORMAL)
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
			 $this->graduationH = array();
			 $this->draw_average = $draw_average;
			 $this->average = 0;
	}
	public function SetScale($sc)
	{
		$this->nb_grad = $sc;
	}
	public function AddData($title,$value,$color=null)
	{
		$temp=array();
		$temp['title']=$title;
		$temp['value']=$value;
		if($this->draw_average)
			$this->average += $value;
		if($this->colortype!=NORMAL)
		{
			$temp['color']=$color;	
		}
		
		$this->values[] = $temp;
		$this->count++;
	}
	public function Compute()
	{
		
		$this->ReckonColor();
		if($this->draw_average)
			$this->average /= $this->count;
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
		$this->axeX=array($this->drawingZone[0],$this->drawingZone[1]+($this->max*$stepy),$this->drawingZone[0]+$this->drawingZone[2],$this->drawingZone[1]+($stepy*$this->max));
		$this->axeY=array($this->drawingZone[0],$this->drawingZone[1],$this->drawingZone[0],$this->drawingZone[1]+$this->drawingZone[3]);
		
		$gradH = ($this->count*$stepx);
		$gradV = $this->nb_grad*$stepy;
	
		for($p =$this->drawingZone[1];$p<=$this->axeY[3];$p +=$gradV )
		{
			if(round($this->axeX[1], 2)!=round($p, 10))
				$valeur = ($this->axeX[1]-$p)/$stepy;
			else 
				$valeur = 0;

			$this->graduationV[]=array(
			$this->axeY[0]-($this->width*0.005),
			$p,
			$this->axeY[0],
			$p,
			$valeur,
			($this->axeY[0])+($stepx/5)*sin(deg2rad(45)),
			($p)-($stepx/5)*cos(deg2rad(45)),
			($this->drawingZone[2]+$this->axeY[0]),
			($p)-($stepx/5)*cos(deg2rad(45)));
		}
		
		for($p =$this->drawingZone[0];$p<=$this->axeX[2];$p +=$stepx )
		{
			if(round($this->axeX[1], 2)!=round($p, 10))
				$valeur = ($this->axeX[1]-$p)/$stepy;
			else 
				$valeur = 0;

			$this->graduationH[]=array($p,$this->axeX[1],$p,$this->axeX[1]-($this->height*0.02),$valeur);
		}
	
	for($k=0;$k < $this->count;$k++)
		{
			$temp = $this->values[$k];
			
			if($temp['value']>0)
			{
				$temp['rect']=array($this->drawingZone[0]+1+$stepx*$k+($stepx/4),
				$this->axeY[1]+(($this->max-$temp['value'])*$stepy),
				$stepx-($stepx/2),
				$stepy*$temp['value'],
				($this->drawingZone[0]+1+$stepx*$k+($stepx/4))+($stepx/5)*sin(deg2rad(45)),
				$this->axeY[1]+(($this->max-$temp['value'])*$stepy)-($stepx/5)*cos(deg2rad(45)),
				($this->drawingZone[0]+1+$stepx*$k+($stepx/4)+($stepx/2))+($stepx/5)*sin(deg2rad(45)),
				($this->axeY[1]+(($this->max-$temp['value'])*$stepy))-($stepx/5)*cos(deg2rad(45)),
				$this->drawingZone[0]+1+$stepx*$k+($stepx/4)+$stepx-($stepx/2)+($stepx/5)*sin(deg2rad(45)),
				$this->axeY[1]+(($this->max-$temp['value'])*$stepy)+$stepy*$temp['value']-($stepx/5)*sin(deg2rad(45)));
			}
			else if($temp['value']<0)
			{
				$temp['rect']=array($this->drawingZone[0]+1+$stepx*$k+($stepx/4),
				$this->axeX[1],
				$stepx-($stepx/2),
				$stepy*abs($temp['value']),
				($this->drawingZone[0]+1+$stepx*$k+($stepx/4))*cos(deg2rad(45)),
				($this->axeX[1])*sin(deg2rad(45)),
				($this->drawingZone[0]+1+$stepx*$k+($stepx/4)+($stepx/2))+($stepx/5)*sin(deg2rad(45)),
				($this->axeY[1]+(($this->max-$temp['value'])*$stepy))-($stepx/5)*cos(deg2rad(45)),
				$this->drawingZone[0]+1+$stepx*$k+($stepx/4)+$stepx-($stepx/2)+($stepx/5)*sin(deg2rad(45)),
				$this->axeY[1]+(($this->max-$temp['value'])*$stepy)+$stepy*$temp['value']-($stepx/5)*sin(deg2rad(45)));
			}
			else
			{
				$temp['rect']=array($this->drawingZone[0]+1+$stepx*$k+($stepx/4),$this->axeX[1],$this->drawingZone[0]+1+$stepx*$k+$stepx-($stepx/2),$this->axeX[1]);
			
			}			
			$this->values[$k]=$temp;
		}
		if($this->draw_average)
        {
            //echo $this->average." ".$this->drawingZone[0]." ".($stepx*$this->average)." ".$stepx ;
			$this->average = array($this->axeY[0],$this->axeY[1]+(($this->max-$this->average)*$stepy),$this->axeX[2],$this->axeY[1]+(($this->max-$this->average)*$stepy));
        }

	}
	
public function display()
{
	$page .= $this->start();
	
	$page .='<rect id="bg" x="0" y="0" width="'.$this->width.'" height="'.$this->height.'" style="fill: #fff; stroke: black;" />
	<line x1="'.$this->axeX[0].'" y1="'.$this->axeX[1].'" x2="'.$this->axeX[2].'" y2="'.$this->axeX[3].'" stroke="black" stroke-linecap="round"/>
	<line x1="'.$this->axeY[0].'" y1="'.$this->axeY[1].'" x2="'.$this->axeY[2].'" y2="'.$this->axeY[3].'" stroke="black" stroke-linecap="round"/>
	<text id="title" x = "'.($this->width/2).'" y = "'.($this->axeY[1]/2).'" fill = "navy" font-size = "10" > '.$this->title.' </text>';
	
	foreach($this->graduationV as $grad)
	{
	  $page .='<line x1="'.($grad[0]).'" y1="'.($grad[1]).'" x2="'.$grad[2].'" y2="'.$grad[3].'" stroke="black" stroke-linecap="round"/>';
	  $page .='<line x1="'.($grad[2]).'" y1="'.($grad[3]).'" x2="'.$grad[5].'" y2="'.$grad[6].'" stroke="grey" stroke-linecap="round"/>';
	  $page .='<line x1="'.($grad[5]).'" y1="'.($grad[6]).'" x2="'.$grad[7].'" y2="'.$grad[8].'" stroke="grey" stroke-linecap="round"/>';
	  $page .= '<text x = "'.($grad[0]-($this->width*0.05)).'" y = "'.($grad[1]+($this->height*0.005)).'" fill = "navy" font-size = "10"> '.$grad[4].' </text>';				
	}
	foreach($this->graduationH as $grad)
	{
        $page .='<line x1="'.($grad[0]).'" y1="'.($grad[1]).'" x2="'.$grad[2].'" y2="'.$grad[3].'" stroke="black" stroke-linecap="round"/>';
 
	}
	foreach($this->values as $one)
	{
		if($one['value']!=0)
		{	
			$page .= '<g class="piece" title="'.$one['title'].': '.$one['value'].'">';
			$page .='
			<rect class="piece"  x="'.$one['rect'][0].'" y="'.$one['rect'][1].'" width="'.$one['rect'][2].'" height="'.$one['rect'][3].'" style="fill: '.$one['color'].'; stroke: black;" />
			';
			if($one['value']>0)
			{
			$page .='<polygon class="piece" style="fill: '.$one['color'].'; stroke: black;"
	points="'.$one['rect'][0].','.($one['rect'][1]).' '.($one['rect'][0]+$one['rect'][2]).','.($one['rect'][1]).' '.$one['rect'][6].','.$one['rect'][7].' '.$one['rect'][4].','.$one['rect'][5].' " /> 
			';
			$page .='<polygon class="piece" style="fill: '.$one['color'].'; stroke: black;"
	points="'.($one['rect'][0]+$one['rect'][2]).','.($one['rect'][1]).' '.$one['rect'][6].','.$one['rect'][7].' '.$one['rect'][8].','.$one['rect'][9].' '.($one['rect'][0]+$one['rect'][2]).','.($one['rect'][1]+$one['rect'][3]).'" /> 
			';
			}
			else
			$page .='<polygon class="piece" style="fill: '.$one['color'].'; stroke: black;"
	points=" 	'.$one['rect'][8].','.$one['rect'][9].'   
				'.($one['rect'][0]+$one['rect'][2]).','.($one['rect'][1]).' 
				'.($one['rect'][0]+$one['rect'][2]).','.($one['rect'][1]+$one['rect'][3]).'
				'.$one['rect'][6].','.$one['rect'][7].' 
				 " /> 
			';
			
			$page .= '</g>';
		}
		else
		{
			$page .='
			<line class="piece" title="'.$one['title'].'" x1="'.$one['rect'][0].'" y1="'.$one['rect'][1].'" x2="'.$one['rect'][2].'" y2="'.$one['rect'][3].'" style="stroke: '.$one['color'].'; " />
			';
			
		}

    if($this->draw_average)
    $page .='
			<line class="line" title="'.$one['Average'].'" x1="'.$this->average[0].'" y1="'.$this->average[1].'" x2="'.$this->average[2].'" y2="'.$this->average[3].'" style="stroke: red; " />
			';
	}
	$page .=$this->end();	
	return $page;
}
}
?>
