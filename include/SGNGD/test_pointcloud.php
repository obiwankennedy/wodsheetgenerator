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
 */
/**
 * \Author:Renaud Guezennec 
 * Contact me: http://renaudguezennec.homelinux.org/index,1,3.html
 * 
 * 
 * \brief Example of PointCloudChart use.
 * \version 0.1
 * \date 28/03/2009
 */
require_once('Chart.php');



$chartsvg = new PointCloudChart("PointCloudChart SVG");

$chartsvg->setStartColor(new Color(0,0,0));
$chartsvg->setEndColor(new Color(0,0,0));

/*$chartsvg->AddData('cv',20,8,new Color(0,0,0));
$chartsvg->AddData('Mega',20,12,new Color(255,255,0));
$chartsvg->AddData('com',20,15,new Color(255,0,0));
$chartsvg->AddData('com2',20,2,new Color(0,255,0));
$chartsvg->AddData('com3',20,9,new Color(0,0,255));*/
//$chartsvg->AddData('com4',1);
//$chartsvg->AddData('comder',4);

for($i = -50 ; $i <= 50 ; $i++)
{
	//$x = rand(-2,2);
	//$y = rand(1,1000);
	$chartsvg->AddData($i,$i,$i );
	/*$chartsvg->AddData($i,$i,100-$i);
	$chartsvg->AddData($i,$i,50);
	$chartsvg->AddData($i,50,$i);*/
}


$chartsvg->SetScale(5);
$chartsvg->Compute();
header('Content-Type: image/svg+xml');
echo $chartsvg->display();
?>
