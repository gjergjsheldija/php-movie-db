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

ini_set('arg_separator.output','&amp;');

//db config param
$hostname = "localhost";
$database = "movies";
$username = "root";
$password = "root";

//general config param
$your_full_name = "Sample User";
$app_name = "Video Store";
$version = "1.0.1";
$site = "http://localhost/php-movie-db/";
$display_chunk = 100;

//import directives
$MCImagesDir = "/media/windows/Documents and Settings/Gjergj Sheldija/My Documents/Movie Collector/Images";
$PMDImagesDir = "/var/www/php-movie-db/img/Images";
$MCThumbnailsDir = "/media/windows/Documents and Settings/Gjergj Sheldija/My Documents/Movie Collector/Thumbnails";
$PMDThumbnailsDir = "/var/www/php-movie-db/img/Thumbnails";

$strToReplace = "/media/windows/Documents and Settings/Gjergj Sheldija/My Documents/";

//user id and password
$rooter_id="user";
$rooter_phrase="password";