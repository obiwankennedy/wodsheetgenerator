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
 */
/**
 * \Author:Renaud Guezennec 
 * Contact me: http://renaudguezennec.homelinux.org/index,1,3.html
 * 
 * 
 * \brief Example of functionChart use.
 * \version 0.1
 * \date 28/03/2009
 */
require_once('Chart.php');
function feelings($x)
{
	/*if($x<50)
		return $x/2;
	else*/ if($x<90)
		return $x/(2*(0.025*(40-($x-70))));
	else if($x<95)
		return $x-(18*($x-89));
	else if($x<100)
		return 4+(($x-95)*19);
	else
		return $x;
	
}


$chartsvg = new functionChart("Emotion rate in Hollywood Movies");
$chartsvg->setparams(0,100,1);
$chartsvg->setStartColor(new Color(255,0,0));
$chartsvg->setEndColor(new Color(255,0,0));

$chartsvg->setXTitle("Movie's Timeline");
$chartsvg->setYTitle("Emotion Rate");
	


$chartsvg->AddData("emotion rate","feelings");
$chartsvg->SetScale(5);
$chartsvg->Compute();
header('Content-Type: image/svg+xml');
echo $chartsvg->display();
?>
