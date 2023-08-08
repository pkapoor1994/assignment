<?php
	session_start();
	include "dbclass.php";
    $db=new dbclass();
	$formtitle="Product Master";
	$formno="01";
	$mcuid=$_SESSION['uname'];
	$mqry="select * from userdet where uname='$mcuid' and  optn='$formno'";
	$res=$db->getResult($mqry) or die(mysqli_error($con));
	while($rws=mysqli_fetch_array($res))
	{
		$aflg=$rws["aflg"];
		$mflg=$rws["mflg"];
		$dflg=$rws["dflg"];
	}
	echo "<input type='hidden' id='mflg' value='$mflg' />";
	echo "<input type='hidden' id='dflg' value='$dflg' />";
?>
<html>
<head>  		

<link rel="stylesheet" href="css/Masters.css">
<style>
	#mylog
	{
		display:none;
	}
</style>

<script>
	var mgst="";
	var worklog=[];
    $(document).ready(function(){
		getlist();
		fablank();

		$("#gsdives").focus();
		$("#sav").click(function(e){
			e.preventDefault();
			if(chkempty())
			{				
				$("#warn").removeClass("danger");
				var pname=$('#pname').val();

				var mydata = $("#gstform").serialize();
				$.ajax({
					type:"POST",
					url:"proddet.php",
					dataType:"text",
					data:mydata,
					success:function(response)
					{
						console.log(response);
						var resp=$.parseJSON(response);

							errsts=resp['Error'];
							errmsg=resp['ErrorMsg'];

							$("#warn").removeClass("warn");
							console.log(errmsg);
							if(errsts==false)
							{
								if(errmsg==1)
								{
									$("#warn").addClass("success");
									$("#warn").html("Saved!");
									fablank();
									window.setTimeout(function(){ $("#warn").html("");},2000);
								}
								else
								{
									if(errmsg==2)
									{
										$("#warn").addClass("success");
										$("#warn").html("Updated!");
										fablank();
										window.setTimeout(function(){ $("#warn").html("");},2000);
										$("#add").html("Add");
										$("#view").click();
									}
								}
							}
							else
							{
								swal.fire(errmsg,'','error')
							}

					},
					error:function(xhr, ajaxOptions, thrownError){
						alert("Error:"+thrownError);
					}
				});
			}
			else
			{
                $("#warn").removeClass('success');
                $("#warn").addClass('danger');
				$("#warn").html("Please Fill the values!");
			}
		});
    });

	function fablank()
	{
		$("#tab1").html("Add");
		$("#pcode").val("");
		$("#pname").val("");
		$("#grp").val("");
		$("#gper1").val("");
		$("#gper2").val("");
		$("#gper3").val("");
		$("#unid").val("");
		$("#nop").val("");
		$("#srate").val("");
		$("#gsttype").val("");
		$("#hsncode").val("");
		$("#glc1").val("");
		$("#glc2").val("");
		$("#optn").val("1");
		$("#pname").focus();
        $("#cancel").hide();
        genid();
	}

	function getcal()
	{
        var gper3=isNaN(parseFloat($("#gper3").val()))? 0:parseFloat($("#gper3").val());
		var half=gper3/2;
		$('#gper2').val(half.toFixed(2));
		$('#gper1').val(half.toFixed(2));
		$('#gper3').val(gper3.toFixed(2));
	}

	function chkempty()
    {
		var marr={"pname":'pname','grp':'grp',"unid":'unid',"gsttype":'gsttype'};
		noempty=true;
		for(var o in marr)
		{
			mmval=$("#"+o).val();
			if(empty(mmval))
			{
				xid=marr[o];
				$("#"+xid).addClass("errtxt");
				noempty=false;
			}
			else
			{
				xid=marr[o];
				$("#"+xid).removeClass("errtxt");
			}
		}
		return  noempty;
    }

	function getlist()
	{
		xoptn='3';
		xmflg = $("#mflg").val();
		xdflg = $("#dflg").val();
		xlookfor = $("#lookfor").val();
		$.post('proddet.php', {mdes:xlookfor,mmflg:xmflg,mdflg:xdflg,optn:xoptn}, function (data) {
			$("#lst").html(data);
		});
	}

	async function shwupdt(xrecno)
    {
		var arr=xrecno.split(':');
        var pcode=arr[0];
		$('#pcode').val(pcode);
        var xqry="select * from prod_view where pcode='"+pcode+"'";
        await $.post('getjsondet.php',{mrecno:xrecno,mqry:xqry},function(data)
        {
			if (data!=0)
			{ 
				var jsonData=$.parseJSON(data);
				for(var obj in jsonData)
				{	
					if(jsonData.hasOwnProperty(obj) )
					{
						for (var prop in jsonData[obj] )
						{
							if (jsonData[obj].hasOwnProperty(prop))
							{
								if(prop!='gln1' && prop!='gln2')
								{
									$("#"+prop).val(jsonData[obj][prop].trim());
								}
							}
						}
					}
				}
			}
			$("#tab1").html('Update');
			$("#tab1").click();
			$("#pname").focus();
			setTimeout(() => {
			    $("#pname").focus();
            }, 200);
			$('#optn').val('2');
			chkempty();
			$("#warn").html("");
            $("#cancel").show();

        });
    }
	
	function del(xid)
    {
        var yn=confirm('Confirm to Delete?')
        if(yn)
        {
			$("#warn").removeClass("success");
			$("#warn").addClass("warn");
            $.post('proddet.php',{mrecno:xid,optn:'4'},function(data){
				if(data==1)
                {
                    $("#warn").removeClass('success');
                    $("#warn").addClass('danger');
                    $('#warn').html('Deleted');
					window.setTimeout(function(){ $("#warn").html("");},2000);
					getlist();
                }
                else
                {
					swal.fire('Master Cannot be deleted',data,'error');
					window.setTimeout(function(){ $("#warn").html("");},2000);
                }
            });
        }
    }

    tab1.addEventListener("click", function () {
		moptn=$("#optn").val();
		if(moptn=="1")
		{
			setTimeout(() => {
				$("#pname").focus();
			}, 250);
		}
    });

	function cancelsave()
    {
		fablank();
    }

    function genid()
    {
        xqry='select pcode from prod order by convert(pcode,int) desc limit 1';
        xfield='pcode';
        $.post('genglc.php',{mqry:xqry,mfield:xfield},function(data){
            $("#pcode").val(data);
        });
    }

    function getval(xval,xfield1,xfield2,xgetval)
 	{
		//alert('hi');
		var str=xval.trim();
		xqry="";
		if(xfield1=='gsttype')
		{
			//alert(xval);
				xqry="select * from gstcatg where gsttype='"+str+"'";
				$.post('getjsondet.php',{mqry:xqry},function(data){
					if(data!=0)
					{
						var jsonData = $.parseJSON(data);
						for(var obj in jsonData)
						{
                            $("#gper1").val(jsonData[obj]["gper1"]);
							$("#gper2").val(jsonData[obj]["gper2"]);
                            $("#gper3").val(jsonData[obj]["gper3"]);
						}
					}

					else
					{
                        $("#gper1").val("");
                        $("#gper2").val("");
                        $("#gper3").val("");
					}

				});
				
		}

	}

</script>
<div class='mastercont'>
	<div class='frmtitlebar'>
		<?php echo $formtitle; ?>
		<a class='btn cornerclose' id='exitbtn' href="dashboard.php" data-toggle='tooltip'  title='Close' data-original-title='Close' ><i class="fas fa-times-circle" ></i></a>
	</div>	<div clas='masterform'>
		<div class='masterent'>
			<center><div id='warn' class='warn'></div></center>
			<ul class="nav nav-tabs spacing" id="mytab" role="tablist">
				<li class="nav-item navmargin">
					<a class="nav-link bold active" id="tab1" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" >
					Add</a>
				</li>
				<li class="nav-item navmargin">
					<a class="nav-link bold" id="tab2" data-toggle="tab" href="#view" role="tab" aria-controls="view" aria-selected="true" 
					    onclick="getlist();">
					View</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="home" style='padding:3px;padding-left:5px;' role="tabpanel" aria-labelledby="home">
					<form id="gstform">
						<input type="hidden" class="form-control" value="1" id="optn" name="optn" />
						<div class="row">
							<div class="col-sm-6">
                                <div class="row">
                                    <div class='col'>
                                        <div class='form-group'>
                                            <label for='pcode'>Product Id:</label><span id='iderror' class='idwarn'></span>
                                            <input type="text" class="form-control" style="width:130px;" value="" id="pcode" name="pcode"  readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>	
                                    <div class='col'>
                                        <div class="form-group">
                                            <label for='pname' class='starclass'>Product Name: </label>
                                            <input type="text" class="form-control" value="" id="pname" name="pname" onblur='toupper(this.id);' 
                                            tabindex='1' maxlength='30'
                                             autofocus  autocomplete="off" />
							            </div>
							        </div>
							    </div>
                                <div class='row'>
                                    <div class='col'>	
                                        <div class="form-group">
                                            <label for='statdes' class='starclass'>Group Name: </label>
                                            <select name='grp' id='grp' class='form-control' onchange="getval(this.value,'grp','');" tabindex="2"  >
                                                <?php
                                                $qry="select * from grpmst  order by grp";
                                                $result=$db->getResult($qry);
                                                echo "<option value=''>--Select Group--</option>";
                                                while($data=mysqli_fetch_array($result))
                                                {
                                                    extract($data);
                                                    $grp=trim($grp);
                                                    $gdes=trim($gdes);
                                                    echo "<option value='$grp'>$gdes</option>";
                                                }
                                                ?>	
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col'>	
                                        <div class="form-group">
                                            <label for='unid' class='starclass'>Unit: </label>
                                            <select name='unid' id='unid' class='form-control' onchange="getval(this.value,'unid','');" tabindex="3"  >
                                                <?php
                                                $qry="select * from unitmst  order by unid";
                                                $result=$db->getResult($qry);
                                                echo "<option value=''>--Select Unit--</option>";
                                                while($data=mysqli_fetch_array($result))
                                                {
                                                    extract($data);
                                                    $unid=trim($unid);
                                                    $unit=trim($unit);
                                                    echo "<option  value='$unid'>$unit</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                        <!-- <div class="form-group">
                                            <label for='nop'>No of Items: </label>
                                            <input type="text" class="form-control" value="" id="nop" name="nop" onblur='toupper(this.id);' tabindex='3' maxlength='30'
                                            autofocus  autocomplete="off" />
                                        </div> -->
                               
                                    <div class='col-sm-6'>
                                        <div class="form-group">
                                            <label for='srate'>Sale Rate Rs: </label>
                                            <input type="text" class="form-control toright" value="" id="srate" name="srate" onblur='toupper(this.id);' oninput='isnum(this.id);'
                                            tabindex='4' maxlength='8'
                                             autofocus  autocomplete="off" />
							            </div>
							        </div>
                                    <div class='col'>
                                    </div>

							    </div>
                                <div class='row'>
                                    <div class='col-sm-6'>
                                        <div class="form-group">
                                            <label for='gsttype' class='starclass'>GST Category: </label>
                                            <select name='gsttype' id='gsttype' class='form-control' onchange="getval(this.value,'gsttype','');" tabindex="5"  >
                                                <?php
                                                $qry="select * from gstcatg  order by gstdes";
                                                $result=$db->getResult($qry);
                                                echo "<option value=''>--Select GST Category--</option>";
                                                while($data=mysqli_fetch_array($result))
                                                {
                                                    extract($data);
                                                    $gsttype=trim($gsttype);
                                                    $gstdes=trim($gstdes);
                                                    echo "<option  value='$gsttype'>$gstdes</option>";
                                                }
                                                ?>
                                            </select>
							            </div>
							        </div>
                                    <div class='col'>
                                        <div class="form-group">
                                            <label for='hsncode' class='starclass'>HSN Code: </label>
                                            <input type='text' name='hsncode' id='hsncode' class='form-control' tabindex="6" >
                                        </div>
                                    </div>
							    </div>
                                <div class='row'>	
                                    <div class='col-sm-6'>
                                        <div class='row'>	
                                            <div class='col'>
                                                <div class="form-group">
                                                    <label for='gper'>IGST:</label>
                                                    <input type="text" class="form-control size text-right" style="width:90px;" value="0" id="gper3" name="gper3" placeholder='0.00' 
                                                    oninput='isnum(this.id);' onblur='getcal();' maxlength='6' autocomplete="off" readonly />
                                                </div>	
                                            </div>	
                                            <div class='col'>	
                                                <div class="form-group">
                                                    <label for='gper'>CGST:</label>
                                                    <input type="text" class="form-control size text-right" style="width:90px;" value="0" id="gper2" 
                                                    name="gper2" placeholder='0.00' 
                                                    oninput='isnum(this.id);' maxlength='6'  readonly autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class='col'>	
                                                <div class="form-group">
                                                    <label for='gper' >SGST:</label>
                                                    <input type="text" class="form-control size text-right" style="width:90px;" value="0" id="gper1" name="gper1" placeholder='0.00' 
                                                    oninput='isnum(this.id);' maxlength='6'  readonly autocomplete="off"/>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class='row'>
                                    <div class='col'>
                                        <div class="form-group">
                                            <label for='glc1'>Debit A/C: </label>
                                            <select name='glc1' id='glc1' class='form-control' onchange="getval(this.value,'glc1','');" tabindex="7"  >
                                            <?php
                                                $qry="select * from glmast  order by gln";
                                                $result=$db->getResult($qry);
                                                echo "<option value=''>--Select Debit A/C--</option>";
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
                                    <div class='col'>
                                        <div class="form-group">
                                            <label for='glc2'>Credit A/C: </label>
                                            <select name='glc2' id='glc2' class='form-control' onchange="getval(this.value,'glc2','');" tabindex="8"  >
                                                <?php
                                                $qry="select * from glmast  order by gln";
                                                $result=$db->getResult($qry);
                                                echo "<option value=''>--Select Credit A/C--</option>";
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
                            </div>
                            
						</div>

						<?php
							if($aflg)
							{
								echo "<input type='button' class='btn btn-success' value='Save' id='sav'  tabindex='11'/>";
							}
						?>
                        <input type='button' class='btn btn-warning' value='Cancel' id='cancel' onclick='cancelsave()' tabindex='12'/>
						<?php //include "exitbtn.php"; ?>
					</form>
				</div>

				<div id='view' class='tab-pane fade'>
					<div id="searchbox">
						<br>
						<input id="lookfor" type="text" class="form-control" onkeyup="getlist();"/>
					</div>
					<div id='lst' style=' max-height:550px;overflow:auto;'>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

