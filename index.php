<?php

$connection = mysql_connect("localhost", "user", "") or die("Er was geen verbinding met de server!");
mysql_select_db("rjr", $connection) or die("Er was geen verbinding met de database!");

error_reporting(0);

if ($_POST['login']){
	if ($_POST[EmailKL] && $_POST['WachtwoordKL']){
		$EmailKL = mysql_real_escape_string($_POST['EmailKL']);
		$WachtwoordKL = mysql_real_escape_string(hash("sha512", $_POST['WachtwoordKL']));
		$klant = mysql_fetch_array(mysql_query("SELECT * FROM `klant` WHERE `EmailKL`='$EmailKL'"));
		if ($klant == '0'){
			die("Dit E-mail adres bestaat niet! Probeer opnieuw, of maak een <i>$EmailKL</i> vandaag! <a href='index.php'>&larr; Ga terug</a>");
		}
		if ($klant['WachtwoordKL'] != $WachtwoordKL){
			die("Fout wachtwoord! <a href='index.php'>$larr; Ga terug</a>");
		}
		$salt = hash("sha512", rand() . rand() . rand());
		setcookie("c_klant", hash("sha512", $EmailKL), time() + 24 * 60 * 60, "/");
		setcookie("c_salt", $salt, time() + 24 * 60 * 60, "/");
		$klantID = $klant['KlantNR'];
		mysql_query("UPDATE `klant` SET 'Salt'='$salt' WHERE 'KlantNR'='$klantID'");
		die("U bent nu ingelogged als $EmailKL!");
		
	}
}

include "algor.php";

if ($logged==true){
	echo("U bent al ingelogged!");
}

include "algor.php";

session_destroy();
$logged = false;
setcookie("c_salt", "", time()-3600, "/");
setcookie("c_klant", "", time()-3600, "/");
header('Location: index.php');exit();
return true;

echo "
	
<body style='font-family: verdana, sans-serif;'>
		<div style='width: 80%; padding: 5px 15px 5px; border: 1px solid #e3e3e3; background-color: #fff; color: #000';
			<h1>Login</h1>
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
								<input type='submit' value='Login' name='login' />
					</table>
			</form>
			<br />
			<h6>
				Geen account? <a href='register.php'>Registreer nu!</a>
			</h6>
		</div>	
		</body>
";