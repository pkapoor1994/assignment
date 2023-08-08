<?php
session_start();
include 'dbclass.php';
$db=new dbclass();
$gd=new GenDocno();
$warn="";

$optn=$_POST['optn'];
$msgerr=array();
$msgarr['Error']=false;
$msgarr['ErrorMsg']='';
if($optn=='1')
{
    $pcode=$_POST['pcode'];
    $pname=$_POST['pname'];
    $grp=$_POST['grp'];
    $unid=$_POST['unid'];
    $srate=$_POST['srate'];
    $gsttype=$_POST['gsttype'];
    $hsncode=$_POST['hsncode'];
    $glc1=$_POST['glc1'];
    $glc2=$_POST['glc2'];
    $myymm=$_SESSION['yymm'];
    $uname=$_SESSION['uname'];

    try
    {
        $mqry="select * from prod order by convert(pcode,int) desc limit 1";
        $pcode=$gd->genId($mqry,'4','pcode',$myymm);

        $mqry1="select * from prod where pname='$pname'";
        $res1=$db->getResult($mqry1);
        $rowcount=mysqli_num_rows($res1);
        if($rowcount==0)
        {
            $qry="insert into prod(pcode,pname,grp,unid,srate,gsttype,hsncode,glc1,glc2,uname)
            values(
                ?,?,?,?,?,
                ?,?,?,?,?
            )";
    
            $arr=array($pcode,$pname,$grp,$unid,$srate,$gsttype,$hsncode,$glc1,$glc2,$uname);
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
    $pcode=$_POST['pcode'];
    $pname=$_POST['pname'];
    $grp=$_POST['grp'];
    $unid=$_POST['unid'];
    $srate=$_POST['srate'];
    $gsttype=$_POST['gsttype'];
    $hsncode=$_POST['hsncode'];
    $glc1=$_POST['glc1'];
    $glc2=$_POST['glc2'];
    try
    {
        $qry="update prod set pname=?,grp=?,unid=?,srate=?,gsttype=?,hsncode=?,glc1=?,glc2=? where pcode=? ";
        $arr=array($pname,$grp,$unid,$srate,$gsttype,$hsncode,$glc1,$glc2,$pcode);
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

    $qry="select * from prod_view  where rtrim(pname)+rtrim(gdes) like '%$mdes%' order by pname";
    if($res=$db->getResult($qry))
    {
        echo "<table class='table table-hover'>";
		echo "<thead>
				<tr>
					<td width='100px'></td>
                    <td width='50px'>#</td>
					<td>Product Name</td>
					<td>Group Name</td>
					<td>Unit</td>
					<td>Sale Rate Rs</td>
					<td>GST Category</td>
					<td>HSN Code</td>
					<td>Debit A/C</td>
					<td>Credit A/C</td>
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
						echo "<i class='fa fa-edit mstedit' onclick='shwupdt(this.id);' id='$pcode'></i>";
					}
					if($mdflg)
					{
						echo "<i class='fa fa-trash mstdel' onclick='del(this.id);' id='$pcode'></i>";
					}
				echo "</td>";
				echo "<td width='50px'>$msrno</td>";
				echo "<td>$pname</td>";
				echo "<td>$gdes</td>";
				echo "<td>$unit</td>";
				// echo "<td>$nop</td>";
				echo "<td>$srate</td>";
				echo "<td>$gstdes</td>";
				echo "<td>$hsncode</td>";
				echo "<td>$gln1</td>";
				echo "<td>$gln2</td>";
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
    $pcode=$_POST['mrecno'];
    $qry="select * from allprod_view where pcode='$pcode'";
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
        $mqry="delete from prod where pcode='$pcode'";
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