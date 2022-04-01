<?php
session_start();
$sqli = mysqli_connect("localhost", "root", "", "patient_details") or die("Could not connect database...");
$update = false;
$id = $name = $birthDate = $age = $address = $city = $state = "";
if (isset($_REQUEST['edit'])) {
	$id = $_REQUEST['edit'];
	$update = true;
	$record = mysqli_query($sqli, "SELECT * FROM patients WHERE id=$id");

	if (count(array($record)) == 1) {
		$num = mysqli_fetch_array($record);
		$id = $num['id'];
		$name = $num['ptname'];
		$birthDate = $num['birth_date'];
		$age = $num['age'];
		$address = $num['address'];
		$city = $num['city'];
		$state = $num['state'];
	}
}
if (isset($_REQUEST['save'])) {

	$_name = $_REQUEST['pt_name'];
	$_birthDate = $_REQUEST['birth_date'];
	$_age = $_REQUEST['age'];
	$_address = $_REQUEST['address'];
	$_city = $_REQUEST['city'];
	$_state = $_REQUEST['state'];

	mysqli_query($sqli, "INSERT INTO `patients` (`id`, `ptname`, `birth_date`, `address`, `age`, `city`, `state`) VALUES (NULL, '$_name', '$_birthDate', '$_address', '$_age', '$_city', '$_state')");
	$_SESSION['msg'] = "Patient Saved";
	header("location:index.php");
}
if (isset($_REQUEST['update'])) {
	$id = $_REQUEST['id'];
	$name = $_REQUEST['pt_name'];
	$birthDate = $_REQUEST['birth_date'];
	$age = $_REQUEST['age'];
	$address = $_REQUEST['address'];
	$city = $_REQUEST['city'];
	$state = $_REQUEST['state'];

	mysqli_query($sqli, "UPDATE `patients` SET `ptname` = '$name', `birth_date` = '$birthDate', `address` = '$address', `age` = '$age', `city` = '$city', `state` = '$state' WHERE `patients`.`id` = $id");
	$_SESSION['msg'] = "Patient Data Updated.";
	header("location:index.php");
}
if (isset($_REQUEST['del'])) {
	$id = $_REQUEST['del'];
	mysqli_query($sqli, "DELETE FROM patients WHERE id = $id");
	$_SESSION['msg'] = "Patient Data is deleted";
	header("location:index.php");
}


?>
<!DOCTYPE html>
<html>

<head>
	<title>Patients Details</title>
	<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<script type="text/javascript">
		function clear() {
			document.getElementsByTagName('id').clear();
			document.getElementsByTagName('name').clear();
			document.getElementsByTagName('salary').clear();
		}

		function back() {
			window.location.href = "https://www.google.com";
		}
	</script>
</head>

<body>
	<?php

	if (isset($_SESSION['msg'])) {
		echo "<div class='msg'>";
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
		echo "</div>";
	}
	$query = mysqli_query($sqli, "SELECT * FROM patients");
	?>

	<div class="container-fluid bg-light pb-5">
		<div class="container ">
			<div class="text-center pt-5">
				<h3>Patients Record</h3>
				<p>Patients list available in the datatbase record</p>
				<table class="table table-striped ">
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>DOB</th>
						<th>Age</th>
						<th>Address</th>
						<th>State</th>
						<th>City</th>
						<th colspan="2">Action</th>
					</tr>
					<?php

					while ($row = mysqli_fetch_array($query)) {
						echo "<tr>";
						echo "<td>" . $row['id'] . "</td>";
						echo "<td>" . $row['ptname'] . "</td>";
						echo "<td>" . $row['birth_date'] . "</td>";
						echo "<td>" . $row['age'] . "</td>";
						echo "<td>" . $row['address'] . "</td>";
						echo "<td>" . $row['state'] . "</td>";
						echo "<td>" . $row['city'] . "</td>";
						echo "<td><a class='link' href=index.php?edit=" . $row['id'] . "><i class='fas fa-edit'></i></a></td>";
						echo "<td><a class='link' href=index.php?del=" . $row['id'] . "><i class='fas fa-trash'></i></a></td>";
						echo "</tr>";
					}
					?>
				</table>
			</div>



			<div class="row pt-5">
				<div class="col-8 offset-md-2">
					<div class="card p-5 ">
						<form action="#" method="POST">
							<!-- <div class="form-group">
				      <label>ID</label>
				      <input type="text" name="id" class="form-control" value="<?php echo $id; ?>">
			         </div> -->
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<div class="row">
								<div class="form-group col-6">
									<label>Name</label>
									<input type="text" name="pt_name" class="form-control" value="<?php echo $name; ?>" required>
								</div>
								<div class="form-group col-6">
									<label>Date of Birth</label>
									<input type="date" name="birth_date" class="form-control" value="<?php echo $birthDate; ?>" required>
								</div>
							</div>


							<div class="row">
								<div class="form-group col-6">
									<label>Age</label>
									<input type="number" max="150" min="1" name="age" class="form-control" value="<?php echo $age; ?>" required>
								</div>
								<div class="form-group col-6">
									<label>Address</label>
									<!-- <textarea type="text" name="address" class="form-control" value="<?php echo $address; ?>"></textarea> -->
									<input type="text" name="address" class="form-control" value="<?php echo $address; ?>" required>
								</div>
							</div>


							<?php
							$query_state = mysqli_query($sqli, "SELECT * FROM states where country_code = 'IN'");
							// $state = mysqli_fetch_array($query_state);

							?>
							<div class="row">
								<div class="form-group col-6">
									<label>State</label>
									<input type="text" name="state" class="form-control" value="<?php echo $state; ?>" required>
									<!-- <select name="state" id="state-dd" class="form-control" value="" required autocomplete="state" >
								<option value="">Select State</option>
								<?php
								while ($state = mysqli_fetch_array($query_state)) {
									echo "<option value=" . $state['name'] . " >" . $state['name'] . "</option>";
								}
								?>

							</select> -->
								</div>


								<div class="form-group col-6">
									<label>City</label>
									<input type="text" name="city" class="form-control" value="<?php echo $city; ?>" required>

								</div>
							</div>

							<div class="form-group text-center">
								<?php if ($update == true) { ?>
									<button class="btn btn-primary" type="submit" name="update"> Update </button>
								<?php } elseif ($update == false) { ?>
									<button class="btn btn-success" type="submit" name="save" onclick="clear()"> +Add New </button>
								<?php } ?>

							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>