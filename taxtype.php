<?php
    session_start();
    include "dbclass.php";
    $db=new dbclass();
    $statid=$_POST['statid'];
    $gstno=$_POST['gstno'];
    $cqry="select statid as cstatid from control";
    $result=$db->getResult($cqry);
    while($data=mysqli_fetch_array($result))
    {
        extract($data);
    }

    $xdes='';

    if($statid==$cstatid)
    {
        if(!empty($gstno))
        {
            $xdes=" and sttype='1G1'";
        }
        else
        {
            $xdes=" and sttype='1G2'";
        }
    }
    if($statid!=$cstatid)
    {
        if(!empty($gstno))
        {
            $xdes=" and sttype='2G1'";
        }
        else
        {
            $xdes=" and sttype='2G2'";
        }
    }
    if(empty($statid))
    {
        // $xdes=" and 1=2";
        $xdes=" and sttype='1G2'";
    }
    if($statid=='099')
    {
        $xdes=" and sttype='2G3')";
    }

    $qry="select * from taxmst where 1=1 $xdes order by sdes";
    $result=$db->getResult($qry);
    echo "<option value=''>--Select Tax Type--</option>";
    while($data=mysqli_fetch_array($result))
    {
        extract($data);
        $sttype=trim($sttype);
        $sdes=trim($sdes);
        echo "<option value='$sttype' selected>$sdes</option>";
    }
?>