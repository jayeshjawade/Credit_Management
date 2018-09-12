<!DOCTYPE html>
<html lang="en">

<?php 
require_once 'includes/head.php';
// Query
$sql = "SELECT acc_no,u_name,curr_credit FROM credit";

$result = $conn->query($sql);
?>
<body>
    <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Credit Management</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
      </ul>
    </div>
  </nav>
<div class="container">  
  <table class="table table-responsive table-hover table-bordered text-center">
    <thead>
      <tr>
        <th class="text-center">Acc No.</th>
        <th class="text-center">Username</th>       
        <th class="text-center">Current Credit</th>
      </tr>
    </thead>
    <tbody>      
      <?php 
      if ($result->num_rows > 0)
      {
      	while($row = $result->fetch_assoc())
      	{
      		echo '
      		<tr>
      			<td>'.$row['acc_no'].'</td>
            <td>'.$row['u_name'].'</td>
      			<td>'.$row['curr_credit'].'</td>
            <td>
            <a href="view.php?ac_no='.$row['acc_no'].'">View</a> / 
            <a href="transfer.php?ac_no='.$row['acc_no'].'">Transfer</a>
            </td>
      		</tr>
      		     ';
        }
      }
      else
      {
        echo '
        <tr>
      		<td colspan = "4"> 0 results </td>
      	</tr>
      		 ';	  	
      }
    $result->free();
	  $conn->close();
      ?>      
    </tbody>
  </table>
</div>
</body>
</html>


