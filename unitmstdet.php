<?php
session_start();
include 'dbclass.php';
$db=new dbclass();
$warn="";

$uname=$_SESSION['uname'];
$optn=$_POST['optn'];
$msgerr=array();
$msgarr['Error']=false;
$msgarr['ErrorMsg']='';
if($optn=='1')
{
    $unid=$_POST['unid'];
    $unit=$_POST['unit'];
    try
    {
        $mqry="select * from unitmst order by convert(unid,int) desc limit 1";
        $unid=$db->genID($mqry,3,'unid');

        $mqry1="select * from unitmst where unit='$unit'";
        $res1=$db->getResult($mqry1);
        $rowcount=mysqli_num_rows($res1);
        if($rowcount==0)
        {
            $qry="insert into unitmst(unid,unit,uname)
            values(?,?,?)";
    
            $arr=array($unid,$unit,$uname);
            $res=$db->RunQryparam($qry,$arr);
            $msgarr['ErrorMsg']='1';
        }
        else
        {
            $msgarr['ErrorMsg']='3';
        }

    }
    catch(Exception $ex)
    {
        $msgarr['Error']=true;
        $msgarr['ErrorMsg']=$ex->getMessage();
    }
    echo json_encode($msgarr);
}
if($optn=='2')
{
    
    $unid=$_POST['unid'];
    $unit=$_POST['unit'];
    try
    {
        $mqry1="select * from unitmst where unit='$unit' and unid!='$unid'";
        $res1=$db->getResult($mqry1);
        $rowcount=mysqli_num_rows($res1);
        if($rowcount==0)
        {
            $qry="update unitmst set unit=? where unid=? ";
            $arr=array($unit,$unid);
            $run=$db->RunQryparam($qry,$arr);
    
            $msgarr['ErrorMsg']='2';
        }
        else
        {
            $msgarr['ErrorMsg']='3';
        }

    }
    catch(Exception $ex)
    {
        $msgarr['Error']=true;
        $msgarr['ErrorMsg']=$ex->getMessage();
    } 
    echo json_encode($msgarr);

}
if($optn=='3')
{
    $mmflg=$_POST['mmflg'];
    $mdflg=$_POST['mdflg'];
    $mdes=$_POST['mdes'];

    $qry="select * from unitmst where unit like '%$mdes%' order by unit";
    if($res=$db->getResult($qry))
    {
        
        echo "<table class='table table-hover'>";
		echo "<thead>
				<tr>
					<td width='100px'></td>
                    <td width='50px'>#</td>
					<td>Unit Name</td>
				</tr>
			  </thead>";
			  $msrno=1;
		while($mysql_row=mysqli_fetch_array($res))
		{
			extract ($mysql_row);
			echo "<a href='#'><tr>";
				echo "<td width='100px'>";
					if($mmflg)
					{
						echo "<i class='fa fa-edit mstedit' onclick='shwupdt(this.id);' id='$unid'></i>";
					}
					if($mdflg)
					{
						echo "<i class='fa fa-trash mstdel' onclick='del(this.id);' id='$unid'></i>";
					}
				echo "</td>";
				echo "<td width='50px'>$msrno</td>";
				echo "<td>$unit
				<input type='hidden' id='unit$unid' value='$unit'>
				</td>";
			echo "</tr><a>";
			$msrno++;
		}			
		echo "</table>";
    }
    else
    {
        echo "Failed";
    }
}
if($optn=='4')
{
    $unid=$_POST['mrecno'];
    $qry="select * from allunit_view where unid='$unid'";
	$res=$db->getResult($qry);
	$res1=$db->getResult($qry);
	$rowcount=mysqli_num_rows($res1);
	if($rowcount>0)
	{
		$det='';
		while($rw1=mysqli_fetch_array($res1))
		{
			extract($rw1);
			$det=$det.' , '.$entname;
		}
		$len=strlen($det);
		$det=substr($det,3,$len);
		echo "It is Used in ".$det;
	}
	else
	{
        $mqry="delete from unitmst where unid='$unid'";
        $run=$db->getResult($mqry);
        
        if($run)
        {
            echo $warn='1';
        }
        else
        {
            echo 'Failed';
        }
    }
}
?>