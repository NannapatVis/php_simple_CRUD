<?php
		//7.check admin username and password, set admin name as "admin" and password as "pass1234"
		session_start();
			
		include_once 'dbconnect.php';

		if (isset($_POST['login'])) {
			$admin_email = $_POST['admin_email'];
			$admin_passwd = $_POST['admin_password'];

			$SQL = "SELECT * FROM users WHERE name = 'admin'  AND email = '" . $admin_email . "'
					AND password = '" . md5($admin_passwd) . "'";
			$result = mysqli_query($con, $SQL);
			if ($row = mysqli_fetch_array($result)) {
				$_SESSION["user_id"] = $row['id'];
				$_SESSION["user_name"] = $row['name'];
				header("Location: show_user.php");
			}else {
				$err_msg = "[Admin] Incorrect e-mail or password.";
			}
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP Admin | Login</title>
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
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
				<fieldset>
					<legend>Login</legend>

					<div class="form-group">
						<label for="name">Admin E-mail</label>
						<input type="text" name="admin_email" placeholder="Admin E-mail" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="admin_password">Password</label>
						<input type="password" name="admin_password" placeholder="Your Password" required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="login" value="Login" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<!--8.display message -->
			<span class='text-danger'>
				<?php 
					if(isset($err_msg)) {
						 echo $err_msg; 
						}
				?>
			</span>
		</div>
	</div>
</div>
</body>
</html>
