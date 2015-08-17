<?php

session_start();
$_SESSION['interface']=$_POST['interface_option'];
echo $_SESSION['interface'];
header('Location:../list.php');	

?>