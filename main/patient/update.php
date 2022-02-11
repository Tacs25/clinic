<?php
include_once 'header.php';
require_once '../includes/functions.inc.php';
require_once '../includes/dbh.inc.php';
session_start();
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div id="edit">
<div id ="main" >
<div class="container mt-4 " id="content">
	<div class="row content d-flex justify-content-center">
		<div class="col col-md-6">
			<span id="message"></span>
			<div class="card">
				<div class="card-header">Register</div>
				<div class="card-body">
					<form method="post" id="patient_register_form" action="../includes/update.inc.php">
						<div class="form-group">
							<label>Current Password<span class="text-danger"></label>
							<input type="password" name="current_password" id="current_password" class="form-control" required  />
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>New Password<span class="text-danger"></label>
									<input type="password" name="new_password" id="new_password" class="form-control" required   />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Confirm Password<span class="text-danger"></label>
									<input type="password" name="repeat_password" id="repeat_password" class="form-control" required   />
								</div>
							</div>
						</div>
						<div class="form-group text-center">
							<input type="hidden" name="action" value="patient_register" />
							<input type="submit" name="edit_button" id="edit_button" class="btn btn-primary btn-block" value="Confirm" />
						</div>

						<div class="form-group text-center">
							<p><a href="../patient/profile.php">Cancel</a></p>
						</div>
					</form>
				</div>
			</div>
			<br />
			<br />
		</div>
	</div>
</div> 
</div>
</div>  
			<?php 
				if (isset($_GET["error"])){
					if ($_GET["error"] === "passnotmatch"){
            			?>
            			<script>
            			swal("Something Went Wrong", "Password didn't match", "error");
            			</script>
          				<?php
          			}
					else if ($_GET["error"] === "wrongpassword1"){
            			?>
            			<script>
            			swal("Something Went Wrong", "Wrong Password", "error");
            			</script>
          				<?php
          			}
      			}

