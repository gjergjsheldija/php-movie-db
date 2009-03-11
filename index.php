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

$iniFile = new INIFile('config.ini');
$app_name = $iniFile->getValue('app_name','user_config');
$version = $iniFile->getValue('version','user_config');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="generator" content="PMD <?php echo $version;?>">
<link rel="stylesheet" type="text/css" href="style/style.css">
<title><?php echo "DBF " . $version . ":  " . $your_full_name; ?></title>
</head>

<body>
<div id="content">
<center><img src="img/logo.jpg" alt=''><br>
<br>

<?php
print "<p class='header'>$app_name</p>\n";
print "<p class='header'>Version: $version</p>\n";

?>

<p>


<table border="0" width="50%" CELLSPACING=0 CELLPADDING=4>
	<tr align="left" class="seen">
		<td width="25%"><strong><?php echo _('Ne baze te titullit');?>:</strong></td>
		<td>
			<a href="list_name.php?letter=A&amp;view=ALL">A</A> 
			<a href="list_name.php?letter=B&amp;view=ALL">B</A> 
			<a href="list_name.php?letter=C&amp;view=ALL">C</A> 
			<a href="list_name.php?letter=D&amp;view=ALL">D</A> 
			<a href="list_name.php?letter=E&amp;view=ALL">E</A> 
			<a href="list_name.php?letter=F&amp;view=ALL">F</A> 
			<a href="list_name.php?letter=G&amp;view=ALL">G</A> 
			<a href="list_name.php?letter=H&amp;view=ALL">H</A> 
			<a href="list_name.php?letter=I&amp;view=ALL">I</A> 
			<a href="list_name.php?letter=J&amp;view=ALL">J</A> 
			<a href="list_name.php?letter=K&amp;view=ALL">K</A> 
			<a href="list_name.php?letter=L&amp;view=ALL">L</A> 
			<a href="list_name.php?letter=M&amp;view=ALL">M</A> 
			<a href="list_name.php?letter=N&amp;view=ALL">N</A> 
			<a href="list_name.php?letter=O&amp;view=ALL">O</A> 
			<a href="list_name.php?letter=P&amp;view=ALL">P</A> 
			<a href="list_name.php?letter=Q&amp;view=ALL">Q</A> 
			<a href="list_name.php?letter=R&amp;view=ALL">R</A> 
			<a href="list_name.php?letter=S&amp;view=ALL">S</A> 
			<a href="list_name.php?letter=T&amp;view=ALL">T</A> 
			<a href="list_name.php?letter=U&amp;view=ALL">U</A> 
			<a href="list_name.php?letter=V&amp;view=ALL">V</A> 
			<a href="list_name.php?letter=W&amp;view=ALL">W</A> 
			<a href="list_name.php?letter=X&amp;view=ALL">X</A> 
			<a href="list_name.php?letter=Y&amp;view=ALL">Y</A> 
			<a href="list_name.php?letter=Z&amp;view=ALL">Z</A>
	</tr>

<tr align="left" class="seen">
	<td width="20%"><strong><?php echo _('Shih'); ?>:</strong></td>
	<td>
		<a href="list_name.php?letter=ALL&amp;view=ALL&amp;sort=movie&amp;dir=ASC&amp;from=0"><?php echo _('Te gjithe filmat');?></a>
	</td>
</tr>
	<tr align="left" class="seen">
		<td width="20%"><strong><?php echo _('Kerko') ?>:</strong></td>
		<td>
		<form method="post" id="searchform" action="list_name.php?letter=ALL&amp;view=ALL">
			<input type="text" value="<?php echo _('kerko') ?>" name="search_string" onfocus="if (this.value == '<?php echo _('kerko')?>') {this.value = '';}" /> 
			<img src="img/search.png">
			<br /> 
		</form>
	</tr>
</table>
<br>
<br>

	<?php

	print _('Totali') ." :" ;
	$db = new dbmodel();
	$cat_query = $db->loadMovie();

	print "<strong>".count($cat_query)." </strong>" . _('filma') ;

	print "<br><br><hr size=1 width=\"40%\"><strong>" .  _('Filmat e rinj ') . ":</strong><br><br>\n\n";

?>
<table  border="0" width="50%" CELLSPACING="1" CELLPADDING="4">
	  <tr>
<?php 
	$most_recent_result = $db->loadLastMovie();
	foreach($most_recent_result as $id => $name) {
		echo "<td>";
		echo "<a href=\"show_movie.php?movie=" . $name['id'] . "\"><img src=\"". str_replace("/","//" ,$name['thumbnail']). "\"  alt=\"". $name['movie'] . "\"></a>";
		echo "</td>";
	}

	?>
	</tr>
</table>
<p><br>
<br>
</center>
</div>
</body>
</html>
