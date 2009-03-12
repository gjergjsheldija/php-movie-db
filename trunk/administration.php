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
<title><?php echo $version . ":  " . $your_full_name; ?></title>
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
<a href="index.php"><img src="img/home.png" alt="" style="border:none;"></a>
<table border="0" width="50%" CELLSPACING="2" CELLPADDING="4">
	<tr valign="bottom">
		<td width="50%" class="administration_seen">
			<a href="configuration.php"><img src="img/configuration.png" alt="" class="admin_menu"/></a>
			<?php echo _('configure_desc'); ?>
		</td>
		<td width="50%" class="administration_seen">
			<a href="import.php"><img src="img/import.png" alt="" class="admin_menu"/></a>
			<?php echo _('import_desc'); ?>
		</td>
	</tr>
</table>
</center>
</div>
</body>
</html>
