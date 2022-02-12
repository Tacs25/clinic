<?php
    include('header.php');
	include_once '../includes/dbh.inc.php';
	session_start();
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="container-fluid">
	<?php $page = 'appointment'; include('navbar.php'); ?>

    <br />

	<div class="card">
		<span id="message"></span>
		<div class="card-header"><h4>My Appointment List</h4></div>
			<div class="card-body">
				<div class="table-responsive">
		      		<table class="table table-striped table-bordered" id="appointment_list_table">
		      			<thead>
			      			<tr>
			      				<th>Appointment No.</th>
			      				<th>Appointment Date</th>
			      				<th>Appointment Start Time</th>
			      				<th>Appointment End Time</th>
			      				<th>Appointment Duration</th>
			      				<th>Download</th>
			      				<th>Cancel</th>
			      			</tr>
			      		</thead>
						<?php
							$email = $_SESSION['email'];
							date_default_timezone_set('Asia/Manila');
							$date = date('Y-m-d');
							$time = date('H:i:s');
                        	$result = $conn->query("SELECT * FROM booked WHERE Email = '$email' AND sched >= '$date'");
                          	while ($row = $result->fetch_assoc()){
                        ?>
			      		<tbody>
						  <tr>
						  <td><?php echo $row['ID'];?></td>
                            <td><?php echo $row['sched'];?></td>
                            <td><?php echo $row['start_time'];?></td>
                            <td><?php echo $row['end_time'];?></td>
                            <td><?php echo $row['duration'];?> minutes</td>
							<td><input type="submit" name ="booking" class="btn btn-primary" value ="Download"/></td>
							<td></td>
                          </tr>
						</tbody>
						
						<?php
						if (isset($_GET["error"])){
							if($_GET["error"] === "none"){
								?>
									<script>
									swal("Nice", "Booked Successfully", "success");
									</script>
					  			<?php
							}
		
						}
						  }
						  ?>
			      	</table>
					 
			    </div>
			</div>
		</div>
	</div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
    $('#appointment_list_table').DataTable();
} );
</script>