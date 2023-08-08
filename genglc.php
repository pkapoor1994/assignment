<?php
include 'dbclass.php';
$db=new GenDocno();
$mqry=$_POST['mqry'];
$mpad='4';
$xfield=$_POST['mfield'];
$myymm=$_SESSION['yymm'];
$mglc=$db->genId($mqry,$mpad,$xfield,$myymm);
echo $mglc;

?>