<!DOCTYPE html>
<html lang="en">
  <head>
	  <title>CRUD</title>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
	    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
	    <link href="css/style.css" rel="stylesheet">
	    <link rel="stylesheet" href="css/AdminLTE.min.css">
 		<link rel="stylesheet" href="css/skins/_all-skins.min.css">   
 </head>
 <body>
 	<div class="content-wrapper">
 		<div class="container">
 			<div class="row">
 				<div class="col-lg-12">
 					<div class="panel panel-default">
 						<div class="panel-body" >
 							<button type="button" id="add" data-toggle="modal" data-target="#mymodal" class="btn btn-success"><i class="fa fa-plus"></i> Add New Employee</button>
 							<br><br>
 							<!--Table-->
 							<div class="col-lg-12">
 								<div class="panel panel-primary">
 									<div class="panel-heading">
 										<p class="text-default">Records</p>
 									</div>
 									<div class="panel-body">
 										<div class="table-responsive">
 											<table class="table table-striped table-bordered" id="table">
 												<thead>
 													<tr>
 														<th width="5%">ID</th>
 														<th>FirstName</th>
 														<th>LastName</th>
 														<th>Address</th>
 														<th width="5%">View</th>
 														<th width="5%">Edit</th>
 														<th width="5%">Delete</th>
 													</tr>
 												</thead>
 											</table>
 										</div>
 									</div>
 								</div>
 							</div>
 						</div>
 					</div>
 				</div>
 			</div>
 			<!--Add & Edit Modal-->
	    	<div class="modal" id="mymodal">
	      		<div class="modal-dialog">
	      			<form method="post" id="form">
			       		<div class="modal-content">
			          		<!--modal header-->
			          		<div class="modal-header">
			            		<button type="button" class="close" data-dismiss="modal"><i class="fa fa-remove"></i></button>
			            		<h2 class="modal-title"> Add New User</h2>
			          		</div>
			          		<!--modal body-->
			          		<div class="modal-body">
				          		<label>First Name:</label><br>
				          		<div class="input-group"> 
				            		<span class="input-group-addon"><i class="fa fa-user"></i></span>
				            		<input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname">
				          		</div><br>
				          		<label>Last Name:</label><br>
				          		<div class="input-group"> 
				            		<span class="input-group-addon"><i class="fa fa-user"></i></span>
				            		<input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname">
				          		</div><br>
				          		<label>Address:</label>
				          		<div class="input-group">
				          			<span class="input-group-addon"><i class="fa fa-home"></i></span>
				          			<textarea rows="4" cols="4" class="form-control" id="address" name="address"></textarea>
				          		</div><br>
	     			   		</div>
				       		<div class="modal-footer">
					       		<div class="col-lg-12">
					        		<input type="hidden" name="user_id" id="user_id">
					        		<input type="hidden" name="operation" id="operation">
					        		<button class="btn btn-primary" type="submit" name="submit" id="submit"> Submit</button>
						       		<button class="btn bnt-deafult" type="button" name="close" id="close" data-dismiss="modal"> Close</button>
						    	</div>
			           		</div>
			        	</div>
			    	</form>
	      		</div>
	    	</div>
	    	<!--View Modal-->
	    	<div class="modal" id="viewmodal">
	      		<div class="modal-dialog">
	      			<form method="post" id="form">
			       		<div class="modal-content">
			          		<!--modal header-->
			          		<div class="modal-header">
			            		<h2 class="modal-title"> View User</h2>
			          		</div>
			          		<!--modal body-->
			          		<div class="modal-body">
				          		<div id="view_info"></div>
	     			   		</div>
				       		<div class="modal-footer">
						       	<button class="btn bnt-deafult" type="button" name="close" id="close" data-dismiss="modal"> Close</button>
			           		</div>
			        	</div>
			    	</form>
	      		</div>
	    	</div>
 		</div>
 	</div>
 	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/adminlte.min.js"></script>
 	<script type="text/javascript">
 		$(document).ready(function(){
 			$('#add').on('click', function(){
 				$('#form')[0].reset();
 				$('.modal-title').text('Add New Info');
 				$('#submit').val("Add").text("Submit");
 				$('#operation').val("Add");
 			});

 			var table = $('#table').DataTable({
 				"processing":true,
 				"serverSide":true,
 				"order":[],
 				"ajax":{
 					url:"fetch.php",
 					type:"POST"
 				},
 				"columnDefs":[
 					{
 						"targets":[4, 5, 6],
 						"orderable": false,
 					},
 				],
 				"autoWidth": false

 			});

 			$(document).on('submit', '#form', function(event){
 				event.preventDefault();
 				var firstname = $('#firstname').val();
 				var lastname = $('#lastname').val();
 				var address = $('#address').val();
 				if(firstname != '' && lastname != '' && address != ''){
 					$.ajax({
 						url:"action.php",
 						method:"POST",
 						data:new FormData(this),
 						contentType:false,
 						processData:false,
 						success:function(data){
 							alert(data);
 							$('#form')[0].reset();
 							$('#mymodal').modal('hide');
 							table.ajax.reload();
 						}
 					})
 				} else{
 					alert("All fields are required");
 				}
 			});

 			$(document).on('click', '.view', function(){
 				var user_id = $(this).attr("id");
 				var operation = 'view_info';
 				$.ajax({
 					url:"action.php",
 					method:"POST",
 					data:{user_id:user_id,operation:operation},
 					success:function(data){
 						$('#viewmodal').modal('show');
 						$('.modal-title').text("View Details");
 						$('#view_info').html(data);
 					}
 				})
 			});

 			$(document).on('click', '.update', function(){
 				var user_id = $(this).attr("id");
 				$.ajax({
 					url:"single_fetch.php",
 					method:"POST",
 					data:{user_id:user_id},
 					dataType:"json",
 					success:function(data){
 						$('#mymodal').modal('show');
 						$('#firstname').val(data.firstname);
 						$('#lastname').val(data.lastname);
 						$('#address').val(data.address);
 						$('#user_id').val(user_id);
 						$('.modal-title').text("Edit Info");
 						$('#submit').val("Edit").text("Edit");
 						$('#operation').val("Edit");
 					}

 				})
 			});

 			$(document).on('click', '.delete', function(){
 				var user_id = $(this).attr("id");
 				var operation = "delete";
 				if(confirm("Are you sure want to delete this?")){
 					$.ajax({
 						url:"action.php",
 						method:"POST",
 						data:{user_id:user_id,operation:operation},
 						success:function(data){
 							alert(data);
 							table.ajax.reload();
 						}
 					})
 				} else{
 					return false;
 				}
 			});

 		});
 	</script>

</body>
</html>

