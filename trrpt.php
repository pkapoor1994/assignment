<?php
	session_start();
	include "dbclass.php";
	$db=new dbclass();
	$formtitle="TRANSACTION REPORT";
	$formno="09";
	$mcuid=$_SESSION['uid'];
	
    $mfdate=$_SESSION['datef'];
	$mtdate=$_SESSION['datet'];
	echo "<input type='hidden' name='mfdate' id='mfdate' value=$mfdate>";
    echo "<input type='hidden' name='mtdate' id='mtdate' value=$mtdate>";

	$today=date('Y-m-d');
	echo "<input type='hidden' name='today' id='today' value=$today>";


?>
<html>
<head>
	<link rel="stylesheet" href="css/Masters.css">
	<link rel="stylesheet" href="css/tooltip.css">
	<style>

	#viewlist{
		max-height:450px;
		overflow: auto;
	}
		.forheight
		{
			min-height:600px;
	
		}
	
	@media (max-width: 768px) 
	{
		.container, .container-fluid {
		width: 100%;
		padding-right:0px;;
		padding-left: 0px;;

		}
	}

		.lbl{
        width:20px;
        height:15px;
       
		}

	</style>
    <script>
	var mname="";
	var mstname="Cashbook/Bankbook";
	$(document).ready(function(){
      $(function(){
        $('[data-toggle="tooltip"]').tooltip()
      });	
	  clrfilter();
   });


    function shwfilter()
	{
		$('#filtr').toggle();
		$('#viewlist').toggleClass('forheight');

		
	}

    function filter()
	{  
			$('#viewlist').html("<center><i class='fas fa-sync fa-spin'></i>&nbsp;&nbsp;<b>Loading...</b></center><br/><br/>");
			xdes=$('#lookfor').val();
			xdate1=$('#mdate1').val();
			xdate2=$('#mdate2').val();
			xtype=$('#mtype').val();
			
			$.post('trrptdet.php',{mtype:xtype,mdes:xdes,mdate1:xdate1,mdate2:xdate2},function(data){
				$('#viewlist').html(data);
			});
	}

	function clrfilter()
	{
		$("#glc").select2();
		$("#pcode").select2();
		$('#mdate1').val($('#mfdate').val());
		$('#mdate2').val($('#today').val());
		$('#mtype').val('');
		filter();
	}
	
  
    </script>
</head>
<body>

<?php

  
?>
<div class='mastercont'>
	<div class='frmtitlebar'>
		<?php echo $formtitle; ?>
		<a class='btn cornerclose' id='exitbtn' href="dashboard.php" data-toggle='tooltip'  title='Close' data-original-title='Close' ><i class="fas fa-times-circle" ></i></a>
	</div>	<div class='masterform'>
		<div class='masterent'>
				<center><div id='warn' class='warn'></div></center>
			</div>
			<!---- MASTER LIST DIV--->
             <div class='masterlist'>

             <a href="#" onclick='shwfilter()'  data-toggle="tooltip" title="Filter"><span class="fa fa-filter"></span></a>
				 <div id='filtr'>
					<div class='row'>
						<div class='col-sm-6'>
								<div class='row'>
									<div class='col'>
										<div class='form-group'>
											<span class='lbl'>From Date</span>
											<input type="date" class='form-control docdt' value="<?php echo $today; ?>" name='mdate1' id='mdate1' />
										</div>
									</div>
									<div class='col'>
										<div class='form-group'>
											<span class='lbl'>To Date</span>
											<input type="date" class='form-control docdt' value="<?php echo $today; ?>" name='mdate2' id='mdate2' />
										</div>
									</div>
								</div>
								<div class='row'>
									<div class='col'>
										<div class='form-group'>
											<label class='lbl'>Type:</label>
											<select name='mtype' id='mtype' class='form-control' >
											<option value=''>--Select Type--</option>
												<option value='P11'>Purchase Bill</option>
												<option value='S11'>Sale Bill</option>
                                            </select>
										</div>
									</div>



                                </div>

                                <!-- <div class='form-group'>
                                    <label for="lookfor" id='srchicon' class="glyphicon glyphicon-search" rel="tooltip" title="Search" ></label>
                                    <input id="lookfor" class="form-control" onkeyup="filter(this.value);" placeholder="Search"/>
                                </div> -->

                                <div class='row' style='margin-left:5px;'>
                                    <div class='col-xs-6'>
                                            <div class='form-group'>

												<input type='button' class='btn btn-primary totop' value='Filter' onclick='filter();'/>
                                                <input type="button" class='btn btn-info totop' value='Clear Filter' onclick='clrfilter();' />
                                            </div>
                                    </div>			
                                  
                                </div>  




                        </div>
                    </div> 
					<div id='viewlist'></div>     
                  
            </div>

        </div>

	</div>
<div>


</body>
</html>

