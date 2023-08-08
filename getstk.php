<?php
    include "dbclass.php";
    $db=new dbclass();
    $mdate1=$_POST['mdate1'];
    $mdate2=date('Y-m-d');
    $mpcode=$_POST['mpcode'];
    $mqty6=0;$mqty12=0;$mob=0;$mastk=0;$qty13=0;$qty15=0;$mqty6=0;$mqty12=0;
    $qry="select s.grp,s.pcode,s.pname,sum(yob) as yob,sum(qty1) as qty1,sum(qty2) as qty2,sum(qty3) as qty3,sum(qty4) as qty4,sum(qty5) as qty5
    from (select @mdatef:='$mdate1' ) mdatef ,(select @mdate1:='$mdate1' ) mdate1 ,(select @mdate2:='$mdate2') mdate2 , stk1_view s 
    where 1=1  and pcode='$mpcode'
    group by s.grp,s.pcode,s.pname order by s.pname";
    //echo $qry;
    $result=$db->getResult($qry);
    $rw=mysqli_num_rows($result);
    if($rw>0)
    {
        while($mysql_row=mysqli_fetch_array($result))
        {
            extract ($mysql_row);
            $mbal=$yob+$qty1+$qty4-$qty2-$qty3;
            echo $mbal;
        }
    }
    else
    {
        echo "-1";
    }

  
  

?>