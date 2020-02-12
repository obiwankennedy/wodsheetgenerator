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
 * 
*/

/**
 * \author:Renaud Guezennec 
 * Contact me: http://renaudguezennec.homelinux.org/index,1,3.html
 * 
 * 
 * \class PieChart
 * \brief displays a pie chart.
 * \version 0.1
 * \date 28/03/2009
 */
class PieChart extends Chart
{
	
	public $drawingZone;
	public $Circle; 
	public $rayon;
	public $Sum; 
    public $ceil;
    public $ceilTitle;
    public $ceiltab;

	public function __construct($m_title = null,$typecolor=NORMAL)
	{
			 $this->canvasx=0;
			 $this->canvasy=0;
			 $this->width=650;
			 $this->height=450;
			 $this->values=array();
			 $this->drawingZone = array();
			 $this->rayon= 200;
			 $this->Circle = array($this->width/2,$this->height/2,$this->rayon);
			 $this->legend=false;
			 $this->colortype=$typecolor;
			 $this->startColor= new Color(255,255,255);
			 $this->endColor = new Color(0,0,0);
			 $this->count = 0;
			 $this->nb_grad = 4;
			 $this->title = $m_title;
			 $this->ceil = -1;
			 $this->Sum=0;
			 $this->ceiltab = array();
	}
	public function SetScale($sc)
	{
		$this->nb_grad = $sc;
	}
    public function Setlimit($ceil,$title,$faraway)
    {
        $this->ceil = $ceil;
        
        $this->ceiltab['title'] =$title;
        $this->ceiltab['faraway'] = $faraway;
        $this->ceiltab['value'] = 0;
	$this->ceiltab['color']=$this->endColor;
		    $this->values[] = $ceiltab;
		    $this->count++;

    }
	public function AddData($title,$value,$faraway,$color=null)
	{

      

		    $this->Sum +=$value; 
		    $temp=array();
		    $temp['title']=$title;
		    $temp['value']=$value;
		    $temp['faraway']=$faraway;
		    if($this->colortype!=NORMAL)
		    {
			    $temp['color']=$color;	
		    }
		
		    $this->values[] = $temp;
		    $this->count++;

	}
    public function addCeil($value)
    {
	//    echo $this->ceiltab['value']," aa ",$this->count-1," ",$value ."<br/>";
            $this->ceiltab['value'] = $this->ceiltab['value'] + $value;

    }
	public function Compute()
	{
        
		
		
		
		$angledone=0;
		$Lastpoint=array(0,-$this->rayon);
		$direction = 0;
		$swap = 0;
		$value2 = array();
		//print_r($this->values);
		for($k=0;$k <= $this->count;$k++)
		{
			
			if($k == $this->count)
			{
				$temp =$this->ceiltab;
				$temp['angle']=(360*$temp['value'])/100;
			}
			else
			{
				$temp=$this->values[$k];
				$temp['value']=($temp['value']*100)/$this->Sum;
				$temp['angle']=(360*$temp['value'])/100;
			}
		/*	if($k == $this->count)
			{
				//$temp =$this->ceiltab;
				//print_r($temp);
			}*/

			if($temp['value']<$this->ceil)
			{
			//	echo $temp['value'],",",$this->ceil," ",$k,"<br/>";
				$this->addCeil($temp['value']);
				
				//$this->count--;
			}
			else
			{
			            $angle = $temp['angle'];
			            $y=$this->rayon*cos(deg2rad($angledone+$angle));
			            $x=$this->rayon*sin(deg2rad($angledone+$angle));
			
			
			            $destx=-1*$Lastpoint[0]+$x;
			
			            if($angledone+$temp['angle']<=180)
				            $desty=-1*$Lastpoint[1]+(-1*$y);
			            else
				            $desty=-1*$Lastpoint[1]+(-1*$y);

			            if($temp['angle']<=270)//$angledone+
				            $direction = 0;
			            else if($temp['angle']>=270)
				            $direction = 1;
			
		
				
			            $temp['angle']=$angle;
			            if(!$temp['faraway'])
				            $temp['path']=array($this->Circle[0],$this->Circle[1],$Lastpoint[0],$Lastpoint[1],$this->rayon,$this->rayon,0,$direction,1,$destx,$desty);
			            else
			            {
							            $miniy=($this->rayon/20)*cos(deg2rad($angledone+($angle/2)));
							            $minix=($this->rayon/20)*sin(deg2rad($angledone+($angle/2)));
				            $temp['path']=array($this->Circle[0]+($minix),$this->Circle[1]+(-1*$miniy),$Lastpoint[0],$Lastpoint[1],$this->rayon,$this->rayon,0,$direction ,1,$destx,$desty);
			            }
			            $Lastpoint=array($x,-1*$y);
			            $angledone+=$temp['angle'];
			            $value2[]=$temp;
		}
				
		$this->drawingZone=array(($this->width*15/100),($this->height*5/100),($this->width-($this->width*20/100)),($this->height-($this->height*10/100)));
}		
		
		
		//print_r($value2);
		//print_r($this->values);
		$this->values=$value2;
		
		$this->ReckonColor();
		
		
		
		
		 
		
		
	
	
	}

	public function display()
	{

		$page .= $this->start();
		
		$page .='
		<text id="title" x = "'.($this->width/2).'" y = "'.($this->drawingZone[1]/2).'" fill = "navy" font-size = "10" > '.$this->title.' </text>';
		
		
		
		$i = 0;
		foreach($this->values as $temp)
		{
                  //echo count($this->values)."<br/>";
		  $page .='
		  <g class="piece"><path  title="'.$temp['title'].': '.$temp['value'].'%" d="M'.$temp['path'][0].','.$temp['path'][1].' l'.$temp['path'][2].','.$temp['path'][3].' a'.$temp['path'][4].','.$temp['path'][5].' '.$temp['path'][6].' '.$temp['path'][7].','.$temp['path'][8].' '.$temp['path'][9].','.$temp['path'][10].' z"
        style="fill: '.$temp['color'].'; stroke: black; stroke-width:1;"/></g>
        ';
$i++;
		}
		
		
		
		
		
		
		//style="fill: rgb(159,159,159); stroke: black;"
		
		
		
		$page .=$this->end();
		
		
		return $page;
	}
}
?>
