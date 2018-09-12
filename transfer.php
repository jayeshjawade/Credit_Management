<!DOCTYPE html>
<html lang="en">

<?php 
require_once 'includes/head.php';

//var to store creditor acc number
$to_acc = $_GET['ac_no'];

//var to store input values
$from_acc = $message = $amt = "";

//var to store error messages
$errFrom = $errMsg = $errAmt = "";

//form validation
if (isset($_POST["submit"]))
{
	$amt 	  = intval($_POST['amount']);
	$from_acc = (int) filter_var($_POST['toAcc'], FILTER_SANITIZE_NUMBER_INT);
	$message  = $_POST['message'];

	$get_credit_sql = "SELECT curr_credit FROM credit WHERE acc_no = '".$_POST['toAcc']."'";
	$result = $conn->query($get_credit_sql);
	$row = $result->fetch_assoc();
	
	//check empty message
	if(!$_POST['message'])
	{
		$errMsg = 'Please enter your message';
	}

	//check empty account selection
	if(!$_POST['toAcc'])
	{
		$errFrom = 'Please select an account';
		if(!$_POST['amount'])
		{
			$errAmt = 'Please enter credits to transfer';
		}
	}
	else
	{
		//check credits validity
		if($amt > $row['curr_credit'])
		{
			$errAmt = 'Transfer Credit exceeds Current Credit of the user';
		}
		if(!$_POST['amount'])
		{
			$errAmt = 'Please enter credits to transfer';
		}
		
	}

	if (empty($errMsg) && empty($errFrom) && empty($errAmt))
	{
		$sub_credit_sql = "UPDATE credit SET curr_credit = curr_credit - $amt WHERE acc_no = $from_acc";
		if($conn->query($sub_credit_sql))
		{
			$add_credit_sql = "UPDATE credit SET curr_credit = curr_credit + $amt WHERE acc_no = $to_acc";
			if($conn->query($add_credit_sql))
			{
				$record_trans_sql = "INSERT INTO transfer (from_acc, to_acc, credit_transfer, message) VALUES ('$from_acc', '$to_acc', '$amt','$message')";
				if($conn->query($record_trans_sql))
				{
					$status='<div class="alert alert-success">Credit sucessfully transferred</div>';
				}
				else
				{
					$status='<div class="alert alert-danger">Sorry there was an error. Please try again later</div>';
				}
			}
		}
	}
}
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
		<div class="table-responsive">
			<table class="table">
				<thead>
					<thead>
						<tr>
							<th>Acc No.</th>
							<th>Username</th>
							<th>Full Name</th>
							<th>Phone No</th>
							<th>Email</th>
							<th>Current Credit</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php
							//Query to display creditor account information
							$get_to_info_sql = "SELECT * FROM credit WHERE acc_no = '".$_GET['ac_no']."'";
							$result = $conn->query($get_to_info_sql);
							$row = $result->fetch_assoc();
							echo '
							<td>
								<p>'.$row['acc_no'].'</p>
							</td>
							<td>
								<p>'.$row['u_name'].'</p>
							</td>
							<td>
								<p>'.$row['f_name'].' '.$row['l_name'].'</p>
							</td>
							<td>
								<p>'.$row['phone_no'].'</p>
							</td>
							<td>
								<p>'.$row['email'].'</p>
							</td>
							<td>
								<p>'.$row['curr_credit'].'</p>
							</td>

								 ';
							?>
						</tr>
					</tbody>
			</table>
		</div>

		<form class="form-horizontal" role="form" method="post" action="">
			
			<div class="form-group">
				<label for="amount" class="col-sm-2 control-label">Amount</label>
				<div class="col-sm-10">
					<input type="number" min="0"  class="form-control" id="amount" name="amount" value="<?php echo htmlspecialchars($_POST['amount']);?>">
					<?php echo "<p class='text-danger'>$errAmt</p>";?>
				</div>
			</div>
			
			<div class="form-group">
				<label for="message" class="col-sm-2 control-label">Message</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="message" name="message"  value="<?php if(isset($_POST['message'])) echo htmlspecialchars($_POST['message']);?>">
					<?php echo "<p class='text-danger'>$errMsg</p>";?>
				</div>
			</div>
			
			<div class="form-group">
				<label for="toAcc" class="col-sm-2 control-label">From Account</label>
				<div class="col-sm-10">
					<select  class="form-control" name="toAcc">
						<option disabled selected>Account No. - Username - Full Name - Current Credit</option>
						<?php 
							//Query to display available accounts
							$get_from_sql = "SELECT acc_no,u_name,f_name,l_name, curr_credit FROM credit WHERE NOT acc_no = '".$_GET['ac_no']."'";
							$result = $conn->query($get_from_sql);
							if ($result->num_rows > 0)
							{
								while($row = $result->fetch_assoc())
								{
									echo '
									<option>'.$row['acc_no'].' - '.$row['u_name'].' - '.$row['f_name'].' '.$row['l_name'].' - '.$row['curr_credit'].' </option>
									';
								}
							}
						?>
					</select>
					<?php echo "<p class='text-danger'>$errFrom</p>";?>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<input id="submit" name="submit" type="submit" value="Submit" class="btn btn-primary">
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<!-- Will be used to display an alert to the user-->
					<?php if(isset($status)) echo $status; ?>
				</div>
			</div>
</form>


</div>
</body>
</html>
