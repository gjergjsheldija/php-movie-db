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

require_once 'inifile.php';

class dbmodel {

	protected static $dbh = false;

	function connect() {
		$iniFile = new INIFile('config.ini');
		$password = $iniFile->getValue('password','database');
		$username = $iniFile->getValue('username','database');
		$hostname = $iniFile->getValue('hostname','database');
		$database = $iniFile->getValue('database','database');
		
		self::$dbh = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
		self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	protected function fatal_error($msg) {
		echo "<pre>Error!: $msg\n";
		$bt = debug_backtrace();
		foreach($bt as $line) {
			$args = var_export($line['args'], true);
			echo "{$line['function']}($args) at {$line['file']}:{$line['line']}\n";
		}
		echo "</pre>";
		die();
	}

	function insertMovie($item) {
		$t = $_SERVER["REQUEST_TIME"];
		try {
			if(!self::$dbh) $this->connect();
			$stmt = self::$dbh->prepare("INSERT INTO movies
                                    (id,cat,sdesc,ldesc,price,ctime)
                                   VALUES 
                                    (NULL,:cat,:sdesc,:ldesc,:price,$t)");
			$params = array(':cat'  =>$item['cat'],
                      		':sdesc'=>$item['sdesc'],
                      		':ldesc'=>$item['ldesc'],
                      		':price'=>$item['price']);
			$ret = $stmt->execute($params);
		} catch (PDOException $e) {
			$this->fatal_error($e->getMessage());
		}
		return $ret;
	}

	function modifyMovie($item) {
		try {
			if(!self::$dbh) $this->connect();
			$stmt = self::$dbh->prepare("UPDATE items SET
                                    	cat=:cat, sdesc=:sdesc, 
                                   	 	ldesc=:ldesc, price=:price 
                                   	WHERE id=:id");
			$params = array(':cat'  =>$item['cat'],
                      		':sdesc'=>$item['sdesc'],
                      		':ldesc'=>$item['ldesc'],
                      		':price'=>$item['price'],
                      		':id'=>$item['id']);
			$ret = $stmt->execute($params);
		} catch (PDOException $e) {
			$this->fatal_error($e->getMessage());
		}
		return $ret;
	}

	function loadMovie($id=-1) {
		$where = '';

		if($id!=-1) $where = "where id=".(int)$id;
		try {
			if(!self::$dbh) $this->connect();
			$result = self::$dbh->query("SELECT * FROM catalog $where order by movie desc");
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			$this->fatal_error($e->getMessage());
		}
		return $rows;
	}
	
	function loadLastMovie() {
		try {
			if(!self::$dbh) $this->connect();
			$result = self::$dbh->query("SELECT *,DATE_FORMAT(last_modified, '%Y-%m-%d %H:%i:%s') FROM catalog ORDER BY last_modified DESC LIMIT 5");
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			$this->fatal_error($e->getMessage());
		}
		return $rows;
	}
	
	function exec($sql) {
		try {
			if(!self::$dbh) $this->connect();
			$ret = self::$dbh->query($sql);
		} catch (PDOException $e) {
			$this->fatal_error($e->getMessage());
		}
		return $ret;
	}
	
	function searchMovie($sql) {

		if($sql == '') throw PDOException;
		try {
			if(!self::$dbh) $this->connect();
			$result = self::$dbh->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			$this->fatal_error($e->getMessage());
		}
		return $rows;
	}	
}
