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

include 'config.php';

function showerror() {
	die("Error " . mysql_errno() . " : " . mysql_error());
}

function mysqlclean($array, $index, $maxlength, $connection) {
	if (isset($array["{$index}"])) 	{
		$input = substr($array["{$index}"], 0, $maxlength);
		$input = mysql_real_escape_string($input, $connection);
		return ($input);
	}
	return NULL;
}

function shellclean($array, $index, $maxlength) {
	if (isset($array["{$index}"])) 	{
		$input = substr($array["{$index}"], 0, $maxlength);
		$input = EscapeShellArg($input);
		return ($input);
	}
	return NULL;
}


function authenticated($username, $password) {

	// If either the username or the password are
	// not set, the user is not authenticated
	if (!isset($username) || !isset($password))
	return false;

	// Is the password correct?
	// If so, the user is authenticated
	if (($password == md5($rooter_phrase)) && ($username == $rooter_id))
		return true;
	else
		return false;
}


function logout() {
	session_start();
	session_destroy();
	echo "Logout i suksesshem.";
}


function print_links($letter, $view) {

  print "\n<table  border=\"0\" width=\"95%\" cellspacing=1 cellpadding=4>\n";
    
     print "<tr align=\"center\">\n";
     $prev = get_prev($_GET[letter]);
     $next = get_next($_GET[letter]);

     print "<td align=\"left\">";
     if($prev != NULL)
        print "<< <a href=\"list_name.php?letter=$prev&amp;view=$view\">$prev</a>";
     print "</td>";

     print "<td></td><td></td><td></td><td></td><td></td><td></td>";

     print "<td align=\"right\">";
     if($next != NULL)
        print "<a href=\"list_name.php?letter=$next&amp;view=$view\">$next</a> >>";
     print "</td>\n";

  }  



function get_prev($letter) {
    switch ($letter)  {
    case "A":
        $result = NULL;
        break;
    case "B":
        $result = "A";
        break;
    case "C":
        $result = "B";
        break;
    case "D":
        $result = "C";
        break;
    case "E":
        $result = "D";
        break;
    case "F":
        $result = "E";
        break;
    case "G":
        $result = "F";
        break;
    case "H":
        $result = "G";
        break;
    case "I":
        $result = "H";
        break;
    case "J":
        $result = "I";
        break;
    case "K":
        $result = "J";
        break;
    case "L":
        $result = "K";
        break;
    case "M":
        $result = "L";
        break;
    case "N":
        $result = "M";
        break;
    case "O":
        $result = "N";
        break;
    case "P":
        $result = "O";
        break;
    case "Q":
        $result = "P";
        break;
    case "R":
        $result = "Q";
        break;
    case "S":
        $result = "R";
        break;
    case "T":
        $result = "S";
        break;
    case "U":
        $result = "T";
        break;
    case "V":
        $result = "U";
        break;
    case "W":
        $result = "V";
        break;
    case "X":
        $result = "W";
        break;
    case "Y":
        $result = "X";
        break;
    case "Z":
        $result = "Y";
        break;

    default:
        $result = NULL;

    }

    return($result);
}




function get_next($letter) {
    switch ($letter)    {
    case "A":
        $result = "B";
        break;
    case "B":
        $result = "C";
        break;
    case "C":
        $result = "D";
        break;
    case "D":
        $result = "E";
        break;
    case "E":
        $result = "F";
        break;
    case "F":
        $result = "G";
        break;
    case "G":
        $result = "H";
        break;
    case "H":
        $result = "I";
        break;
    case "I":
        $result = "J";
        break;
    case "J":
        $result = "K";
        break;
    case "K":
        $result = "L";
        break;
    case "L":
        $result = "M";
        break;
    case "M":
        $result = "N";
        break;
    case "N":
        $result = "O";
        break;
    case "O":
        $result = "P";
        break;
    case "P":
        $result = "Q";
        break;
    case "Q":
        $result = "R";
        break;
    case "R":
        $result = "S";
        break;
    case "S":
        $result = "T";
        break;
    case "T":
        $result = "U";
        break;
    case "U":
        $result = "V";
        break;
    case "V":
        $result = "W";
        break;
    case "W":
        $result = "X";
        break;
    case "X":
        $result = "Y";
        break;
    case "Y":
        $result = "Z";
        break;
    case "Z":
        $result = NULL;
        break;

    default:
        $result = NULL;

    }

    return($result);
}
