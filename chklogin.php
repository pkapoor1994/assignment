<?php
session_start();
include "dbclass.php";
$db=new dbclass();
$alert="";
    $uname=$_POST['xname'];
    $upass=$_POST['xpass'];
    $tsql="select * from year";
    $result=$db->getResult($tsql);
    // $result=mysqli_query($con,$tsql) or die(mysqli_error($con));
    while($rw=mysqli_fetch_array($result))
    {
        extract($rw);
        $_SESSION["datef"]=$datef;
        $_SESSION["datet"]=$datet;
        $_SESSION["yymm"]=$yymm;
    }
    $tsql="select * from users where uname='$uname' and upass='$upass'";
    if($result=$db->getResult($tsql))
    {
        // Return the number of rows in result set

        $rowcount=mysqli_num_rows($result);
        if($rowcount>0)
        {
            while($rw=mysqli_fetch_array($result))
            {
                extract($rw);
                $_SESSION['aflg']=$aflg;
                $_SESSION['mflg']=$mflg;
                $_SESSION['dflg']=$dflg;
                $_SESSION["uid"]=$uname;
                $_SESSION["uname"]=$uname;
            }
            echo $alert=1;
            
        }
        else
        {
			echo $alert=2;
        }
		
    }
   
?>
