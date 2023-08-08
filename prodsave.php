<?php
include 'dbclass.php';
$db=new dbclass();
date_default_timezone_set("Asia/Kolkata");
$optn=$_POST['optn'];
$pcode=$_POST['pcode'];
$pname=$_POST['pname'];
$unit=$_POST['unit'];
$pkts=$_POST['pkts'];
$rate1=$_POST['rate1'];
$rate2=$_POST['rate2'];
$rate3=$_POST['rate3'];
$myymm=$_SESSION['yymm'];
if($optn=='1')
{
    $xqry="select pcode from prod order by convert(pcode,int) desc limit 1";
    $xpad="4";
    $xfield='pcode';
    $gd=new GenDocno();;
    $mpcode=$gd->genId($xqry,$xpad,$xfield,$myymm);
    if(!empty($mpcode))
    {
        $mysql_query="insert into prod(pcode,pname,unit,pkts,rate1,rate2,rate3) values(?,?,?,?,?,?,?)";
        $arr=array($mpcode,$pname,$unit,$pkts,$rate1,$rate2,$rate3);

        $mysql_query_run=$db->RunQryparam($mysql_query,$arr);
        if($mysql_query_run)
        {
            echo $warn="1";
        }
        else
        {
            $warn="Failed!";
        }
    }

}
else
{
    $mysql_query="update prod set pname=?,unit=?,pkts=?,rate1=?,rate2=?,rate3=? where pcode=?";
    $arr1=array($pname,$unit,$pkts,$rate1,$rate2,$rate3,$pcode);
    $run2=$db->RunQryparam($mysql_query,$arr1);
    if($run2)
    {
        echo $warn="2";
    }
    else
    {
        $warn="Failed!";
    }	
}




?>