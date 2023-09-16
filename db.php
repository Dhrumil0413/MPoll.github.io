<?php
	$db_host = "localhost";
	$db_user = "dvb664";  
	$db_pwd = "Sin2x+cos2x=1"; 
	$db_db = "dvb664";

	$charset = 'utf8mb4';
	$attr = "mysql:host=$db_host;dbname=$db_db;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
?>