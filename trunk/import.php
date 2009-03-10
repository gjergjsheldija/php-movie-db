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
include 'dbmodel.php';
include 'config.php';

$xmlDoc = "collectorz.xml";
$xslDoc = "xml2sql.xsl";

$xml = new DOMDocument;
$xml->load($xmlDoc);

$xsl = new DOMDocument;
$xsl->load($xslDoc);

$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // attach the xsl rules
echo "transform ok";
$result = $proc->transformToXML($xml);


echo dir_copy("C:/Documents and Settings/Gjergj Sheldija/My Documents/Movie Collector/Images","C:/xampp/htdocs/edvini/img/Images");
echo dir_copy("C:/Documents and Settings/Gjergj Sheldija/My Documents/Movie Collector/Thumbnails","C:/xampp/htdocs/edvini/img/Thumbnails");

$result = explode(";\n",$result);

$link = mysql_connect($hostname, $username, $password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($database, $link) or die('Could not select database.');

foreach($result as $id => $data ) {
	$first_pass = str_replace('\\','/',$data);
	$second_pass = str_replace("C:/Documents and Settings/Gjergj Sheldija/My Documents/Movie Collector/","img/",$first_pass);
	$query = mysql_query($second_pass );
	if (!$query) {
	    die('Invalid query: ' . mysql_error());
	}
}

mysql_close($link);

echo dir_copy("C:/Documents and Settings/Gjergj Sheldija/My Documents/Movie Collector/Images","C:/xampp/htdocs/edvini/img/Images");
echo dir_copy("C:/Documents and Settings/Gjergj Sheldija/My Documents/Movie Collector/Thumbnails","C:/xampp/htdocs/edvini/img/Thumbnails");

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