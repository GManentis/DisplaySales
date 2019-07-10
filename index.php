<?php
if(isset($_POST["submit"]))
{
	include_once "sales_class.php";

	$hostname_DB = "127.0.0.1";
	$database_DB = "agency";
	$username_DB = "root";
	$password_DB = "";
		
	try 
	{
	   $CONNPDO = new PDO("mysql:host=".$hostname_DB.";dbname=".$database_DB.";charset=UTF8", $username_DB, $password_DB, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3));
	} 
	catch (PDOException $e) 
	{
	   echo $e->getMessage()." Please check if SQL server is active or your connection credentials";
	   exit();
	}
	
	$variable = $_POST["days"];
	echo is_int($variable);
	$var = new sales_class($CONNPDO,$variable);
	$response1 = $var->getTransactions();
	$response2 = $var->calculateResults();
	
}
else
{
	$response1 = "";
	$response2 = "";
	
}



?>


<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
	<title>Sales calculation Simulator</title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
 <div class="form-group">
  <center>
  <h4>Select Results the day of your choice</h4>
	Day 1:<input type="radio"  name="days" value="1" checked>
 <br>
	Day 2:<input type="radio"  name="days" value="2">
	<br><br>
  <input type='submit' class="btn btn-success" name='submit' value='submit'>
  </center>
  </div>
</form>
<br><br>
<div class='container' style='text-align:center'>
<?php echo $response1; ?>
<br>
<?php echo $response2; ?>
<div>
</body>
</html>