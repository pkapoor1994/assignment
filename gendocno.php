<?php
include 'dbclass.php';
$db=new dbclass();
$mqry=$_POST['mqry'];
$mpad=$_POST['mpad'];
$mfield=$_POST['mfield'];

$mdocno=$db->genID($mqry,$mpad,$mfield);
echo $mdocno;
?>