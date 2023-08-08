<?php
    include 'dbclass.php';
    $db=new dbclass();
	$mtrakcno=$_POST['xrecno'];
    $mysql_query="delete from prod where  pcode='$mtrakcno'";
    $mysql_query_run=$db->getResult($mysql_query)or die(mysqli_error($con));
    echo "1";

	
?>