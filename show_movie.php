<?php
/*
 * Copyright (c) 2009 Gjergj Sheldija <gjergj.sheldija@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

require_once 'include.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="generator" content="PMD <?php echo $version; ?>">
<link rel="stylesheet" type="text/css" href="style/style.css">
<title><?php echo _('Detaje mbi filmin') ?></title>
</head>

<body>
<div id="content">
<center>
<a href="javascript:history.go(-1)"><img src="img/previous.png"></a>&nbsp;&nbsp;<a href='index.php'><img src="img/home.png"></a>
<?php

$movie_id = (int)$_GET[movie];

$dbModel = new dbmodel();
$result = $dbModel->loadMovie($movie_id);

displayMovie($result);

function displayMovie($movie)  {

	print "<table><tr><td valign=top>";
	if($movie[0][cover] == NULL || $movie[0][cover] == "") {
		print "<img src=\"img/notavailable.jpg\" border=0 alt=\"". _('Kopertina mungon') . "\">";
	} else {
		print "<img src=\"". $movie[0][cover] . "\" border=0 alt=\"" . _('Kopertina') . "\">";
		print "</td>";
	}
	
	// Start a table, with column headers
	print "<td>";
	print "\n<table  border=\"0\" width=\"80%\" cellspacing=0 cellpadding=4>\n<tr align=\"center\"> \n";

	print "<th width=\"20%\"></th>";
	print "<th width=\"80%\"></th>";

	// ... start a TABLE row ...
	print "\n<tr align=\"left\" class=\"seen\">";
	print "<td><b>" . _('Kodi') . " :</b></td>";
	print "<td><strong>" .$movie[0][id] ."</strong></td>";
	
	print "\n<tr align=\"left\" class=\"seen\">";
	print "<td><b>" . _('Filmi') . " :</b></td>";
	print "<td>" .$movie[0][movie] ."</td>";
	
	print "\n<tr align=\"left\" class=\"seen\">";
	print "<td><b>" . _('Regjizori') . " :</b></td>";
	print "<td>" .$movie[0][director] ."</td>";
	
	print "\n<tr align=\"left\" class=\"seen\">";
	print "<td><b>" . _('Gjinia') . " :</b></td>";
	print "<td>" .$movie[0][genre] ."</td>";	
	
	print "\n<tr align=\"left\" class=\"seen\">";
	print "<td><b>" . _('Kohezgjatja') . " :</b></td>";
	print "<td>" .$movie[0][runtime] ."</td>";		

	if($movie[0][cast] != NULL && $movie[0][cast] != ''){
		print "\n<tr align=\"left\" class=\"seen\">";
		print "<td><b>" . _('Personazhet / Aktoret') . " :</b></td>";
		print "<td>" .$movie[0][cast] ."</td>";
	}

	print "\n<tr align=\"left\" class=\"seen\">";
	print "<td><b>" . _('Filmi') . " :</b></td>";
	print "<td>" . $movie[0][movie] ."</td>";

	print "\n<tr align=\"left\" class=\"seen\">";
	print "<td><b>" . _('Studio') . " :</b></td>";
	print "<td>" . $movie[0][studio] . "</td>";

	print "\n<tr align=\"left\" class=\"seen\">";
	print "<td><b>" . _('Viti') . " :</b></td>";
	print "<td>" . $movie[0][release_date] . "</td>";

	print "\n<tr align=\"left\" class=\"seen\">";
	print "<td><b>" . _('Sinopsis') ." :</b></td>";
	print "<td>" . $movie[0][plot] . "</td>";


	// Then, finish the table
	print "\n</table>\n";
	print "</td></tr></table>";
}
?>

<p><br>


<br>
<a href="javascript:history.go(-1)"><img src="img/previous.png"></a>&nbsp;&nbsp;<a href='index.php'><img src="img/home.png"></a>

</center>
</div>
</body>
</html>
