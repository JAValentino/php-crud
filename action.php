<?php
	include 'connection.php';

	if(isset($_POST["operation"])){
		if($_POST["operation"] == "Add"){
			$stmt = $con->prepare("INSERT INTO employee(firstname,lastname,address) VALUES(:firstname,:lastname,:address)");
			$result = $stmt->execute(
				array(
					':firstname' => $_POST["firstname"],
					':lastname' => $_POST["lastname"],
					':address' => $_POST["address"]
				)
			);
			if(!empty($result)){
				echo "Data Successfully Inserted";
			}
		}
		if($_POST["operation"] == "Edit"){
			$stmt = $con->prepare("UPDATE employee SET firstname = :firstname, lastname = :lastname, address = :address WHERE id = :id");
			$result = $stmt->execute(
				array(
					':firstname' => $_POST["firstname"],
					':lastname' => $_POST["lastname"],
					':address' => $_POST["address"],
					':id' => $_POST["user_id"]
				)
			);
			if(!empty($result)){
				echo "Data Updated";
			}
		}
		if($_POST["operation"] == "view_info"){
			$stmt = $con->prepare("SELECT firstname,lastname,address from employee WHERE id =:id ");
			$stmt->execute(
				array(
					':id' => $_POST["user_id"]
				)
			);
			$result = $stmt->fetchAll();
			$view = '
				<div class="table-responsive">
					<table class="table table-boredered">
			';
			foreach ($result as $row) {
				$view .= '
					<tr>
						<td><b>FirstName:</b></td>
						<td>'.$row["firstname"].'</td>
					</tr>
					<tr>
						<td><b>LastName:</b></td>
						<td>'.$row["lastname"].'</td>
					</tr>
					<tr>
						<td><b>Address:</b></td>
						<td>'.$row["address"].'</td>
					</tr>
				';
				$view .='
						</table>
					</div>
				';
				echo $view;
			}
		}
		if($_POST["operation"] == "delete"){
			$stmt = $con->prepare("DELETE from employee WHERE id=:id");
			$result = $stmt->execute(
				array(
					":id" => $_POST["user_id"]
				)
			);
			if(!empty($result)){
			echo "Data Deleted";
			}
		}
	}
?>