<?php
session_start();
 
$q = $_GET['q'];
echo $q;
if(is_null($_SESSION['user_id'])){}
else if (strpos($q,'logout') !== false) {
	//session_unset();
	$today = date("Y-m-d H:i:s");                   // 2001-03-10 17:16:18 (the MySQL DATETIME format)
	file_put_contents("data/data.csv", $today.",", FILE_APPEND);	
	file_put_contents("data/data.csv", $today.",Logout\n", FILE_APPEND);		
}

else {
	$id=$_SESSION['user_id'].",";
	file_put_contents("data/data.csv", $id, FILE_APPEND);
	// 17:16:18
	$today = date("Y-m-d H:i:s");                   // 2001-03-10 17:16:18 (the MySQL DATETIME format)
	file_put_contents("data/data.csv", $today.",", FILE_APPEND);

	$ip = $q;
	$ip.="\n";
	file_put_contents("data/data.csv", $ip, FILE_APPEND);
}


/*$con = mysqli_connect('remote.cs.ubc.ca','enamul','iwillwin','my_db');
if (!$con)
  {
  die('Could not connect: ' . mysqli_error($con));
  }

mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM user WHERE id = '".$q."'";

$result = mysqli_query($con,$sql);

echo "<table border='1'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['FirstName'] . "</td>";
  echo "<td>" . $row['LastName'] . "</td>";
  echo "<td>" . $row['Age'] . "</td>";
  echo "<td>" . $row['Hometown'] . "</td>";
  echo "<td>" . $row['Job'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysqli_close($con);*/
?> 