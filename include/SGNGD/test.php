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
 * @Author:Renaud Guezennec 
 * Contact me: http://renaudguezennec.homelinux.org/accueil,3.html
 *
 * @desc: test of BarChart class.
 *
 */
require_once('Chart.php');



$chartsvg = new BarChart("BarChart SVG");
$chartsvg->setStartColor(new Color(0,0,255));
$chartsvg->setEndColor(new Color(0,255,0));

$chartsvg->AddData('cv',18);
$chartsvg->AddData('Mega',-5);
$chartsvg->AddData('com',8);
$chartsvg->AddData('com2',9);
$chartsvg->AddData('com3',20);
$chartsvg->AddData('com4',1);
$chartsvg->AddData('comder',6);

$chartsvg->SetScale(5);
$chartsvg->Compute();
header('Content-Type: image/svg+xml');
echo $chartsvg->display();
?>
