<?php

$logged = false;
if ($_COOKIE['c_klant'] && $_COOKIE['c_salt']){
	$cklant = mysql_real_escape_string($_COOKIE['c_klant']);
	$csalt = mysql_real_escape_string($_COOKIE['c_salt']);
	$klant = mysql_fetch_array(mysql_query("SELECT * FROM `klant` WHERE `Salt`='$csalt'"));
	if ($klant != 0){
		if (hash("sha512", $klant['EmailKL']) == $cuser){ 
			$logged = true;
		}
	}
} 