<?php
    session_start();
    
        if (!isset($_SESSION['user_id'])) {
            header("Location: admin_login.php");
    }
    //9.fetch and delete record
    include_once 'dbconnect.php';

    // fetch records
    $SQL = "SELECT * FROM users order by id DESC";
    $result = mysqli_query($con, $SQL);
    //display record number
    $cnt = 1;

    // delete record
    if (isset($_GET['user_id'])) {
        $SQL = "DELETE FROM users WHERE id = " . $_GET['user_id'];
        mysqli_query($con, $SQL);
        header("Location: show_user.php");
    }

 ?>

 <!DOCTYPE html>
 <html>
 <head>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" >
     <title>PHP Admin | Users</title>
     <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
             <?php if (isset($_SESSION['user_id'])) { ?>
						<li><span class="navbar-text">Signed in as <?php echo $_SESSION['user_name']; ?></span></li>
						<li><a href="logout.php">Sign Out</a></li>
				<?php	}else { ?>
						<li><a href="login.php">Login</a></li>
						<li><a href="register.php">Sign Up</a></li>
						<li><a href="admin_login.php">Admin</a></li>
				<?php } ?>
     		</ul>
     	</div>
     </div>
 </nav>

 <div class="container">
     <div class="row">
         <div class="col-xs-8 col-xs-offset-2">
             <legend>Show All Users</legend>

            <div class="table-responsive">
             <table class="table table-bordered table-hover">
                 <thead>
                     <tr>
                         <th>#</th>
                         <th>User Name</th>
                         <th>E-Mail</th>
                         <th>Password</th>
                         <th colspan="2" style="text-align:center">Actions</th>
                     </tr>
                 </thead>
                 <tbody>
                <!--10.show all users in this part of table -->
                <?php while ($row = mysqli_fetch_array($result)){ ?>
                    <tr>
                        <td><?php echo $cnt++; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td><a href="#" onclick="update_user(<?php echo $row['id']; ?>)"><i class="fa-solid fa-pencil"></i>แก้ไข</a></td>
                        <td><a href="#" onclick="delete_user(<?php echo $row['id']; ?>)"><i class="fa-solid fa-trash"></i>ลบ</a></td>
                    </tr>
                <?php } ?>
                 </tbody>
             </table>
            </div>
            <!--12.display number of records -->
            <span class="penel-footer"><?php echo $cnt-1 . "record(s) found."; ?></span>
         </div>
     </div>
 </div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <!--11.JavaScript for edit and delete actions -->
 <script>
    function delete_user(id) {
        if (confirm("Are you sure to delete this user?")) {
            window.location.href = "show_user.php?user_id=" + id;
        }
    }
    //update user
    function update_user(id) {
            window.location.href = "update_user.php?user_id=" + id;
        }
    
 </script>

 </body>
 </html>
