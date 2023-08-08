<style>

#ledgerdet{
	width:100%;
    
}
#ledgerdet table{
	font-family:sans-serif;
	font-size:14px;
}
#ledgerdet h4{
	margin:0px;
	padding:2px;
	font-weight:bold;
}

#ledgerdet table{
	width:100%;
	table-layout:fixed;
	border:1px solid grey; 
    height:auto;
}

#ledgerdet table tr td {
    padding:0px;
    border: 1px solid #eee;
    width:100px;
    word-wrap: break-word;
}



#tblhead table tr td{
	padding:5px;
}

.footer table tr td{
	padding:5px;
}

.footer {
	background:lightgray;
}

.head tbody tr:hover{
	background-color:#eee;
    cursor:pointer;
}

.address{
	font-size:14px;
}
</style>
<?php
	include 'dbclass.php';
	include 'convert.php';
    $db=new dbclass();
	$mpcode=$_POST['mpcode'];
	$mdate1=$_POST['mdate1'];
	$mdate2=$_POST['mdate2'];
	$myob=0.00;
	$xdes='';

	// $qry="select s.* from (select @mdatef:='$mdate1' ) mdatef ,(select @mdate1:='$mdate1' ) mdate1 ,(select @mdate2:='$mdate2') mdate2 , stk1_view s ;";
    // $result=$db->getResult($qry);

	if(!empty($mpcode))
	{
		$xdes=$xdes." and pcode='$mpcode'";
	}

	$qry="select s.grp,s.pcode,s.pname,sum(yob) as yob,sum(qty1) as qty1,sum(qty2) as qty2,sum(qty3) as qty3,sum(qty4) as qty4,sum(qty5) as qty5
		 from (select @mdatef:='$mdate1' ) mdatef ,(select @mdate1:='$mdate1' ) mdate1 ,(select @mdate2:='$mdate2') mdate2 , stk1_view s 
         where 1=1  $xdes
         group by s.grp,s.pcode,s.pname order by s.pname ;";
    $result=$db->getResult($qry);
	

	// $qry1="select * from stk_view where 1=1  $xdes ";
	// echo $qry1;
	// $result1=$db->getResult($qry1);
	$rw=mysqli_num_rows($result);
	echo "<table id='tblhead' class=' table head'>";
	echo "<thead>
			<tr>
				<th class='toleft'>#</th>
				<th class='toleft'>Product Name</th>
				<th class='toright'>Opening</th>
				<th class='toright'>Purchase</th>
				<th class='toright'>Sale</th>
				<th class='toright'>Balance</th>
			</tr>
		  </thead>";
		  $msrno=1;
	$tyo=0;$q1=0;$q2=0;$q3=0;$q4=0;$tcl=0;
	$mbal=0;
	echo "<tbody class='table' >";
	while($mysql_row=mysqli_fetch_array($result))
	{
		extract ($mysql_row);
		$mbal=$yob+$qty1+$qty4-$qty2-$qty3;
		$tyo=$tyo+$yob;
		$q1=$q1+$qty1;
		$q2=$q2+$qty2;
		$q3=$q3+$qty3;
		$q4=$q4+$qty4;
		$tcl=$tcl+$mbal;
		
		//$mdebit=number_format((float)$mdebit, 2, '.', '');;
		echo "<a href='#'  >
		<tr>
			<td class='toleft'>$msrno</td>
			<td class='toleft'>$pname</td>
			<td align='right'>$yob</td>
			<td align='right'>$qty1</td>
			<td align='right'>$qty2</td>
			<td align='right'>$mbal</td>
			</tr></a>";
			$msrno++;

	}		
	echo "</tbody>";
	echo "<tfoot class='footer'><tr>";
		echo "<td class='toleft' colspan='2'>Total</td>";
		echo "<td class='toright'>$tyo</td>"	;
		echo "<td class='toright'>$q1</td>"	;
		echo "<td class='toright'>$q2</td>"	;
		echo "<td class='toright'>$mbal</td>";
	echo "</tr></tfoot></table>";
	echo "</div>";
		
?>
