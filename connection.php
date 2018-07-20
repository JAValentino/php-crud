<?php
	$username = "root";
	$password = "";

	try {
		$con = new PDO('mysql:host=localhost;dbname=pdo', $username,$password);
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
?>