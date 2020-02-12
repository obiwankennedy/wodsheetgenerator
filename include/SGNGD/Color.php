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
 * \class Color
 * \brief all data required to describe a colour.
 * \version 0.1
 * \date 28/03/2009
 */
class Color
{
	public $red;
	public $green;
	public $blue;
	
	public function __construct($r,$g,$b)
	{
		$this->red = $r;
		$this->green =$g;
		$this->blue = $b;
	
	}
	public function __toString()
	{
		
		return (string)'rgb('.$this->red.','.$this->green.','.$this->blue.')';
		
	}
	public function getRed()
	{
		return $this->red;
	}
	public function getGreen()
	{
		return $this->green;
	}
	public function getBlue()
	{
		return $this->blue;
	}
	public function setBlue($b)
	{
		$this->blue=$b;
	}
	public function setGreen($g)
	{
		$this->green=$g;
	}
	public function setRed($r)
	{
		$this->red=$r;
	}
}
?>
