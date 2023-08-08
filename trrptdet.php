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
	$mtype=$_POST['mtype'];
	$mdate1=$_POST['mdate1'];
	$mdate2=$_POST['mdate2'];

	$qry="select *  from sale where docdt>='$mdate1' and docdt<='$mdate2' and tc like '$mtype%' order by docdt ";
    $result=$db->getResult($qry);
	

	// $qry1="select * from stk_view where 1=1  $xdes ";
	// echo $qry1;
	// $result1=$db->getResult($qry1);
	$rw=mysqli_num_rows($result);
	echo "<table id='tblhead' class=' table head'>";
	echo "<thead>
			<tr>
				<th class='toleft'>#</th>
				<th class='toleft'>Date</th>
				<th>Seller</th>
				<th>Buyer</th>
				<th>Type</th>
				<th class='toright'>Quantity</th>
				<th class='toright'>Rate</th>
				<th class='toright'>Amount</th>
				<th class='toright'>GST</th>
				<th class='toright'>Total</th>
			</tr>
		  </thead>";
		  $msrno=1;$mgtax=0;$mtype='';
          $mqty=0;$mamount=0;$mgamount=0;$mmgtax=0;
	echo "<tbody class='table' >";
	while($mysql_row=mysqli_fetch_array($result))
	{
		extract ($mysql_row);
        $mgtax=$gstax1+$gstax2+$gstax3;
        if($tc=='P11')
        {
            $mtype='PURCHASE';
        }
        else
        {
            $mtype='SALE';
        }
		echo "
		<tr>
			<td class='toleft'>$msrno</td>
			<td class='toleft'>".tobritish($docdt)."</td>
			<td>$gln</td>
			<td>$pgln</td>
			<td>$mtype</td>
			<td align='right'>$qty</td>
			<td align='right'>$rate</td>
			<td align='right'>$gamount</td>
			<td align='right'>$mgtax</td>
			<td align='right'>$amount</td>
			</tr></a>";
            $mqty=$mqty+$qty;
            $mgamount=$mgamount+$gamount;
            $mamount=$mamount+$amount;
            $mmgtax=$mmgtax+$mgtax;


			$msrno++;

	}		
	echo "</tbody>";
	echo "<tfoot class='footer'><tr>";
		echo "<td class='toleft' colspan='5'>Total</td>";
		echo "<td class='toright'>$mqty</td>"	;
		echo "<td class='toright'></td>"	;
		echo "<td class='toright'>$mgamount</td>"	;
		echo "<td class='toright'>$mmgtax</td>";
		echo "<td class='toright'>$mamount</td>";
	echo "</tr></tfoot></table>";
	echo "</div>";
		
?>
