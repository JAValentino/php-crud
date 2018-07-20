<?php
	include 'connection.php';
	include 'function.php';

	$query = '';
	$output = array();
	$query .= "SELECT * from employee ";
	if(isset($_POST["search"]["value"])){
		$query .= 'WHERE firstname LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR lastname LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR address LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if(isset($_POST["order"])){
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	} else{
		$query .= 'ORDER BY id ASC ';
	}
	if($_POST["length"] != -1){
		$query .= 'LIMIT '.$_POST['start'].', '.$_POST['length'];
	}
	$stmt = $con->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll();
	$data = array();
	$filtered_rows = $stmt->rowCount();
	foreach ($result as $row) {
		$sub_array = array();
		$sub_array[] = $row["id"];
		$sub_array[] = $row["firstname"];
		$sub_array[] = $row["lastname"];
		$sub_array[] = $row["address"];
		$sub_array[] = '<button type"button" name="view" id="'.$row["id"].'" class="btn btn-info view"><i class="fa fa-eye"></i></button>';
		$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-primary update"><i class="fa fa-edit"></i></button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger delete"><i class="fa fa-trash"></i></button>';

		$data[] = $sub_array;
	}
	$output = array(
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => $filtered_rows,
		"recordsFiltered" => get_total_records(),
		"data" => $data
	);
	echo json_encode($output);
?>
