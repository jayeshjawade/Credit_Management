<!DOCTYPE html>
<html lang="en">

<?php 
require_once 'includes/head.php';

// Query
$sql = "SELECT * FROM credit WHERE acc_no = '".$_GET['ac_no']."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<body>
	<nav class="navbar navbar-inverse navbar-static-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Credit Management</a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="index.php">Home</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">    
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 >User Profile</h4>
			</div>
			<div class="panel-body">
				<div class="col-md-4 col-xs-12 col-sm-6 col-lg-4 ">
					<img alt="User Pic" src="assests/images/pholder.jpg" id="profile-image1" class="img-circle img-responsive"> 
				</div>
				<div class="col-md-8 col-xs-12 col-sm-6 col-lg-8" >
						<br><br>
						<?php
						echo '
						<h2>'.$row['f_name'].' '.$row['l_name'].'</h2>
						<p><i class="glyphicon glyphicon-piggy-bank"></i> '.$row['acc_no'].'</p>
						<p><i class="glyphicon glyphicon-user"></i> <b>'.$row['u_name'].'</b></p>
						<p><i class="glyphicon glyphicon-phone"></i> '.$row['phone_no'].'</p>
						<p><i class="glyphicon glyphicon-envelope"></i> '.$row['email'].'</p>
						<p><i class="glyphicon glyphicon-usd"></i> '.$row['curr_credit'].'</p>
						<a href="transfer.php?ac_no='.$row['acc_no'].'" class="btn btn-success" role="button">Transfer Credit</a>
						';
						$conn->close();
						?>
						</div>
				</div>
		</div>
	</div>
</body>
</html>
