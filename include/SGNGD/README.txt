/***********************************************
*
*	SGNGD: Svg Gd is Not GD. v0.1
*
*	Author: Renaud Guezennec
*	Web site: http://renaudguezennec.homelinux.org/
*	
*
*
***********************************************/

Description:
SGNGD is a library to help you for generating Barchart and Piechart.
Based-on SVG technologie, charts are more useful. With few code lines, you can create nice charts.


Intallation:
Extract the archive in your web site directory.

How to use: (Quick Start)
-Open a new php file.
-Include SGNGD: "require_once("path_to_SGNGD/Chart.php");
-Make a new instance of which chart you want:PieChart or BarChart (others are comming soon). $class = new BarChart();
-Add items by calling $class->AddData("name",value); 
-Call $class->compute().
-Define the type of page by call header: header('Content-Type: image/svg+xml');
and display the chart by calling "echo $class->display();"

You can manage colors your chart, the size and few other things. 
