<?php
	include 'connection.php';
	include 'function.php';

	if(isset($_POST["user_id"])){
		$user_id = $_POST["user_id"];
		$output = array();
		$stmt = $con->prepare("SELECT * from employee WHERE id ='".$user_id."' LIMIT 1");
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach ($result as $row) {
			$output["firstname"] = $row["firstname"];
			$output["lastname"] = $row["lastname"];
			$output["address"] = $row["address"];
		}
		echo json_encode($output);
	}
?>