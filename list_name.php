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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="generator" content="PMD <?php echo $version; ?>">
<link rel="stylesheet" type="text/css" href="style/style.css">
<title><?php echo _('Filmat')?></title>
</head>

<body>
<div id="content">
<center>
<a href="javascript:history.go(-1)"><img src="img/previous.png"></a>&nbsp;&nbsp;<a href='index.php'><img src="img/home.png"></a>
<?php
$locale = "en_US" . ".UTF-8";
setlocale(LC_ALL, $locale );
putenv("LC_ALL=$locale");
putenv("LANGUAGE=$locale");
bindtextdomain("messages", "./locale");
textdomain("messages");
require_once 'dbmodel.php';
require_once 'utils.php';
require_once 'inifile.php';

$iniFile = new INIFile('config.ini');
$display_chunk = $iniFile->getValue('display_chunk','user_config');

global $view;
global $is_search;


if($_POST[search_string] == NULL || $_POST[search_string] == "")
	$is_search = false;
else
	$is_search = true;


if($_GET[letter] == NULL || $_GET[letter] == "" || $_GET[view] == NULL || $_GET[view] == "")
	die(_('Specifikoni nje germe.'));

$view = $_GET[view];


print "<p class='header'>$app_name $version<br>\n".  _('Katalogu i filmave per') . "{$your_full_name}</p>\n";

if($is_search)
	print "<p class='header'>" . _('Rezultatet e kerkimit per') . " : \"$_POST[search_string]\"</p>\n";
else
	print "<p class='header'>" . _('Filmi') . " : " . $_GET[letter] . "</p>\n";

if($_GET[letter] != "ALL") {
	print_links($_GET[letter], $view);
	print "</table>\n";
}


if($is_search){
	$searchString = "movie LIKE \"%$_POST[search_string]%\" OR plot LIKE \"%$_POST[search_string]%\"";
}

if($_GET[letter] == "ALL") {
	$query = "SELECT * FROM catalog";

	if ($view != "ALL" && $is_search)
		$query = $query . " WHERE format LIKE \"%$view%\" AND $searchString";
	else if($view == "ALL" && $is_search)
		$query = $query . " WHERE $searchString";

	$query = $query . " ORDER BY ";
} else {
	$query = "SELECT *  FROM catalog WHERE movie LIKE \"$_GET[letter]%\"";
	$query = $query . " ORDER BY ";
}


if($_GET[dir] == null)
	$direction = " ASC";

if($_GET[dir] == "ASC")
	$direction = " ASC";
else if($_GET[dir] == "DESC")
	$direction = " DESC";

switch ($_GET[sort]) {
	case "movie":
		$orderby = "movie " . $direction ;
		break;
	case "plot":
		$orderby = "plot " . $direction ;
		break;
	case "studio":
		$orderby = "studio " . $direction ;
		break;
	case "year":
		$orderby = "release_date " . $direction ;
		break;
	case null:
		$orderby = "movie " . $direction ;
}

$query = $query . $orderby;

if($_GET[from] != null && $_GET[from] >= 0)
	$query = $query . " LIMIT " . $_GET[from];
else
	$query = $query . " LIMIT 0";


$query = $query . ",$display_chunk";
 
$dbModel = new dbmodel();
$result = $dbModel->searchMovie($query);

if(count($result) == 0) {
	if($is_search) {
		print "<br><p class='header'>" . _('Asnje film per') ." $_POST[search_string] ";
		if($_POST[search_type] == "movie")
			print _('Titulli');
		else
			print $_POST[search_type];

		print "</p><br />\n\n";
	} else {
		print "<br><p class='header'>" . _('Asnje rezultat per kerkimin ose nuk ka filma qe fillojne me') . " : " . $_GET[letter] . " </p><br /><br />\n\n";
	}

	print "\n<table  border=\"0\" width=\"95%\" cellspacing=\"1\" cellpadding=\"4\">\n<tr align=\"center\"> \n";
	print "\n<br /><br />\n";
	print_links($letter, $view);
	print "\n</table>\n\n";
} else {
	// Display the results
	displayMovies($result, $display_chunk);
}

?> 
<a href="javascript:history.go(-1)"><img src="img/previous.png"></a>&nbsp;&nbsp;<a href='index.php'><img src="img/home.png"></a>
<?php

function displayMovies($result, $display_chunk) {
	global $view;
	$alter_color = 1;		//var for alternating the background of each row
	$num_of_rows = count($result);

	if($_GET[dir] == "DESC" || $_GET[dir] == null){
		$opposite_dir = "ASC";
		$image = "img/arrow-up.png";
	} else {
		$opposite_dir = "DESC";
		$image = "img/arrow-down.png";
	}
	// Start a table, with column headers
	print "\n<table  border=\"0\" width=\"98%\" cellspacing=\"1\" cellpadding=\"4\">\n<tr align=\"center\"> \n";
	print "\n\t<th width=\"15%\"><img src='$image' style=\"border: none; margin-right: 3px;  padding: 0px;\" alt=''>";
	print "<a href='list_name.php?letter=$_GET[letter]&amp;view=$view&amp;sort=movie&amp;dir=$opposite_dir'>" . _('Cover') ."</a></th>";

	print "\n\t<th width=\"25%\"><img src='$image' style=\"border: none; margin-right: 3px;  padding: 0px;\" alt=''>" .
       "<a href='list_name.php?letter=$_GET[letter]&amp;view=$view&amp;sort=movie&amp;dir=$opposite_dir'>" . _('Filmi') . "</a></th>" .
          "\n\t<th><img src='$image' style=\"border: none; margin-right: 3px;  padding: 0px;\" alt=''>" . 
       "<a href='list_name.php?letter=$_GET[letter]&amp;view=$view&amp;sort=plot&amp;dir=$opposite_dir'>" . _('Pershkrimi') . "</a></th>" .
          "\n\t<th><img src='$image' style=\"border: none; margin-right: 3px;  padding: 0px;\" alt=''>" . 
       "<a href='list_name.php?letter=$_GET[letter]&amp;view=$view&amp;sort=year&amp;dir=$opposite_dir'>" . _('Viti') . "</a></th>";

	foreach($result as $id => $movie) {
		// ... start a TABLE row ...
		print "\n<tr align=\"left\"";
		if($alter_color == 0) {
			print " class=\"seen\">";
			$alter_color = 1;
		} else {
			print " class=\"seen_alt\">";
			$alter_color = 0;
		}

		print "\n\t<td><a href=\"show_movie.php?movie=" . $movie['id'] . "\"><img src=\"$movie[thumbnail]\"></a></td>";
		print "\n\t<td><a href=\"show_movie.php?movie=" . $movie['id'] . "\">" . $movie[movie] ."</a>";

		print "</td>\n\t<td align=\"left\">";
		if($movie['plot'] != NULL || $movie['plot'] != "")	
		print $movie['plot'];
		print "\n\t</td><td align=\"center\">$movie[release_date]</td>";

		print "\n</tr>";
	}
	print "\n\n</table>\n<br /><br />\n";
	print_links($letter, $view);

	// Then, finish the table
	print "\n</table>\n";


	print "<p><br /><br />\n";

	if($num_of_rows == $display_chunk){
		if($_GET[from] > 0) {   //print previous chunk link
			print "<a href='list_name.php?letter=$_GET[letter]&amp;view=$view&amp;sort=$_GET[sort]&amp;dir=$_GET[dir]&amp;from=";
			$offset = $_GET[from] - $display_chunk;
			print $offset;
			print "'><< " . _('Prapa') . $display_chunk . _('Filma') . "</a> | ";
		}

		 print "<a href='list_name.php?letter=$_GET[letter]&amp;view=$view&amp;sort=$_GET[sort]&amp;dir=$_GET[dir]&amp;from=";
		 $offset = $_GET[from] + $display_chunk;
		 print $offset;
		 print "'><< " . _('Para') . $display_chunk . _('Filma') . "</a> | ";

	} else if ($num_of_rows < $display_chunk && ($_GET[from] - $display_chunk) > 0) {
		 print "<a href='list_name.php?letter=$_GET[letter]&amp;view=$view&amp;sort=$_GET[sort]&amp;dir=$_GET[dir]&amp;from=";
		 $offset = $_GET[from] - $display_chunk;
		 print $offset;
		 print "'><< " . _('Prapa') . $display_chunk . _('Filma') . "</a> | ";
	}
	print "\n<p><br /><br />\n";
}
?>
</center>
</div>
</body>
</html>
