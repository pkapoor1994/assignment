<?php
include 'dbclass.php';
$db=new dbclass();
$mqry=$_POST['mqry'];
$mtc=$_POST['mtc'];
$mser=$_POST['mser'];
$mpad='';

$vchno=$db->getDocno($mqry,$mpad);

$qry="insert into favouch (tc,ser,docno) values('$mtc','$mser','$vchno')";
$res=$db->getResult($qry); 

echo $vchno;
?>