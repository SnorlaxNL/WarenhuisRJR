<?php

$connection = mysql_connect("localhost", "user", "") or die("Er was geen verbinding met de server!");
mysql_select_db("rjr", $connection) or die("Er was geen verbinding met de database!");

error_reporting(0);

if ($_POST['register']){
	if ($_POST['EmailKL'] && $_POST['WachtwoordKL']){
		$EmailKL = mysql_real_escape_string($_POST['EmailKL']);
		$WachtwoordKL = mysql_real_escape_string(hash("sha512", $_POST['WachtwoordKL']));
		$NaamKL = '';
		if ($_POST['NaamKL']){
			$NaamKL = mysql_real_escape_string(strip_tags($_POST['NaamKL']));
		}
		$AdresKL = '';
        if ($_POST['AdresKL']){
			$AdresKL = mysql_real_escape_string(strip_tags($_POST['AdresKL']));
		}		
		$PostcodeKL = '';
		if ($_POST['PostcodeKL']){
			$PostcodeKL = mysql_real_escape_string(strip_tags($_POST['PostcodeKL']));
		}
		$PlaatsKL = '';
		if ($_POST['PlaatsKL']){
			$PlaatsKL = mysql_real_escape_string(strip_tags($_POST['PlaatsKL']));
		}
		$LandKL = '';
		if ($_POST['LandKL']){
			$LandKL = mysql_real_escape_string(strip_tags($_POST['LandKL']));
		}
		$TelNrKL = '';
		if ($_POST['TelNrKL']){
			$TelNrKL= mysql_real_escape_string(strip_tags($_POST['TelNrKL']));
		}
		$IBANKL = '' ;
		if ($_POST['IBANKL']){
			$IBANKL = mysql_real_escape_string(strip_tags($_POST['IBANKL']));
		}
		$check = mysql_fetch_array(mysql_query("SELECT * FROM `klant` WHERE `EmailKL`='$EmailKL'"));
		if ($check != '0'){
			die("Dit E-mail adres bestaat al! Probeer een andere.<a href='register.php'>&larr; Ga terug</a>");	
		}
		if (!ctype_alnum($PlaatsKL)){
			die("Uw plaats bevat speciale tekens! Alleen letters en cijfers zijn toegestaan!<a href='register.php'>&larr; Ga terug</a>");
		}
		if (!ctype_alnum($LandKL)){
			die("Uw land bevat speciale tekens! Alleen letters en cijfers zijn toegestaan!<a href='register.php'>&larr; Ga terug</a>");
		}
		if (!ctype_alnum($TelNrKL)){
			die("Uw telefoon nummer bevat speciale tekens! Alleen letters en cijfers zijn toegestaan!<a href='register.php'>&larr; Ga terug</a>");
		}
		if (!ctype_alnum($IBANKL)){
			die("Uw IBAN bevat speciale tekens! Alleen letters en cijfers zijn toegestaan!<a href='register.php'>&larr; Ga terug</a>");
		}
		if (strlen($PostcodeKL) > 6){
			die("Uw postcode mag niet meer dan 6 tekens bevatten!<a href='register.php'>&larr; Ga terug</a>");
		}
		if (strlen($TelNrKL) > 10){
			die("Uw Telefoon nummer mag niet meer dan 10 tekens bevatten!<a href='register.php'>&larr; Ga terug</a>");
		}
		if (strlen($IBANKL) > 18){
			die("Uw IBAN mag niet meer dan 18 tekens bevatten!<a href='register.php'>&larr; Ga terug</a>");
		}
		$salt = hash("sha512", rand() . rand() . rand());
		mysql_query("INSERT INTO `klant` (`EmailKL`, `WachtwoordKL`, `NaamKL`, `AdresKL`, `PostcodeKL`, `PlaatsKL`, `LandKL`, `TelNrKL`, `IBANKL`, `Salt`) VALUES ('$EmailKL', '$WachtwoordKL', '$NaamKL', '$AdresKL', '$PostcodeKL', '$PlaatsKL', '$LandKL', '
		$TelNrKL', '$IBANKL', '$salt')");
		setcookie("c_klant", hash("sha512", $EmailKL), time() + 24 * 60 * 60, "/");
		setcookie("c_salt", $salt, time() + 24 * 60 * 60, "/");
		die("Uw account is aangemaakt en u bent nu ingelogged.");
	}
}
echo "
<body style='font-family: verdana, sans-serif;'>
		<div style='width: 80%; padding: 5px 15px 5px; border: 1px solid #e3e3e3; background-color: #fff; color: #000';
			<h1>Registreren</h1>
			<br />
			<form action='' method='post'>
				<table>
					<tr>
						<td>
							<b>E-mail:</b>
						</td>
						<td>
							<input type='text' name='EmailKL' style='padding: 4px;' />
						</td>
					</tr>
					
					<tr>
						<td>
							<b>Wachtwoord:</b>
						</td>
						<td>
							<input type='password' name='WachtwoordKL' style='padding: 4px;' />
						</td>
					</tr>
					<tr>
						<td>
							<b>Naam:</b>
						</td>
						<td>
							<input type='text' name='NaamKL' style='padding: 4px;' />
						</td>
					</tr>
					
					<tr>
						<td>
							<b>Adres:</b>
						</td>
						<td>
							<input type='text' name='AdresKL' style='padding: 4px;' />
						</td>
					</tr>
					<tr>
						<td>
							<b>Postcode:</b>
						</td>
						<td>
							<input type='text' name='PostcodeKL' style='padding: 4px;' />
						</td>
					</tr>
					<tr>
						<td>
							<b>Plaats:</b>
						</td>
						<td>
							<input type='text' name='PlaatsKL' style='padding: 4px;' />
						</td>
					</tr>
					<tr>
						<td>
							<b>Land:</b>
						</td>
						<td>
							<input type='text' name='LandKL' style='padding: 4px;' />
						</td>
					</tr>
					<tr>
						<td>
							<b>Telefoon nummer:</b>
						</td>
						<td>
							<input type='text' name='TelNrKL' style='padding: 4px;' />
						</td>
					</tr>
					<tr>
						<td>
							<b>IBAN:</b>
						</td>
						<td>
							<input type='text' name='IBANKL' style='padding: 4px;' />
						</td>
					</tr>
					<tr>
						<td>
							<input type='submit' name='register' value='Registreren' />
						</td>
					</tr>
	";