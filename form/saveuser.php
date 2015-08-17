<?php
session_unset();
session_start();
// store session data
$_SESSION['user_id']=$_POST['user_id'];

echo "hello";

$fp = fopen('file.csv', 'a');
echo $_POST['user_id'];
fputcsv($fp, array($_POST['user_id'], $_POST['name'],$_POST['Gender'],$_POST['Age'],$_POST['Occupation'],$_POST['Field']));
fclose($fp);
    
header('Location:choose_interface.php');	

?>

