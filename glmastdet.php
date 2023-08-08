<?php
session_start();
include 'dbclass.php';
$db=new dbclass();
$gd=new GenDocno();
$warn="";
$myymm=$_SESSION['yymm'];
$optn=$_POST['optn'];
$msgerr=array();
$msgarr['Error']=false;
$msgarr['ErrorMsg']='';

if($optn=='1')
{
    $glc=$_POST['glc'];
    $gln=$_POST['gln'];
    $sch=$_POST['sch'];
    $yob=$_POST['yob'];
    $dbcr=$_POST['dbcr'];
    $add1=$_POST['add1'];
    $add2=$_POST['add2'];
    $add3=$_POST['add3'];
    $ctid=$_POST['ctid'];
    $pinno=$_POST['pinno'];
    $gstno=$_POST['gstno'];
    $panno=$_POST['panno'];
    $sttype=$_POST['sttype'];
    $sdes=$_POST['sdes'];
    $phone=$_POST['phone'];
    $bname=$_POST['bname'];
    $brname=$_POST['brname'];
    $ifsc=$_POST['ifsc'];
    $acno=$_POST['acno'];
    $actype=$_POST['actype'];
    $acname=$_POST['acname'];
    $rem=$_POST['rem'];
    $catgid=$_POST['catgid'];
    $uname=$_SESSION['uname'];
    try
    {
        $mqry="select glc from glmast order by convert(glc,int) desc limit 1";
        $glc=$gd->genId($mqry,'4','glc',$myymm);

        $qry="insert into glmast(glc,gln,sch,yob,dbcr,add1,add2,add3,ctid,pinno,gstno,panno,sttype,sdes,phone,bname,brname,ifsc,acno,actype,acname,rem,uname,catgid)
        values(
            ?,?,?,?,?,
            ?,?,?,?,?,
            ?,?,?,?,?,
            ?,?,?,?,?,
            ?,?,?,?)";

        $arr=array($glc,$gln,$sch,$yob,$dbcr,$add1,$add2,$add3,$ctid,$pinno,$gstno,$panno,$sttype,$sdes,$phone,$bname,$brname,$ifsc,$acno,$actype,$acname,$rem,$uname,$catgid);
        $res=$db->RunQryparam($qry,$arr);
        $msgarr['ErrorMsg']='1';

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
    $glc=$_POST['glc'];
    $gln=$_POST['gln'];
    $sch=$_POST['sch'];
    $yob=$_POST['yob'];
    $dbcr=$_POST['dbcr'];
    $add1=$_POST['add1'];
    $add2=$_POST['add2'];
    $add3=$_POST['add3'];
    $ctid=$_POST['ctid'];
    $pinno=$_POST['pinno'];
    $gstno=$_POST['gstno'];
    $panno=$_POST['panno'];
    $sttype=$_POST['sttype'];
    $sdes=$_POST['sdes'];
    $phone=$_POST['phone'];
    $bname=$_POST['bname'];
    $brname=$_POST['brname'];
    $ifsc=$_POST['ifsc'];
    $acno=$_POST['acno'];
    $actype=$_POST['actype'];
    $acname=$_POST['acname'];    
    $catgid=$_POST['catgid'];

    $rem=$_POST['rem'];
    try
    {
        $qry="update glmast set gln=?,sch=?,yob=?,dbcr=?,add1=?,add2=?,add3=?,ctid=?,pinno=?,gstno=?,panno=?,sttype=?,sdes=?,phone=?,bname=?,brname=?,catgid=?,
        ifsc=?,acno=?,actype=?,acname=?,rem=? where glc=? ";
        $arr=array($gln,$sch,$yob,$dbcr,$add1,$add2,$add3,$ctid,$pinno,$gstno,$panno,$sttype,$sdes,$phone,$bname,$brname,$catgid,$ifsc,$acno,$actype,$acname,$rem,$glc);
        $run=$db->RunQryparam($qry,$arr);

        $msgarr['ErrorMsg']='2';
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

    $qry="select * from glmast_view where (rtrim(gln) like '%$mdes%' or rtrim(catgdes) like '%$mdes%' or rtrim(schdes) like '%$mdes%') order by gln";
    if($res=$db->getResult($qry))
    {
        
        echo "<table class='table table-hover'>";
		echo "<thead>
				<tr>
					<td width='100px'></td>
                    <td width='50px'>#</td>
					<td>Account ID</td>
					<td>Account Name</td>
					<td>Schedule</td>
					<td class='toright'>Opening Balance</td>
					<td>City</td>
					<td>Pin NO</td>
					<td>GST No</td>
					<td>PAN No</td>
					<td>Tax Type</td>
					<td>Phone No</td>
					<td>Category</td>
				</tr>
			  </thead>";
			  $msrno=1;
		while($mysql_row=mysqli_fetch_array($res))
		{
			extract ($mysql_row);
            if($dbcr=='dr')
            {
                $dbcr='Dr';
            }
            if($dbcr=='cr')
            {
                $dbcr='Cr';

            }
			    echo "<a href='#'><tr>";
				echo "<td width='100px'>";
					if($mmflg && $dvflg!='Y')
					{
						echo "<i class='fa fa-edit mstedit' onclick='shwupdt(this.id);' id='$glc'></i>";
					}
					if($mdflg && $dvflg!='Y')
					{
						echo "<i class='fa fa-trash mstdel' onclick='del(this.id);' id='$glc'></i>";
					}
				echo "</td>";
				echo "<td width='50px'>$msrno</td>";
				echo "<td>$glc
				<td>$gln
				<input type='hidden' id='gln$glc' value='$gln'>
				</td>";
                echo "<td>$schdes</td>";
                echo "<td class='toright'>$yob $dbcr</td>";
                echo "<td>$city</td>";
                echo "<td>$pinno</td>";
                echo "<td>$gstno</td>";
                echo "<td>$panno</td>";
                echo "<td>$sdes</td>";
                echo "<td>$phone</td>";
                echo "<td>$catgdes</td>";
          
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
    $glc=$_POST['mrecno'];
    $qry="select * from allglmast_view where glc='$glc'";
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
        $mqry="delete from glmast where glc='$glc'";
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