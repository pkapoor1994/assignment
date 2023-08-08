<?php
include "dbclass.php";

$mmqry=$_POST['mqry'];
$db=new dbclass();
$res=$db->getResult($mmqry);
$rcnt=mysqli_num_rows($res);
if($rcnt>0)
{
    $outp = array();
    $outp = $res->fetch_all(MYSQLI_ASSOC);
    echo json_encode($outp);
}
else
{
    echo $rcnt;
}
?>