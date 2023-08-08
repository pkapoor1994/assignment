<?php
	session_start();
	include "dbclass.php";
	include "savebox.php";

    $db=new dbclass();
	$formtitle="SALE";
	$formno="07";
	$mcuid=$_SESSION['uname'];
	$mqry="select * from userdet where uname='$mcuid' and  optn='$formno'";
	$res=$db->getResult($mqry) or die(mysqli_error($con));
	while($rws=mysqli_fetch_array($res))
	{
		$aflg=$rws["aflg"];
		$mflg=$rws["mflg"];
		$mdflg=$rws["dflg"];
	}
    echo "<input type='hidden' id='maflg' value='$aflg' />";
	echo "<input type='hidden' id='mflg' value='$mflg' />";
	echo "<input type='hidden' id='mdflg' value='$mdflg' />";
?>
<html>
<head>  		

<link rel="stylesheet" href="css/Masters.css">
<script src="sale.js?rev=<?php echo time();?>"
    type="text/javascript"></script>

<style>
	#mylog
	{
		display:none;
	}
	#itemlist
        {
            max-height:400px;
            overflow-y:scroll;
        }
        .ficon
        {
            color:rgb(2, 117, 216);
            font-size:18px;
            cursor:pointer;
            margin-top:7px;
            margin-bottom:7px;
        }
        .formtable{
            padding: 5px;
            vertical-align: top;
            font-weight:bold;
        }
        .formtable  td, th {
            padding: 5px;
            vertical-align: top;
        }

        .formtable1{
            padding: 1rem;
            vertical-align: top;
            font-weight:bold;
        }
        .formtable1  td, th {
            padding: 2px;;
            vertical-align: top;
        }


        .darkclosebtn {
            font-size: 20px;
            color: white;
            float: right;
            font-weight: 200;
            background-color: transparent;
            border: none;
            outline: none;
            padding-right: 10px;
        }
        #mainbg{
            width:100%;
            height:100%;
            position:absolute;
            display:none;
        }
        #viewlist{
			max-height:550px;
			overflow: auto;
			margin-top:0px;
		}
        .totbox{
            text-align:right;
            width:150px;
        }
        .partyheader
        {
            width:100%;
        }
        .partyheader .leftcol,.partyheader .rightcol{
            display:inline-block;
            width:100%;
            vertical-align:top;
        }
        .tablisthide{
            display:none;
        }
	
        @media screen and  ( max-width:600px)
        {
            .partyheader,.itemheader,.totalheader{
                padding:10px;
            }
            .formtable{
                padding: 10px;
                vertical-align: top;
                font-size: 14px;
                font-weight:bold;
            }
            .txtbox{
                padding: 5px;
                font-size: 14px;
            }
            .formtable  td, th 
            {
                /* padding: 5px; */
                vertical-align: top;
            }
            .totbox{
                text-align:right;
                width:70px;
                font-size: 14px;
            }
            .partyheader .leftcol,.partyheader .rightcol{
                display:inline-block;
                width:100%;
                vertical-align:top;
            }
        }
</style>
<script>
        $(document).ready(async function(){
            await getform();
            await shwmstlist();
            mdt=getdtnow();
            await shwfilter();
            await shwfilter1();
            await shwaddform();

            $("#fdate").val($("#Pfdate").val());
            $('#fdate1').val($("#Pfdate").val());
            $('#fdate2').val($("#Pfdate").val());

            $("#tdocdt").val(mdt);
            // $("#pcode").select2();
            $("#fpcode").select2();
            $("#fglc").select2();
            $("#fglc1").select2();
            $("#glc").select2();
            $("#pglc").select2();

        });


        function getpdf()
        {  
            if(chkglc())
            { 
                glc=$('#fglc2').val();
                var gln=$("#fglc2 option:selected").text();
                date1=$('#fdate2').val();
                date2=$('#tdate2').val();
                $("#pdflink").html("<center><i class='fas fa-sync fa-spin'></i>Loading...</center>");
                $.post('ledgerpdf.php',{mgln:gln,mglc:glc,mdate1:date1,mdate2:date2},function(data){
                var mydoc="Ledger.pdf";
                    $("#pdflink").html("<a href='"+mydoc+"' target='_blank' id='dwldpdf'>Download PDF</a>");
                });
            }
            else
            {
                
                $('#warn').html('Please Select Account!');
                window.setTimeout(function(){ $("#warn").html("");},2000);

            }
        }

</script>
<div id='mainbg'></div>
<div class='mastercont'>
	<div class='frmtitlebar'><?php echo $formtitle; ?>
        <a class='btn cornerclose' id='exitbtn' href="dashboard.php" data-toggle='tooltip'  title='Close' data-original-title='Close' ><i class="fas fa-times-circle" ></i></a>
    </div>
	<div clas='masterform'>
		<div class='masterent'>
			<center><div id='warn' class='warn'></div></center>
			<ul class="nav nav-tabs spacing" id="mytab" role="tablist">
				<li class="nav-item navmargin" id='tablisthide'>
					<a class="nav-link bold active" id="tab1" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" >
					Add</a>
				</li>
				<li class="nav-item navmargin">
					<a class="nav-link bold" id="tab2" data-toggle="tab" href="#view" role="tab" aria-controls="view" aria-selected="true" 
					onclick="shwmstlist();">
					View</a>
				</li>
                <li class="nav-item navmargin">
					<a class="nav-link bold" id="tab3" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true" 
					onclick="detaillist();">
					Detail</a>
				</li>
                <li class="nav-item navmargin">
					<a class="nav-link bold" id="tab3" data-toggle="tab" href="#ledger" role="tab" aria-controls="ledger" aria-selected="true" 
					>
					A/C Ledger</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="home" style='padding:3px;padding-left:5px;' role="tabpanel" aria-labelledby="home">
                    <div class='masterformdiv' id='masterformdiv'>
                 							
                    </div>
                </div>
				<div id='view' class='tab-pane' id='view' role="tabpanel" aria-labelledby="view">
                    <br/>
                    <a href="#" onclick='shwfilter()' data-toggle="tooltip" title="Filter"><span class="fa fa-filter"></span></a><br/><br/>
                    <div id="filter">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class='form-group'>
                                    <label>From Date: </label><br/>
                                    <input type='date' class='form-control' name='fdate' id='fdate'
                                        value=''>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class='form-group'>
                                    <label>To Date: </label><br/>
                                    <input type='date' class='form-control' name='tdate' id='tdate'
                                    value='<?php echo date('Y-m-d')?>'>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-sm-3 form-group'>
                                <label for="fglc">Party Name</label>
                                <select name='fglc' id='fglc' class='form-control' style='width:100%' >
                                    <?php
                                        $qry="select * from glmast order by gln";
                                        $result=$db->getResult($qry);
                                        echo "<option value=''>--Select Account--</option>";
                                        while($data=mysqli_fetch_array($result))
                                        {
                                            extract($data);
                                            $glc=trim($glc);
                                            $gln=trim($gln);
                                            echo "<option  value='$glc'>$gln</option>";
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col">
                                <input type='button' class='btn btn-primary totop' value='Filter' onclick='shwmstlist();'/>
                                <input type="button" class='btn btn-info totop' value='Clear Filter' onclick='clrfilter();' />
                            </div>
                        </div>

                        <div id="searchbox">
                            </br>
                            <input id="lookfor" type="text" class="form-control" onkeyup="shwmstlist();" placeholder='Search '/>
                        </div>
                        <br/>
                    </div>

                    <div id='lst' style=' max-height:650px;overflow:auto;'>
                    </div>
				</div>
                <div id='detail' class='tab-pane' id='detail' role="tabpanel" aria-labelledby="detail">
                    <br/>
                    <a href="#" onclick='shwfilter1()' data-toggle="tooltip" title="Filter"><span class="fa fa-filter"></span></a><br/>
                    <div id="filter1">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class='form-group'>
                                        <label>From Date: </label>
                                        <input type='date' class='form-control' name='fdate1' id='fdate1'
                                        value=''>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class='form-group'>
                                        <label>To Date: </label>
                                        <input type='date' class='form-control' name='tdate1' id='tdate1'
                                        value='<?php echo date('Y-m-d')?>'>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class='form-group'>
                                        <label for="fglc1">Party Name</label>
                                        <select name='fglc1' id='fglc1' class='form-control' style='width:100%' >
                                            <?php
                                                $qry="select * from glmast order by gln";
                                                $result=$db->getResult($qry);
                                                echo "<option value=''>--Select Account--</option>";
                                                while($data=mysqli_fetch_array($result))
                                                {
                                                    extract($data);
                                                    $glc=trim($glc);
                                                    $gln=trim($gln);
                                                    echo "<option  value='$glc'>$gln</option>";
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class='form-group'>
                                        <label for='fpcode'>Item</label>
                                        <select name='fpcode' id='fpcode' class='form-control txtbox' style='width:100%' >
                                                <?php
                                                    
                                                    $qry="select * from prod order by pname ";
                                                    $result=$db->getResult($qry);
                                                    echo "<option value=''>--Select Product Name--</option>";
                                                    while($data=mysqli_fetch_array($result))
                                                    {
                                                        extract($data);
                                                        $pcode=trim($pcode);
                                                        echo "<option value='$pcode'>$pname</option>";
                                                    }
                                                ?>
                                        </select>
                                        <input type="hidden" class="form-control txtbox" style="padding:4px;"  value="" id="pname" name="pname">
                                    </div>
                                </div>
                            </div>
                     
                        <div class='row'>
                            <div class="col">
                                <input type='button' class='btn btn-primary totop' value='Filter' onclick='detaillist();'/>
                                <input type="button" class='btn btn-info totop' value='Clear Filter' onclick='clrfilter1();' />
                            </div>
                        </div>

                        <div id="searchbox">
                            </br>
                            <input id="lookfordet" type="text" class="form-control" onkeyup="detaillist();" placeholder='Search '/>
                        </div>
                    </div>

                    <br/>
                    <div id='lstdet' style=' max-height:650px;overflow:auto;'>
                    </div>
				</div>
                <div id='ledger' class='tab-pane' id='ledger' role="tabpanel" aria-labelledby="ledger">
                    <br/>
                    <a href="#" onclick='shwfilter2()' data-toggle="tooltip" title="Filter"><span class="fa fa-filter"></span></a><br/>
                    <div id="filter2">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class='form-group'>
                                        <label>From Date: </label>
                                        <input type='date' class='form-control' name='fdate2' id='fdate2'
                                        value=''>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class='form-group'>
                                        <label>To Date: </label>
                                        <input type='date' class='form-control' name='tdate2' id='tdate2'
                                        value='<?php echo date('Y-m-d')?>'>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class='form-group'>
                                        <label for="fglc2">Party Name</label>
                                        <select name='fglc2' id='fglc2' class='form-control' style='width:100%' >
                                            <?php
                                                $qry="select * from glmast order by gln";
                                                $result=$db->getResult($qry);
                                                echo "<option value=''>--Select Account--</option>";
                                                while($data=mysqli_fetch_array($result))
                                                {
                                                    extract($data);
                                                    $glc=trim($glc);
                                                    $gln=trim($gln);
                                                    echo "<option  value='$glc'>$gln</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                     
                        <div class='row'>
                            <div class="col">
                                <input type='button' class='btn btn-primary totop' value='Filter' onclick='ledger();'/>
                                <input type="button" class='btn btn-info totop' value='Clear Filter' onclick='clrfilter2();' />
							<input type='button' id='xls' class='btn btn-warning totop' value='PDF' onclick='getpdf();'/>

                            </div>
                        </div>
                        <div id='pdflink'></div>
                        <div id="searchbox">
                            </br>
                            <input id="lookfordet" type="text" class="form-control" onkeyup="ledger();" placeholder='Search '/>
                        </div>
                    </div>
                    <br/>
                    <div id='ledgerdet' style=' max-height:650px;overflow:auto;'>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>

