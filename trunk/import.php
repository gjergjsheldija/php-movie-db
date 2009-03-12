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
$password = $iniFile->getValue('password','database');
$username = $iniFile->getValue('username','database');
$hostname = $iniFile->getValue('hostname','database');
$database = $iniFile->getValue('database','database');
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
<title><?php echo  $version . ":  " . $your_full_name; ?></title>
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
<p>
<form enctype="multipart/form-data" action="<?php echo $SCRIPT_NAME ?>" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
	<?php echo _("Choose a file to upload"); ?>: <input name="uploadfile" type="file" /><input type="submit" value="<?php echo _('submit')?>" name="import_file" />
</form>
<br />
<?php
if(isset($_POST['import_file'])) { 

	$tempDir = sys_get_temp_dir();
	$uploadfile = $tempDir . DIRECTORY_SEPARATOR . basename($_FILES['uploadfile']['name']);

	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
	    echo _("File is valid, and was successfully uploaded") . "...<br />";
	} else {
	    die( _("Possible file upload attack!")  );
	}
	
	$MCImagesDir = $iniFile->getValue('MCImagesDir','import_directives');
	$MCThumbnailsDir = $iniFile->getValue('MCThumbnailsDir','import_directives');
	
	$xmlDoc = $uploadfile;
	$xslDoc = "xml2sql.xsl";
	
	$xml = new DOMDocument;
	$xml->load($xmlDoc);
	
	$xsl = new DOMDocument;
	$xsl->load($xslDoc);
	
	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl); // attach the xsl rules
	echo _("transform ok") . "...<br />";
	$result = $proc->transformToXML($xml);
	
	$scriptPath =  pathinfo($_SERVER['SCRIPT_FILENAME']);
	$PMDImagesDir = $scriptPath['dirname'] . "/img/Images";
	$PMDThumbnailsDir = $scriptPath['dirname'] . "/img/Thumbnails";
	
	$temp = explode(DIRECTORY_SEPARATOR,$MCImagesDir);
	
	//heck ..it'll only work on win machines.. :(
	$strToReplace = $temp[0] .
					DIRECTORY_SEPARATOR . $temp[1] .
					DIRECTORY_SEPARATOR . $temp[2] .
					DIRECTORY_SEPARATOR . $temp[3] .
					DIRECTORY_SEPARATOR . $temp[4] .
					DIRECTORY_SEPARATOR . $temp[5];
					
	
	//$strToReplace = "C:/Documents and Settings/Gjergj Sheldija/My Documents/Movie Collector/";				
	dir_copy( $MCImagesDir,$PMDImagesDir);
	echo _("image copy ok") . "....<br />";
	dir_copy( $MCThumbnailsDir , $PMDThumbnailsDir);
	echo _("thumbnail copy ok") . "....<br />";	
	$result = explode(";\n",$result);
	
	$link = mysql_connect($hostname, $username, $password);
	if (!$link) {
	    die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db($database, $link) or die('Could not select database.');
	
	$sqlDrop = "DROP TABLE IF EXISTS `catalog`";
	
	$queryDrop = mysql_query($sqlDrop );
	if (!$queryDrop) {
	    die('Invalid query: ' . mysql_error());
	}
	echo _("table drop ok") . "....<br />";
	$sqlCreate = "CREATE TABLE `catalog` (
	  `id` int(10) unsigned NOT NULL auto_increment,
	  `movie` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'artist',
	  `cover` text collate utf8_unicode_ci COMMENT 'album_art_url',
	  `plot` text collate utf8_unicode_ci COMMENT 'description',
	  `release_date` int(4) default '1900' COMMENT 'year',
	  `runtime` varchar(20) collate utf8_unicode_ci NOT NULL,
	  `genre` varchar(100) collate utf8_unicode_ci NOT NULL,
	  `cast` text collate utf8_unicode_ci NOT NULL,
	  `director` text collate utf8_unicode_ci COMMENT 'real_name',
	  `studio` varchar(100) collate utf8_unicode_ci default '-' COMMENT 'label',
	  `thumbnail` text collate utf8_unicode_ci,
	  `album` varchar(100) collate utf8_unicode_ci default NULL,
	  `catalog` varchar(20) collate utf8_unicode_ci default '-',
	  `format` varchar(20) collate utf8_unicode_ci default '-',
	  `rating` int(1) default '0',
	  `num_discs` int(10) unsigned default '1',
	  `last_modified` datetime default '0000-00-00 00:00:00',
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
	
	$queryCreate = mysql_query($sqlCreate );
	if (!$queryCreate) {
	    die('Invalid query: ' . mysql_error());
	}
	echo _("table create ok") . "....<br />";
	foreach($result as $id => $data ) {
		$first_pass = str_replace('\\','/',$data);
		$second_pass = str_replace($strToReplace ,"img/",$first_pass);
		if(strlen($second_pass) > 6) {
			$query = mysql_query($second_pass );
			if (!$query) {
			    echo "error: " . mysql_error() . "<br />";
			}
		}
	}
	
	mysql_close($link);
	echo _("insert ok") . "....<br />";
	echo _("import successfully finished") . "....<br />";
	echo "<br /><br />" . _("You may now chek your movie catalog at") . " : <a href=\"./\">" . _("Home") . "</a>";
}

function dir_copy($srcdir, $dstdir, $offset = '', $verbose = false) {
    if(!isset($offset)) $offset=0;
    $num = 0;
    $fail = 0;
    $sizetotal = 0;
    $fifail = '';
    if(!is_dir($dstdir)) mkdir($dstdir);
    if($curdir = opendir($srcdir)) {
        while($file = readdir($curdir)) {
            if($file != '.' && $file != '..') {
                $srcfile = $srcdir . '/' . $file;    # added by marajax
                $dstfile = $dstdir . '/' . $file;    # added by marajax
                if(is_file($srcfile)) {
                    if(is_file($dstfile)) $ow = filemtime($srcfile) - filemtime($dstfile); else $ow = 1;
                    if($ow > 0) {
                        if($verbose) echo "Copying '$srcfile' to '$dstfile'...<br />";
                        if(copy($srcfile, $dstfile)) {
                            touch($dstfile, filemtime($srcfile)); $num++;
                            chmod($dstfile, 0777);    # added by marajax
                            $sizetotal = ($sizetotal + filesize($dstfile));
                            if($verbose) echo "OK\n";
                        }
                        else {
                            echo "Error: File '$srcfile' could not be copied!<br />\n";
                            $fail++;
                            $fifail = $fifail.$srcfile.'|';
                        }
                    }
                }
                else if(is_dir($srcfile)) {
                    $res = explode(',',$ret);
                    $ret = dir_copy($srcfile, $dstfile, $verbose); # added by patrick
                    $mod = explode(',',$ret);
                    $imp = array($res[0] + $mod[0],$mod[1] + $res[1],$mod[2] + $res[2],$mod[3].$res[3]);
                    $ret = implode(',',$imp);
                }
            }
        }
        closedir($curdir);
    }
    $red = explode(',',$ret);
    $ret = ($num + $red[0]).','.(($fail-$offset) + $red[1]).','.($sizetotal + $red[2]).','.$fifail.$red[3];
    return $ret; 
}
?>
</center>
</div>
</body>