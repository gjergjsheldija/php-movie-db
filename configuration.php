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

$your_full_name = $iniFile->getValue('your_full_name','user_config');
$version = $iniFile->getValue('version','user_config');
$app_name = $iniFile->getValue('app_name','user_config');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style/style.css">
<title><?php echo $version . ": " . $your_full_name; ?></title>
</head>
<body>
<div id="content">

<center><img src="img/logo.jpg" alt=''><br>
<br>
<?php
print "<p class='header'>$app_name</p>\n";
print "<p class='header'>Version: $version</p>\n";
?>
<a href="administration.php"><img src="img/administration.png" alt="" style="border:none;"></a>
<table>
<tr align="left">
<td>
<!-- form with the basic data -->
<?php 

if (isset($_POST['submitted_base_data'])) {
	$iniFile->setValue('hostname',$_POST['hostname'],'database');
	$iniFile->setValue('database',$_POST['database'],'database');
	$iniFile->setValue('username',$_POST['username'],'database');
	$iniFile->setValue('password',$_POST['password'],'database');	
	$iniFile->save();
} 
?>
	<form method="post" action="<?php echo $SCRIPT_NAME ?>">
	<fieldset>
	<legend><?php echo _('Te dhenat baze') ?>:</legend>
	<table>
	<tr>
		<td align="left">
		<label for="hostname"><?php echo _('Host') ?> : </label>
		</td>
		<td align="right">
		<input id="hostname" type="text" name="hostname" value="<?php echo $iniFile->getValue('hostname','database') ;  ?>">
		</td>
	</tr>
	<tr>
		<td align="left">
			<label for="db"><?php echo _('Db')?> : </label>
		</td>
		<td align="right">		
			<input id = "db" type="text" name="database" value="<?php echo $iniFile->getValue('database','database') ;  ?>">
		</td>
	</tr>
	<tr>
		<td align="left">		
			<label for="user"><?php echo _('User') ?> : </label>
		</td>
		<td align="right">			
			<input id="user" type="text" name="username" value="<?php echo $iniFile->getValue('username','database') ;  ?>">
		</td>
	</tr>
	<tr>
		<td align="left">		
			<label for="password"><?php echo _('Password') ?> : </label>
		</td>
		<td align="right">			
			<input id="password" type="text" name="password" value="<?php echo $iniFile->getValue('password','database') ;  ?>">
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="submit" name="submitted_base_data" value="ruaj">
		</td>
	</tr>
	</table>
	</fieldset>
	</form>

</td>
<td valign="top">
<!-- form with file data -->
<?php 
if (isset($_POST['submitted_file_data'])) {
	$iniFile->setValue('MCImagesDir',$_POST['MCImagesDir'],'import_directives');
	$iniFile->setValue('MCThumbnailsDir',$_POST['MCThumbnailsDir'],'import_directives');
	$iniFile->save();
}
?>
	<form method="post" action="<?php echo $SCRIPT_NAME ?>">
	<fieldset>
	<legend><?php echo _('Te dhenat per file')?>:</legend>
	<table>
	<tr>
		<td align="left">
		<label for="MCImagesDir"><?php echo _('MCImagesDir')?> : </label>
		</td>
		<td align="right">
		<input id="MCImagesDir" type="text" name="MCImagesDir" value="<?php echo $iniFile->getValue('MCImagesDir','import_directives') ;  ?>">
		</td>
	</tr>
	<tr>
		<td align="left">		
			<label for="MCThumbnailsDir"><?php echo _('MCThumbnailsDir')?> : </label>
		</td>
		<td align="right">			
			<input id="MCThumbnailsDir" type="text" name="MCThumbnailsDir" value="<?php echo $iniFile->getValue('MCThumbnailsDir','import_directives') ;  ?>">
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="submit" name="submitted_file_data" value="ruaj">
		</td>
	</tr>
	</table>
	</fieldset>
	</form>

</td>
</tr>
<tr>
<td>
<!-- form with file data -->
<?php 
if (isset($_POST['submitted_user_data'])) {
	$iniFile->setValue('your_full_name',$_POST['your_full_name'],'user_config');
	$iniFile->setValue('site',$_POST['site'],'user_config');
	$iniFile->setValue('display_chunk',$_POST['display_chunk'],'user_config');
	$iniFile->setValue('language',$_POST['language'],'user_config');
	$iniFile->save();
}  
?>
	<form method="post" action="<?php echo $SCRIPT_NAME ?>">
	<fieldset>
	<legend><?php echo _('Te dhenat personale') ?>:</legend>
	<table>
	<tr>
		<td align="left">
		<label for="your_full_name"><?php echo _('your_full_name')?> : </label>
		</td>
		<td align="right">
		<input id="your_full_name" type="text" name="your_full_name" value="<?php echo $iniFile->getValue('your_full_name','user_config') ;  ?>">
		</td>
	</tr>
	<tr>
		<td align="left">
			<label for="site"><?php echo _('site')?> : </label>
		</td>
		<td align="right">		
			<input id = "site" type="text" name="site" value="<?php echo $iniFile->getValue('site','user_config') ;  ?>">
		</td>
	</tr>
	<tr>
		<td align="left">		
			<label for="display_chunk"><?php echo _('display_chunk')?> : </label>
		</td>
		<td align="right">			
			<input id="display_chunk" type="text" name="display_chunk" value="<?php echo $iniFile->getValue('display_chunk','user_config') ;  ?>">
		</td>
	</tr>
	<tr>
		<td align="left">		
			<label for="language"><?php echo _('language')?> : </label>
		</td>
		<td align="left">			
			<input id="language" type="radio" name="language" value="en_US" <?php echo $iniFile->getValue('language','user_config') == "en_US" ? 'checked' : '' ;  ?>>English</input>
			<input id="language" type="radio" name="language" value="sq_AL" <?php echo $iniFile->getValue('language','user_config') == "sq_AL" ? 'checked' : '' ;  ?>>Shqip</input>
		</td>
	</tr>	
	<tr>
		<td colspan="2" align="right">
			<input type="submit" name="submitted_user_data" value="ruaj">
		</td>
	</tr>
	</table>
	</fieldset>
	</form>

</td>
<td></td>
</tr>
</table>
</center>
</div>
</body>
</html>