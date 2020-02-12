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
 *  (at your option) any later version.
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
 * \class PointCloudChart
 * \brief displays many points.
 * \version 0.1
 * \date 28/03/2009
 */
class PointCloudChart extends Chart
{
	public $maxY;
	public $minY;
	public $maxX;
	public $minX;
	public $drawingZone;
	public $axeX;
	public $axeY;
	public $graduationH;
	public $graduationV;
	public $nb_grad;
	public $radius;
	
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
			 $this->radius = 1;
			 
	}
	public function setRadius($r)
	{
		$this->radius=$r;
	}
	public function SetScale($sc)
	{
		$this->nb_grad = $sc;
	}
	public function AddData($title,$valuex,$valuey,$color=null)
	{
		$temp=array();
		$temp['title']=$title;
		$temp['x']=$valuex;
		
		$temp['y']=$valuey;
		
		if(count($this->values)==0)
			{
				if($temp['y']>0)
				{
					$this->maxY=$temp['y'];
					$this->minY=0;
					
					
				}
				else
				{
					$this->maxY=0;
					$this->minY=$temp['y'];
				}
				
				if($temp['x']>0)
				{
					$this->maxX=$temp['x'];
					$this->minX=0;
					
					
				}
				else
				{
					$this->maxX=0;
					$this->minX=$temp['x'];
				}
				
				
			}
			if($temp['y']<$this->minY)
			$this->minY   = $temp['y'];
			
			if($temp['y']>$this->maxY)
			$this->maxY = $temp['y'];
			
			if($temp['x']<$this->minX)
			{
				
				$this->minX   = $temp['x'];
			}
			if($temp['x']>$this->maxX)
			{
				
				$this->maxX = $temp['x'];
			}
			
			
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
		$this->distanceMaxY=abs($this->maxY)+abs($this->minY);
		$this->distanceMaxX=abs($this->maxX)+abs($this->minX);
		//echo $this->maxX;
		//echo $this->minX;
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

		$this->axeX=array($this->drawingZone[0],$this->drawingZone[1]+($this->maxY*$stepy),$this->drawingZone[0]+$this->drawingZone[2],$this->drawingZone[1]+($stepy*$this->maxY));
		
		$this->axeY=array($this->drawingZone[0]+(abs($this->minX)*$stepx),$this->drawingZone[1],$this->drawingZone[0]+(abs($this->minX)*$stepx),$this->drawingZone[1]+$this->drawingZone[3]);
		

		$gradV = $this->nb_grad*$stepy;

		for($p =0;$p<=$this->maxY;$p+=$this->nb_grad/*$this->drawingZone[1];$p<=$this->axeY[3];$p +=$gradV*/ )
		{
			if(round($this->axeY[1], 2)!=round($p, 10))
				$valeur = $p;
			else 
				$valeur = 0;

			$this->graduationV[]=array($this->axeY[0]-($this->width*0.005),$this->axeX[1]-($p*$stepy),$this->axeY[0],$this->axeX[1]-($p*$stepy),$valeur);
		}
		$gradV = $this->nb_grad*$stepy;

		for($p =0;$p>=$this->minY;$p-=$this->nb_grad/*$this->drawingZone[1];$p<=$this->axeY[3];$p +=$gradV*/ )
		{
			if(round($this->axeY[1], 2)!=round($p, 10))
				$valeur = $p;
			else 
				$valeur = 0;

			$this->graduationV[]=array($this->axeY[0]-($this->width*0.005),$this->axeX[1]-($p*$stepy),$this->axeY[0],$this->axeX[1]-($p*$stepy),$valeur);
		}
		
		
		
		
	   $gradH = $this->nb_grad*$stepx;

		for($p =0;$p<=$this->maxX;$p += $this->nb_grad )
		{
			if(round($this->axeX[1], 2)!=round($p, 10))
				$valeur = $p;
			else 
				$valeur = 0;

			$this->graduationH[]=array($this->axeY[0]+($p*$stepx),$this->axeX[1]+($this->height*0.005),$this->axeY[0]+($p*$stepx),$this->axeX[1],$valeur);
		}
		$gradH = $this->nb_grad*$stepx;

		for($p =0;$p>=$this->minX;$p -= $this->nb_grad )
		{
			if(round($this->axeX[1], 2)!=round($p, 10))
				$valeur = $p;
			else 
				$valeur = 0;

			$this->graduationH[]=array($this->axeY[0]+($p*$stepx),$this->axeX[1]+($this->height*0.005),$this->axeY[0]+($p*$stepx),$this->axeX[1],$valeur);
		}
		
	for($k=0;$k < $this->count;$k++)
		{
			$temp = $this->values[$k];
			
			if($temp['x']>=0)
				$temp['x']=$temp['x']*$stepx+$this->axeY[0];
			else if($temp['x']<0)
				$temp['x']=$this->axeY[0]-abs($temp['x'])*$stepx;
			
			if($temp['y']>=0)
				$temp['y']=$this->axeX[1] - $temp['y']*$stepy;
			else if($temp['y']<0)
				$temp['y']=abs($temp['y'])*$stepy+$this->axeX[1];
			
			
			
			
			
			
			$this->values[$k]=$temp;
		}
	

	}
	
	public function display()
	{
		$page .= $this->start();
		
		$page .='<rect id="bg" x="0" y="0" width="'.$this->width.'" height="'.$this->height.'" style="fill: #fff; stroke: black;" />
		<line x1="'.$this->axeX[0].'" y1="'.$this->axeX[1].'" x2="'.$this->axeX[2].'" y2="'.$this->axeX[3].'" stroke="black" stroke-linecap="round"/>
		<line x1="'.$this->axeY[0].'" y1="'.$this->axeY[1].'" x2="'.$this->axeY[2].'" y2="'.$this->axeY[3].'" stroke="black" stroke-linecap="round"/>
		<text id="title" x = "'.($this->width/2).'" y = "'.($this->axeY[1]/2).'" fill = "navy" font-size = "10" > '.$this->title.' </text>';
		
		foreach($this->graduationH as $grad)
		{
          $page .='<line x1="'.($grad[0]).'" y1="'.($grad[1]).'" x2="'.$grad[2].'" y2="'.$grad[3].'" stroke="black" stroke-linecap="round"/>';
          $page .= '<text class="gradutatoinh" x = "'.($grad[0])   .'" y = "'.($grad[1]+($this->height*0.015)).'" fill = "navy" font-size = "10"> '.$grad[4].' </text>';				
		}
		foreach($this->graduationV as $grad)
		{
          $page .='<line x1="'.($grad[0]).'" y1="'.($grad[1]).'" x2="'.$grad[2].'" y2="'.$grad[3].'" stroke="black" stroke-linecap="round"/>';
          $page .= '<text x = "'.($grad[0]-($this->width*0.05)).'" y = "'.($grad[1]+($this->height*0.005)).'" fill = "navy" font-size = "10"> '.$grad[4].' </text>';				
		}
		foreach($this->values as $one)
		{
			
		
				
				$page .='
				<circle title="'.$one['title'].'" cx="'.$one['x'].'" cy="'.$one['y'].'" r="'.$this->radius.'" fill="'.$one['color'].'" stroke="'.$one['color'].'" stroke-width="0" />
				';
				
				
		
				
				
		
			
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$page .=$this->end();
		
		
		return $page;
	}
}
?>
