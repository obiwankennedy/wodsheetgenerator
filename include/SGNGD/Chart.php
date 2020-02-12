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


require_once('Color.php');
require_once('Barchart.php');
require_once('BarChart3D.php');
require_once('HBarChart.php');
require_once('PieChart.php');
require_once('PointCloudChart.php');
require_once('Kiviat.php');
require_once('functionChart.php');
require_once('FilledLineChart.php');


$i=0;
define('FULLDEFINED', $i++);
define('NORMAL', $i++);
/**
 * \author:Renaud Guezennec 
 * Contact me: http://renaudguezennec.homelinux.org/index,1,3.html
 * 
 * 
 * \class Chart
 * \brief abstract class of SG is Not GD.  
 * \version 0.1
 * \date 28/03/2009
 */
class Chart
{
	
	public $canvasx;///< start value of the canvas
	public $canvasy;///< start value of the canvas
	public $width;///< the width of the canvas
	public $height;///< the height of the canvas
	public $values;///< Array of all values
	public $legend;///< array for all required values for the legend: NOT YET USED
	public $colortype; ///< Define the colour policy
	public $startColor;///< The first colour
	public $endColor;///< The last colour
	public $count;///< number of values
	public $title;///< Title of the graph.
/**
 * 
 * \fn clone()
 * \brief copy a Chart. 
 * 
 */
  public function __clone()
  {
    $members = get_class_vars(get_class($this));
    foreach($members as $mb => $value)
        $this->$mb = clone($this->$mb);
  }
/**
 * 
 * \fn setlegent($i)
 * \brief enabled the legend. NOT YET USED 
 * \param $i : bool 
 */	
  public function setlegent($i)
  {
  	
  	$legend = $i;
  	
  }

/**
 * 
 * \fn setStartColor($s)
 * \brief define the first colour of the colour range.
 * \param $s : color
 */	
  public function setStartColor($s)
  {
  	$this->startColor=$s;
  	
  	
  }
/**
 * 
 * \fn setEndColor($e)
 * \brief define the last colour of the colour range.
 * \param $e : color
 */	  
  public function setEndColor($e)
  {
  	
  	$this->endColor=$e;
  	
  }
/**
 * 
 * \fn SetWidth($w)
 * \brief define the Width.
 * \param $w : int
 */	    
  public function SetWidth($w)
  {
  	
  	$this->width=$w;
  }
/**
 * 
 * \fn SetHeight($h)
 * \brief define the Height.
 * \param $h : int
 */	    
 public function SetHeight($h)
  {
  	
  	$this->height=$h;
  }
/**
 * 
 * \fn ReckonColor()
 * \brief calculate all intermediate colours using linear interpolation.
 * 
 */	    
	public function ReckonColor()
	{
		if($this->colortype==NORMAL)
		{
			$pascolor = 1/($this->count);
			for($j=0;$j < count($this->values);$j++)
			{
				
				$r = ($this->startColor->getRed()*(1-($pascolor*$j))+$this->endColor->getRed()*($j*$pascolor));
				$g = ($this->startColor->getGreen()*(1-($pascolor*$j))+$this->endColor->getGreen()*($j*$pascolor));
				$b = ($this->startColor->getBlue()*(1-($pascolor*$j))+$this->endColor->getBlue()*($j*$pascolor));
				
				//print_r($this->values);
				$this->values[$j]['color'] = new Color(intval($r),intval($g),intval($b));
				//print_r($this->values);
				//echo $this->values[$j]['color'];
			}
		}
	}
/**
 * 
 * \fn start()
 * \brief display the beginning of the SVG file and the css style. 
 * \todo: create new way to make easier the css modification.
 */	    
	public function start()
	{//'.$this->width.' '.$this->height.'" >
		
		return '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 '.$this->width.' '.$this->height.'" style="fill: #DDD;"> 
<style type="text/css" id="style4" >
	.piece {
	fill-opacity:0.6;
	stroke-opacity:1;
	}
	.polyline{
	fill-opacity:0.1;
	stroke-opacity:1;
	}
	.polyline2{
	fill-opacity:0.0;
	stroke-opacity:1;
	}
	.polyline:hover{
	fill-opacity:1;
	stroke-opacity:1;
	}
	.piece:hover {
	fill-opacity:1;
	stroke-opacity:1;
	}
	#title
	{
		text-anchor: middle;
		font-size: 0.8em;
	}
	#poweredby
	{
		text-anchor: end;
	}
	.textleft
	{	
		text-anchor: end;
		font-size: 0.8em;
	}
	.textlowmiddle
	{	
		baseline-shift: -50%;
		font-size: 0.8em;
	}
	.textright
	{	
		text-anchor: start;
		font-size: 0.8em;
	}
	.gradutatoinh
	{
		text-anchor: middle;
		font-size: 0.8em;
	}
	.gradright
	{
		text-anchor: start;
	}
	path{
	fill:url(#degrade);
	stroke:black;
	stroke-width:1px;
	}

	#stop1{
		stop-color:green;
	}
	
	#stop2{
		stop-color:blue;
	}
</style>';
	}
/**
 * 
 * \fn end()
 * \brief display a http link to the SGNGD web page and close the SVG file. 
 * 
 */	 
	public function end()
	{
		return '<a xlink:href="http://renaudguezennec.homelinux.org/programmation,1-2.html"><text id="poweredby" x = "'.($this->width).'" y = "'.($this->height-($this->height*0.01)).'" fill = "black" font-size = "0.5em" > Powered by SGNGD</text></a></svg>';
	}
}
?>
