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
 * \class HBarChart
 * \brief displays a horizontal bar chart
 * \version 0.1
 * \date 28/03/2009
 */
class HBarChart extends Chart
{
	public $max;
	public $min;
	public $drawingZone;
	public $axeX;
	public $axeY;
	public $graduationH;
	public $graduationV;
	public $nb_grad;
	public $sort;
	
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
			 $this->sort = 1; //1 == descending, 2==ascending, 0 == no sorting
			 
	}
	public function SetScale($sc)
	{
		$this->nb_grad = $sc;
	}
	public function SetSort($i)
	{
		 $this->sort = $i;
	}
	public function AddData($title,$value,$color=null)
	{
		$temp=array();
		$temp['title']=$title;
		$temp['value']=$value;
		if($this->colortype!=NORMAL)
		{
			$temp['color']=$color;	
		}
		
		//
		
			$this->values[] = $temp;
		
			
		$this->count++;
	}
	public function dicotomyAdd($taille)
	{

	    for($i = 0; $i < $taille; $i++)
	    {
	        $element_a_inserer = $this->values[$i];
	        for($j = 0; $j < $i; $j++)
	        {
	            $element_courant = $this->values[$j];
	            if ($element_a_inserer['value'] > $element_courant['value'])
	            {
	                $this->values[$j] = $element_a_inserer;
	                $element_a_inserer = $element_courant;
	            }  
	        }
	       $this->values[$i] = $element_a_inserer;
    	}
	}
	public function dicotomyAdd2($taille)
	{

	    for($i = 0; $i < $taille; $i++)
	    {
	        $element_a_inserer = $this->values[$i];
	        for($j = 0; $j < $i; $j++)
	        {
	            $element_courant = $this->values[$j];
	            if ($element_a_inserer['value'] < $element_courant['value'])
	            {
	                $this->values[$j] = $element_a_inserer;
	                $element_a_inserer = $element_courant;
	            }  
	        }
	       $this->values[$i] = $element_a_inserer;
    	}
	}
	public function Compute()
	{
		if($this->sort == 1 )
			$this->dicotomyAdd($this->count);
		else if($this->sort == 2 )
			$this->dicotomyAdd2($this->count);
			
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
	

	}
	
	public function display()
	{
		$page .= $this->start();
		
		$page .='<rect id="bg" x="0" y="0" width="'.$this->width.'" height="'.$this->height.'" style="fill: #fff; stroke: black;" />
		<line x1="'.$this->axeX[0].'" y1="'.$this->axeX[1].'" x2="'.$this->axeX[2].'" y2="'.$this->axeX[3].'" stroke="black" stroke-linecap="round"/>
		<line x1="'.$this->axeY[0].'" y1="'.$this->axeY[1].'" x2="'.$this->axeY[2].'" y2="'.$this->axeY[3].'" stroke="black" stroke-linecap="round"/>
		<text id="title" x = "'.($this->width/2).'" y = "'.($this->axeY[1]/2).'" fill = "navy" font-size = "10" > '.$this->title.' </text>';
		

		
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
			
			 $page .= '<text class="textleft" x = "'.$this->axeY[0].'" y = "'.($one['rect'][1]+$one['rect'][3]/2).'" fill = "navy" font-size = "10"> '.$one['title'].' </text>';
			 
			 $classcss="textleft";
			 
			 if($one['value']<$this->max/2)
			 	$classcss="textright";
			 	
			 $page .= '<text class="'.$classcss.'" x = "'.($one['rect'][0]+$one['rect'][2]).'" y = "'.($one['rect'][1]+$one['rect'][3]/2).'" fill = "navy" font-size = "10"> '.$one['value'].' </text>';				
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$page .=$this->end();
		
		
		return $page;
	}
}
?>
