<?php
session_start();
include 'dbclass.php';
$db=new dbclass();
$warn="";

$optn=$_POST['optn'];
$msgerr=array();
$msgarr['Error']=false;
$msgarr['ErrorMsg']='';
if($optn=='1')
{
    $grp=$_POST['grp'];
    $gdes=$_POST['gdes'];
    $uname=$_SESSION['uname'];

    try
    {
        $mqry="select * from grpmst order by convert(grp,int) desc limit 1";
        $grp=$db->genID($mqry,3,'grp');

        $mqry1="select * from grpmst where gdes='$gdes'";
        $res1=$db->getResult($mqry1);
        $rowcount=mysqli_num_rows($res1);
        if($rowcount==0)
        {
            $qry="insert into grpmst(grp,gdes,uname)
            values(?,?,?)";
    
            $arr=array($grp,$gdes,$uname);
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
    
    $grp=$_POST['grp'];
    $gdes=$_POST['gdes'];
    try
    {
        $mqry1="select * from grpmst where gdes='$gdes' and grp!='$grp'";
        $res1=$db->getResult($mqry1);
        $rowcount=mysqli_num_rows($res1);
        if($rowcount==0)
        {
            $qry="update grpmst set gdes=? where grp=? ";
            $arr=array($gdes,$grp);
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

    $qry="select * from grpmst where gdes like '%$mdes%' order by gdes";
    if($res=$db->getResult($qry))
    {
        
        echo "<table class='table table-hover'>";
		echo "<thead>
				<tr>
					<td width='100px'></td>
                    <td width='50px'>#</td>
					<td>Group Name</td>
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
						echo "<i class='fa fa-edit mstedit' onclick='shwupdt(this.id);' id='$grp'></i>";
					}
					if($mdflg)
					{
						echo "<i class='fa fa-trash mstdel' onclick='del(this.id);' id='$grp'></i>";
					}
				echo "</td>";
				echo "<td width='50px'>$msrno</td>";
				echo "<td>$gdes
				<input type='hidden' id='gdes$grp' value='$gdes'>
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
    $grp=$_POST['mrecno'];
    $qry="select * from allgrp_view where grp='$grp'";
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
        $mqry="delete from grpmst where grp='$grp'";
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