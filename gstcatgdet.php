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
    $gsttype=$_POST['gsttype'];
    $gstdes=$_POST['gstdes'];
    $gstype=$_POST['gstype'];
    $gper1=$_POST['gper1'];
    $gper2=$_POST['gper2'];
    $gper3=$_POST['gper3'];
    $rem=$_POST['rem'];
    $uname=$_SESSION['uname'];

    try
    {
        $mqry="select * from gstcatg order by convert(gsttype,int) desc limit 1";
        $gsttype=$db->genID($mqry,3,'gsttype');

        $mqry1="select * from gstcatg where gstdes='$gstdes'";
        $res1=$db->getResult($mqry1);
        $rowcount=mysqli_num_rows($res1);
        if($rowcount==0)
        {
            $qry="insert into gstcatg(gsttype,gstdes,gstype,gper1,gper2,gper3,rem,uname)
            values(?,?,?,?,?,?,?,?)";
    
            $arr=array($gsttype,$gstdes,$gstype,$gper1,$gper2,$gper3,$rem,$uname);
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
    
    $gsttype=$_POST['gsttype'];
    $gstdes=$_POST['gstdes'];
    $gstype=$_POST['gstype'];
    $gper1=$_POST['gper1'];
    $gper2=$_POST['gper2'];
    $gper3=$_POST['gper3'];
    $rem=$_POST['rem'];
    try
    {
        $mqry1="select * from gstcatg where gstdes='$gstdes' and gsttype!='$gsttype'";
        $res1=$db->getResult($mqry1);
        $rowcount=mysqli_num_rows($res1);
        if($rowcount==0)
        {
            $qry="update gstcatg set gstdes=?,gstype=?,gper1=?,gper2=?,gper3=?,rem=? where gsttype=? ";
            $arr=array($gstdes,$gstype,$gper1,$gper2,$gper3,$rem,$gsttype);
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

    $qry="select * from gstcatg where gstdes like '%$mdes%' order by gstdes";
    if($res=$db->getResult($qry))
    {
        
        echo "<table class='table table-hover'>";
		echo "<thead>
				<tr>
					<td width='100px'></td>
                    <td width='50px'>#</td>
					<td>GST Category</td>
					<td>Tax Type</td>
					<td>IGST</td>
					<td>CGST</td>
					<td>SGST</td>
					<td>Remarks</td>
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
						echo "<i class='fa fa-edit mstedit' onclick='shwupdt(this.id);' id='$gsttype'></i>";
					}
					if($mdflg)
					{
						echo "<i class='fa fa-trash mstdel' onclick='del(this.id);' id='$gsttype'></i>";
					}
				echo "</td>";
				echo "<td width='50px'>$msrno</td>";
				echo "<td>$gstdes
				    <input type='hidden' id='gstdes$gsttype' value='$gstdes'>
				</td>";
				echo "<td>$gstype</td>";
				echo "<td>$gper3</td>";
				echo "<td>$gper2</td>";
				echo "<td>$gper1</td>";
				echo "<td>$rem</td>";

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
    $gsttype=$_POST['mrecno'];
    $qry="select * from allgstcatg_view where gsttype='$gsttype'";
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
        $mqry="delete from gstcatg where gsttype='$gsttype'";
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