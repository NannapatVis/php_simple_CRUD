<?php
	session_start();

	//13.display old info and update into users table
    include_once 'dbconnect.php';

	//fetch existing record
	if (isset($_GET['user_id'])) {
		$SQL = "SELECT * FROM users WHERE id = " . $_GET['user_id'];
		$result = mysqli_query($con, $SQL);
		$row = mysqli_fetch_array($result);
	}

	//update record
	if (isset($_POST['update'])) {
		$user_id = $_POST['id'];
		$user_name = $_POST['txtName'];
		$user_email = $_POST['txtEmail'];
		$user_passwd = $_POST['txtPassword'];
		$user_cpassword = $_POST['txtCPassword'];

		//validate data before updating
		$chk_error = false;

		//validate user name
		if (preg_match_all("/^[a-zA-Z]+$/", $user_name)) {
			$chk_error = true;
			$err_msg = "Name must contain only alphabets and space";
		}
		//validate e-mail
		if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
			$chk_error = true;
			$err_msg = "Please enter valid e-mail";
		}
		//validate password
		if (strlen($user_passwd) < 6) {
			$chk_error = true;
			$err_msg = "Password must be minimum of 6 characters";
		}
		//validate password and confirm password
		if ($user_passwd != $user_cpassword) {
			$chk_error = true;
			$err_msg = "Password don't match";
		}

		if ($chk_error == false) {
			$SQL_Update = "UPDATE users SET name = '" . $user_name . "', 
						   	email = '" . $user_email . "', 
							password = '" . md5($user_passwd) . "' WHERE id = " . $user_id; 
			if (mysqli_query($con, $SQL_Update)){
				$success_msg = "Updated successfuly.";
				header("Location: show_user.php");
			} else {
				$err_msg = "Updated error!";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update User</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">PHP Simple CRUD</a>
		</div>
		<!-- menu items -->
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Sign Up</a></li>
				<li class="active"><a href="admin_login.php">Admin</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="updateform">
				<fieldset>
					<legend>Update</legend>

					<!--14.display old info in text field -->
					<div class="form-group">
						<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
						<label for="txtName">Name</label>
						<input type="text" name="txtName" placeholder="Enter Full Name" required value="<?php echo $row['name']; ?>" class="form-control" />
					</div>

					<div class="form-group">
						<label for="txtEmail">Email</label>
						<input type="text" name="txtEmail" placeholder="Email" required value="<?php echo $row['email']; ?>" class="form-control" />
					</div>

					<div class="form-group">
						<label for="txtPassword">Password</label>
						<input type="password" name="txtPassword" placeholder="Password" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="txtCPassword">Confirm Password</label>
						<input type="password" name="txtCPassword" placeholder="Confirm Password" required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="update" value="Update" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<!--15.display message -->
			<span class= "text-danger">
				<?php if (isset($err_msg)) {
					echo $err_msg;
				} ?>
			</span>
		</div>
	</div>
</div>
</body>
</html>
