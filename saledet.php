<?php
session_start();
include 'dbclass.php';
include 'convert.php';
$db=new dbclass();
$warn="";

$optn=$_POST['optn'];
$msgerr=array();
$msgarr['Error']=false;
$msgarr['ErrorMsg']='';

if($optn==1)
{
    $mtc=$_POST['mtc'];
    $mser=$_POST['mser'];
    $mdocno=$_POST['mdocno'];
    $mvchno=$_POST['mvchno'];
    $mdocdt=$_POST['mdocdt'];
    $mglc=$_POST['mglc'];
    $mgln=$_POST['mgln'];
    $msdes=$_POST['msdes'];
    $msttype=$_POST['msttype'];
    $array=$_POST['msalearr'];
    $mamount1=$_POST['mamount1'];
    $taxable=$_POST['tottaxable'];
    $mdis=$_POST['mdis'];
    $msgst=$_POST['msgst'];
    $mcgst=$_POST['mcgst'];
    $migst=$_POST['migst'];
    $mtcsamt=$_POST['mtcsamt'];
    $mbqty=$_POST['mbqty'];
    $mmisc=$_POST['mmisc'];
    $mbillamt=$_POST['mbillamt'];
    $mpglc=$_POST['mpglc'];
    $mpgln=$_POST['mpgln'];
    $mcuid=$_SESSION['uid'];
    if(empty($msgst))
    {
        $msgst=0.00;
    } 
    if(empty($mcgst))
    {
        $mcgst=0.00;
    } 
    if(empty($migst))
    {
        $migst=0.00;
    } 
    if(empty($mdis))
    {
        $mdis=0.00;
    } 
    if(empty($mmisc))
    {
        $mmisc=0.00;
    } 
    if(empty($mbillamt))
    {
        $mbillamt=0.00;
    }
    if(empty($mtcsamt))
    {
        $mtcsamt=0.00;
    }
    if(empty($mbqty))
    {
        $mbqty=0.00;
    }

        $xqry="select docno from bills where tc='$mtc' and ser='$mser' order by convert(docno,int) desc limit 1";
        $xpad=0;
        $mdocno=$db->genID($xqry,$xpad,'docno');
        if(!empty($mdocno))
        {
            try
            {
                $mysql_query="insert into bills(
                    tc,ser,docno,docdt,glc,
                    gln,sdes,sttype,
                    vchno,amount1,dis,misc,
                    sgst,cgst,igst,tcsamt,billamt,
                    uname,bqty,taxable,pglc,pgln) 
                values(
                    ?,?,?,?,?,
                    ?,?,?,?,
                    ?,?,?,?,?,
                    ?,?,?,?,?,
                    ?,?,?
                )";
                $arr=array(
                    $mtc,$mser,$mdocno,$mdocdt,$mglc,
                    $mgln,$msdes,$msttype,
                    $mvchno,$mamount1,$mdis,$mmisc,
                    $msgst,$mcgst,$migst,$mtcsamt,$mbillamt,
                    $mcuid,$mbqty,$taxable,$mpglc,$mpgln);

                $mysql_query_run=$db->RunQryparam($mysql_query,$arr);
                if($mysql_query_run)
                {
                
                    foreach($array as $prop=>$val)
                    {
                        // echo $prop;
                        foreach($val as $innerprp=>$innerval)
                        {
                            $mpcode=$val['pcode'];
                            $mpname=$val['pname'];
                            $mqty=$val['qty'];
                            $mrate=$val['rate'];
                            $mgamount=$val['gamount'];
                            $mgsttype=$val['gsttype'];
                            $mgstdes=$val['gstdes'];
                            $mgper1=$val['gper1'];
                            $mgper2=$val['gper2'];
                            $mgper3=$val['gper3'];
                            $mgstax1=$val['gstax1'];
                            $mgstax2=$val['gstax2'];
                            $mgstax3=$val['gstax3'];
                            $mless=$val['less'];
                            $mlessper=$val['lessper'];
                            $amount=$val['amount'];
                            // $taxable=$val['taxable'];
                            $msdes=$val['sdes'];
                            $msttype=$val['sttype'];
                            $munit=$val['unit'];
                            $unid=$val['unid'];
                            $brate=$val['brate'];

                        }
                        $qry="insert into sale
                        (tc,ser,docno,docdt,vchno,pcode,pname,qty,rate,less,lessper,gamount,gper1,gper2,gper3,gstax1,gstax2,gstax3,amount,sdes,sttype,glc,
                        gln,uname,gstdes,gsttype,unit,unid,brate,pglc,pgln)
                        values(
                            ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
                            ?,?,?,?,?,?,?,?,?
                        )";
                        $arr=array($mtc,$mser,$mdocno,$mdocdt,$mvchno,$mpcode,$mpname,$mqty,$mrate,$mless,$mlessper,$mgamount,$mgper1,$mgper2,$mgper3,
                        $mgstax1,$mgstax2,$mgstax3,$amount,$msdes,$msttype,$mglc,$mgln,$mcuid,$mgstdes,$mgsttype,$munit,$unid,$brate,$mpglc,$mpgln);

                        $run=$db->RunQryparam($qry,$arr);
                    }

                    $msgarr['ErrorMsg']='1';
                }
            }
            catch(Exception $ex)
            {
                $msgarr['Error']=true;
                $msgarr['ErrorMsg']=$ex->getMessage();
            }
        
            echo json_encode($msgarr);
        }
}

if($optn==2)
{
    $mtc=$_POST['mtc'];
    $mser=$_POST['mser'];
    $mdocno=$_POST['mdocno'];
    $mvchno=$_POST['mvchno'];
    $mdocdt=$_POST['mdocdt'];
    $mglc=$_POST['mglc'];
    $mgln=$_POST['mgln'];
    $msdes=$_POST['msdes'];
    $msttype=$_POST['msttype'];
    $array=$_POST['msalearr'];
    $mamount1=$_POST['mamount1'];
    $taxable=$_POST['tottaxable'];
    $mdis=$_POST['mdis'];
    $msgst=$_POST['msgst'];
    $mcgst=$_POST['mcgst'];
    $migst=$_POST['migst'];
    $mtcsamt=$_POST['mtcsamt'];
    $mbqty=$_POST['mbqty'];
    $mmisc=$_POST['mmisc'];
    $mbillamt=$_POST['mbillamt'];
    $mpglc=$_POST['mpglc'];
    $mpgln=$_POST['mpgln'];
    $mcuid=$_SESSION['uid'];

    try
    {
        $mysql_query="update bills set docdt=?,glc=?,gln=?,sdes=?,sttype=?,
        amount1=?,dis=?,misc=?,sgst=?,cgst=?,igst=?,tcsamt=?,billamt=?,bqty=?,taxable=?,pglc=?,pgln=?
        where tc=? and ser=? and docno=?";
            $arr=array($mdocdt,$mglc,$mgln,$msdes,$msttype,
            $mamount1,$mdis,$mmisc,$msgst,$mcgst,$migst,$mtcsamt,$mbillamt,$mbqty,$taxable,$mpglc,$mpgln,
            $mtc,$mser,$mdocno);

        $mysql_query_run=$db->RunQryparam($mysql_query,$arr);

        $qry="delete from sale where tc='$mtc' and ser='$mser' and docno='$mdocno'";
        $res=$db->getResult($qry);

        // foreach($array as $prop=>$val)
        // {
            foreach($array as $prop=>$val)
            {
                foreach($val as $innerprp=>$innerval)
                {
                    $mpcode=$val['pcode'];
                    $mpname=$val['pname'];
                    $mqty=$val['qty'];
                    $mrate=$val['rate'];
                    $mgamount=$val['gamount'];
                    $mgsttype=$val['gsttype'];
                    $mgstdes=$val['gstdes'];
                    $mgper1=$val['gper1'];
                    $mgper2=$val['gper2'];
                    $mgper3=$val['gper3'];
                    $mgstax1=$val['gstax1'];
                    $mgstax2=$val['gstax2'];
                    $mgstax3=$val['gstax3'];
                    $mless=$val['less'];
                    $mlessper=$val['lessper'];
                    $amount=$val['amount'];
                    // $taxable=$val['taxable'];
                    $msdes=$val['sdes'];
                    $msttype=$val['sttype'];
                    $munit=$val['unit'];
                    $unid=$val['unid'];
                    $brate=$val['brate'];
                }
                $qry="insert into sale
                (tc,ser,docno,docdt,vchno,pcode,pname,qty,rate,less,lessper,gamount,gper1,gper2,gper3,gstax1,gstax2,gstax3,amount,sdes,sttype,glc,
                gln,uname,gstdes,gsttype,unit,unid,brate,pglc,pgln)
                values(
                    ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
                ?,?,?,?,?,?,?,?,?
                )";
                $arr=array($mtc,$mser,$mdocno,$mdocdt,$mvchno,$mpcode,$mpname,$mqty,$mrate,$mless,$mlessper,$mgamount,$mgper1,$mgper2,$mgper3,
                $mgstax1,$mgstax2,$mgstax3,$amount,$msdes,$msttype,$mglc,$mgln,$mcuid,$mgstdes,$mgsttype,$munit,$unid,$brate,$mpglc,$mpgln);

                $run=$db->RunQryparam($qry,$arr);
            }
        
        // }

        $msgarr['ErrorMsg']='2';

    }
    catch(Exception $ex)
    {
        $msgarr['Error']=true;
        $msgarr['ErrorMsg']=$ex->getMessage();
    } 
    echo json_encode($msgarr);
    
}

if($optn==3)
{
    ?>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        function showitems(xid)
		{
			$("#itemlist"+xid).toggle();
		}

    </script>
    <style>
        .itemlist{
            display:none;
        }
        tfoot tr{
            background-color:#567ae3;
            color:white;
            font-weight:bold;
            position:sticky;
            top:0;
        }
        thead tr{
            background-color:#567ae3;
            color:white;
            font-weight:bold;
            position:sticky;
            bottom:0;
        }
        tbody tr{
            color:black;
            
        }
        .table-hover tbody .hightlight:hover{
            color:black;
            background:rgb(187 228 243 / 65%);
            cursor:pointer;
        }
        .table-hover tbody .itemlist:hover{
            background:none;
            cursor:pointer;
        }
        .itemtbl tr,.table-hover .itemtbl tbody tr:hover{
            color:black;
            background:white;
        }
        
    </style>
   
    <?php
    $mflg=$_POST['mmflg'];
    $mdflg=$_POST['mdflg'];
    $mdes=$_POST['mdes'];
    $date1=$_POST['date1'];
    $date2=$_POST['date2'];
    $fglc=$_POST['fglc'];

    $xdes='';
    if(!empty($date1))
    {
        $xdes=$xdes." and docdt>='$date1'";
    }
    if(!empty($date2))
    {
        $xdes=$xdes." and docdt<='$date2'";
    }

    $tamount=0.00;$tdis=0.00;$ttaxable=0.00;$tsgst=0.00;$tcgst=0.00;$tigst=0.00;$ttcs=0.00;$tbillamt=0.00;$tmisc=0.00;
    $qry="select * from bills where tc='S11' and 1=1 and rtrim(vehno)+rtrim(gln) like '%$mdes%'  and glc like '$fglc%' $xdes order by convert(docno,int),docdt";
    // echo $qry;
    if($result=$db->getResult($qry))
    {
        echo "<table class='table table-condensed table-hover tblmst' >";
        echo "<thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>S.no</th>
                    <th>Date</th>
                    <th>Party Name</th>
                    <th>Type</th>
                    <th>Dealer Type</th>
                    <th>Vehicle No</th>
                    <th class='toright'>Amount</th>
                    <th class='toright'>Discount</th>
                    <th class='toright'>Taxable</th>
                    <th class='toright'>SGST</th>
                    <th class='toright'>CGST</th>
                    <th class='toright'>IGST</th>
                    <th class='toright'>TCS Amount</th>
                    <th class='toright'>Round Off</th>
                    <th class='toright'>Bill Amount</th>
                </tr>
            </thead>";
            $msrno=1;
        while($mysql_row=mysqli_fetch_array($result))
        {
            extract ($mysql_row);
            $tamount=$tamount+$amount1;
            $tdis=$tdis+$dis;
            $ttaxable=$ttaxable+$taxable;
            $tsgst=$tsgst+$sgst;
            $tcgst=$tcgst+$cgst;
            $tigst=$tigst+$igst;
            $ttcs=$ttcs+$tcsamt;
            $tbillamt=$tbillamt+$billamt;
            $tmisc=$tmisc+$misc;

            echo "<a href='#'  >
            <tr class='hightlight'>
                <td style='width:10px;padding-left:5px;padding-right: 5px;'>";
                if($mflg)
                {
                    echo "<div class='fa fa-edit mstedit' onclick='shwupdt(this.id);' id='$tc:$ser:$docno' 
                    data-toggle='tooltip'  title='Edit' data-original-title='Edit' data-placement='top'></div>";
                }
                echo "</td>";
                if($mdflg)
                {
                    echo"<td style='width:10px;padding-left:5px;padding-right: 5px;'>";
                    echo "<div onclick='delrec(this.id)' class='fa fa-trash mstdel' id='$tc:$ser:$docno'   
                        data-toggle='tooltip'  title='Delete' data-original-title='Delete' data-placement='top'></div>";
                    echo "</td>";
                }
                echo"<td style='width:10px;padding-left:5px;padding-right: 5px;'>";
                    echo "<div onclick='showitems(this.id)' class='fa fa-tasks mstedit' id='$vchno'   
                        data-toggle='tooltip'  title='View' data-original-title='View' data-placement='top'></div>";
                    echo "</td>";
                echo "<td>$docno.</td>
                <td>".tobritish($docdt)."</td>
                <td>$gln</td>
                <td>$crtype</td>
                <td>$sdes</td>
                <td>$vehno</td>
                <td class='toright'>$amount1</td>
                <td class='toright'>$dis</td>
                <td class='toright'>$taxable</td>
                <td class='toright'>$sgst</td>
                <td class='toright'>$cgst</td>
                <td class='toright'>$igst</td>
                <td class='toright'>$tcsamt</td>
                <td class='toright'>$misc</td>
                <td class='toright'>$billamt</td>
             
                </tr></a>";
                $msrno++;
                echo "
                <tr id='itemlist$vchno' class='itemlist'>";
                $qry="select * from sale where vchno='$vchno' and tc='S11'";
                $res1=$db->getResult($qry);
                $rcount=mysqli_num_rows($res1);
                echo "<td colspan='19' style='padding:0'>
                        <table class='itemtbl' >
                        <tbody>";
                        if($rcount>0)
                        {
                            echo "
                            <tr>
                                <th width='50px'></th>
                                <th width='150px' >Product Name</th>
                                <th width='150px' class='toright'>Quantity</th>
                                <th width='150px' class='toright'>Rate</th>
                                <th width='150px' class='toright'>Amount</th>
                                <th width='150px' class='toright'>Discount</th>
                                <th width='150px' class='toright'>Taxable Amount</th>
                                <th width='150px' class='toright'>GST</th>
                                <th width='150px' class='toright'>Net Amount</th>
                            </tr>";

                            while($mysql_row1=mysqli_fetch_array($res1))
                            {
                                extract ($mysql_row1);
                                $taxable=$gamount-$less;
                                $mgper=$gper1+$gper2+$gper3;
                                echo "
                                <tr>
                                    <td></td>
                                    <td>$pname</td>
                                    <td width='150px' class='toright'>$qty</td>
                                    <td width='150px' class='toright'>$rate</td>
                                    <td width='150px' class='toright'>$amount</td>
                                    <td  width='150px' class='toright'>$less</td>
                                    <td class='toright'>$taxable</td>
                                    <td class='toright'>$mgper</td>
                                    <td class='toright'>$amount</td>
                                </tr>";
                            }
                        }
                        else
                        {
                            echo "<tr><td> No Item Found </td></tr>";
                        }
                        echo "</tbody>
                        
                        </table>
                </td>";

            echo "</tr>
            ";
        }		
        echo "
            <tfoot>
                <tr>
                <td colspan='9'>Total:
                <td class='toright'>".number_format($tamount,2)."</td>
                <td class='toright'>".number_format($tdis,2)."</td>
                <td class='toright'>".number_format($ttaxable,2)."</td>
                <td class='toright'>".number_format($tsgst,2)."</td>
                <td class='toright'>".number_format($tcgst,2)."</td>
                <td class='toright'>".number_format($tigst,2)."</td>
                <td class='toright'>".number_format($ttcs,2)."</td>
                <td class='toright'>".number_format($tmisc,2)."</td>
                <td class='toright'>".number_format($tbillamt,2)."</td>
                </tr>";

            echo "</tfoot>
            ";	
        echo "</table>";
    }
    else
    {
        echo "Failed!";
    }
}

if($optn==4)
{
    $mtc=$_POST['mtc'];
    $mser=$_POST['mser'];
    $mdocno=$_POST['mdocno'];

    $qry="delete from bills where tc='$mtc' and ser='$mser' and docno='$mdocno'";
    //echo $qry;
    $res=$db->getResult($qry);
    if($res)
    {
        $qry1="delete from sale where tc='$mtc' and ser='$mser' and docno='$mdocno'";
        $res1=$db->getResult($qry1);
        $qry1="delete from fatran where stc='$mtc' and sser='$mser' and sdocno='$mdocno'";
        $res1=$db->getResult($qry1);
        $qry1="delete from fatranp where stc='$mtc' and sser='$mser' and sdocno='$mdocno'";
        $res1=$db->getResult($qry1);
        if($res1)
        {
            echo $warn='1';
        }
    }
    else
    {
        echo $warn="Failed!";
    }
}

if($optn==5)
{

    ?>
    <style>
        .itemlist{
            display:none;
        }
        .itemlist table :hover
        {
            background-color:white;
            color:black;
        }
        .dettbl{
            max-height:300px;
            overflow-y:scroll;
        }
        #tblhead th{
            position: sticky;
            top: 0;
            background: lightgray;
            color: black;
        }
        #tblfoot td{
            position: sticky;
            bottom: 0;
            background: lightgray;
            color: black;
        }
        .tblmst1
        {
            width:1190px;
        }

        @media screen and (max-width:600px)
        {
            .tblmst1
            {
                font-size: 12px;
                margin-bottom: 0;
                width:600px;
            }
            .tblmst1 tr td , .tblmst1 tr th {
                padding:10px;
            }
        }
    </style>
    <?php

    $array=$_POST['array'];
    $mnetamt=0;$msrno=1;$mcnt=0;$totless=0.00;$tottaxable=0.00;
    echo "
        <table class='table table-condensed table-hover tblmst1'>";
            echo "<thead id='tblhead'>
                    <tr>
                        <th>S.no</th>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th class='toright'>Quantity</th>
                        <th class='toright'>Rate</th>
                        <th class='toright'>Amount</th>
                        <th class='toright'>Less %</th>
                        <th class='toright'>Less</th>
                        <th class='toright'>Taxable Amount</th>";
                        echo "<th></th>
                    </tr>
                </thead>
                <tbody>";
        foreach($array as $prop=>$val)
        {
            // echo $prop;
            foreach($val as $innerprp=>$innerval)
            {
                extract($val);
            }
            $mnetamt=$mnetamt+$gamount;
            $totless=$totless+$less;
            $tottaxable=$tottaxable+$taxable;
            $mcnt=$msrno;
            echo "
                <tr>
                    <td>".$msrno++."</td>
                    <td>$pname</td>
                    <td class=''>$unit</td>
                    <td class='toright'>$qty</td>
                    <td class='toright'>$brate</td>
                    <td class='toright'>$gamount</td>
                    <td class='toright'>$lessper</td>
                    <td class='toright'>$less</td>
                    <td class='toright'>$taxable</td>";
                    echo "<td style='width:10px;padding-left:5px;padding-right: 5px;'>";
                        echo "<div onclick='remove(this.id);' class='fa fa-trash mstdel' id='del$trackno' 
                        data-toggle='tooltip'  title='Delete' data-original-title='Delete' data-placement='top'></div>";
                    echo "</td>";
                echo "</tr>";
        }
        $mnetamt=number_format($mnetamt,2);
            echo "
            </tbody>
            <tfoot id='tblfoot'>
                <tr>
                    <td colspan='5'><label style='font-size:15px;font-weight:bold;'>Total #$mcnt</label>
                    <td class='toright'>";
                        echo $mnetamt ;
                    echo "<td>";

                    // <input type='text' class='form-control totbox toright' readonly value='$mnetamt' />
                    echo "<td class='toright'>$totless
                    <td class='toright'>$tottaxable";

                    echo "<td>
                </tr>    
            </tfoot>
        </table>";


}

if($optn==6)
{
    ?>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        function showitems(xid)
		{
            alert("#itemlist"+xid);
            arr=xid.split(":");
            xtc=arr[0];
            xser=arr[1];
            xdocno=arr[2];
			$("#itemlist"+xid).toggle();
		}

    </script>
    <style>
        .itemlist{
            display:none;
        }
        tfoot tr{
            background-color:#567ae3;
            color:white;
            font-weight:bold;
            position:sticky;
            top:0;
        }
        .table-hover thead tr{
            background-color:#567ae3;
            color:white;
            font-weight:bold;
            position:sticky;
            bottom:0;
        }
        tbody tr{
            color:black;
        }

    </style>
   
    <?php
    $mflg=$_POST['mmflg'];
    $mdflg=$_POST['mdflg'];
    $mdes=$_POST['mdes'];
    $date1=$_POST['date1'];
    $date2=$_POST['date2'];
    $fpcode=$_POST['fpcode'];
    $fglc=$_POST['fglc'];

    $xdes='';
    if(!empty($date1))
    {
        $xdes=$xdes." and docdt>='$date1'";
    }
    if(!empty($date2))
    {
        $xdes=$xdes." and docdt<='$date2'";
    }

    $tamount=0.00;$tdis=0.00;$ttaxable=0.00;$tsgst=0.00;$tcgst=0.00;$tigst=0.00;$ttcs=0.00;$tbillamt=0.00;$tmisc=0.00;
    $qry="select * from sale where tc='S11' and 1=1 and rtrim(vehno)+rtrim(gln) like '%$mdes%' and 
    pcode like '$fpcode%' and glc like '$fglc%' $xdes order by convert(docno,int),docdt";
    if($result=$db->getResult($qry))
    {
        echo "<table class='table table-condensed table-hover tblmst' >";
        echo "<thead>
                <tr>
                    <th>S.no</th>
                    <th>Date</th>
                    <th>Party Name</th>
                    <th>Product</th>
                    <th>Vehicle No</th>
                    <th class='toright'>Gross Amount</th>
                    <th class='toright'>Discount</th>
                    <th class='toright'>SGST</th>
                    <th class='toright'>CGST</th>
                    <th class='toright'>IGST</th>
                    <th class='toright'>Net Amount</th>
                </tr>
            </thead>";
            $msrno=1;
        while($mysql_row=mysqli_fetch_array($result))
        {
            extract ($mysql_row);
            $tamount=$tamount+$gamount;
            $tdis=$tdis+$less;
            $tsgst=$tsgst+$gper1;
            $tcgst=$tcgst+$gper2;
            $tigst=$tigst+$gper3;
            $tbillamt=$tbillamt+$amount;

            echo "<a href='#'  >
                <tr>
                    <td>$docno.</td>
                    <td>".tobritish($docdt)."</td>
                    <td>$gln</td>
                    <td>$pname</td>
                    <td>$vehno</td>
                    <td class='toright'>$gamount</td>
                    <td class='toright'>$less</td>
                    <td class='toright'>$gper1</td>
                    <td class='toright'>$gper2</td>
                    <td class='toright'>$gper3</td>
                    <td class='toright'>$amount</td>
                
                </tr></a>";
                $msrno++;
            echo "</tr>
            ";

        }		
        echo "
            <tfoot>
                <tr>
                    <td colspan='5'>Total:
                    <td class='toright'>".number_format($tamount,2)."</td>
                    <td class='toright'>".number_format($tdis,2)."</td>
                    <td class='toright'>".number_format($tsgst,2)."</td>
                    <td class='toright'>".number_format($tcgst,2)."</td>
                    <td class='toright'>".number_format($tigst,2)."</td>
                    <td class='toright'>".number_format($tbillamt,2)."</td>
                </tr>";

            echo "</tfoot>
            ";	
        echo "</table>";
    }
    else
    {
        echo "Failed!";
    }
}

?>