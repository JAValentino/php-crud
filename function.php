<?php
	function get_total_records(){
		include 'connection.php';

		$stmt = $con->prepare("SELECT * from employee ");
		$stmt->execute();
		return $stmt->rowCount();
	}
?>