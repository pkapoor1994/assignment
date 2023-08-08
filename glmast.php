<?php
	session_start();
	include "dbclass.php";
    $db=new dbclass();
	$formtitle="Account Master";
	$formno="05";
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
    .hidedet{
        display:none;
    }
    .showdet{
        display: block;
    }
    #bnkhead{
        color:#242424;
        text-decoration:underline;
        font-weight:bold;
        cursor:pointer;
    }
    .yob{
        display: inline-block;
    }
	.cmbwdth{
		width:100%;
	}
</style>

<script>
	var mstate="";
	var worklog=[];
    $(document).ready(function()
	{
		getlist();
		fablank();

		$("#gln").focus();
		$("#sav").click(function(e){
			e.preventDefault();
			if(chkempty())
			{		
				sch=$("#sch").val();
				if(sch.includes('L0203') || sch.includes('A0106'))
				{
					if(mandatory())
					{
						save();
					}
				}
				else
				{
					$("#ctid").removeClass('errtxt');
					$("#phone").removeClass('errtxt');
					$("#sttype").removeClass('errtxt');
					save();
				}
			}
			else
			{
				$("#warn").removeClass('success');
                $("#warn").addClass('danger');
				$("#warn").html("Please Fill the values!");
			}
		});
    });

	function save()
	{
		$("#warn").removeClass("errtxt");
		var glc=$('#glc').val();
		$('#sttype').attr('disabled',false);
		$('#catgid').attr('disabled',false);
		var mydata = $("#glnform").serialize();
		$.ajax({
			type:"POST",
			url:"glmastdet.php",
			dataType:"text",
			data:mydata,
			success:function(response)
			{
				console.log(response);
				var resp=$.parseJSON(response);

					errsts=resp['Error'];
					errmsg=resp['ErrorMsg'];

					$("#warn").removeClass("warn");
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

    function genid()
    {
        xqry='select glc from glmast order by convert(glc,int) desc limit 1';
        xfield='glc';
        $.post('genglc.php',{mqry:xqry,mfield:xfield},function(data){
            $("#glc").val(data);
        });
    }

	function fablank()
	{
		$("#ctid").select2();
		$("#sch").select2();
		$("#catgid").select2();

		$("#tab1").html("Add");
		$("#glc").val("");
		$("#gln").val("");
		$("#sch").val("").trigger('change');
		$("#yob").val("");
		$("#dr").attr("checked",true);
		$("#add1").val("");
		$("#add2").val("");
		$("#add3").val("");
		$("#ctid").val("").trigger('change');
		$("#catgid").val("").trigger('change');
		$("#statdes").val("");
		$("#pinno").val("");
		$("#gstno").val("");
		$("#panno").val("");
		$("#sttype").val("");
		$("#sdes").val("");
		$("#phone").val("");
		$("#bname").val("");
		$("#brname").val("");
		$("#ifsc").val("");
		$("#acno").val("");
		$("#actype").val("");
		$("#acname").val("");
		$("#rem").val("");

		$("#sttype").attr("disabled",false);
		$("#catgid").attr("disabled",false);
		$("#optn").val("1");
		$("#cancel").hide();
		$("#gln").focus();
        genid();
		taxtype();
	}

	function chkempty()
    {
		var marr={"gln":'gln',"sch":'sch',"catgid":'catgid'};
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

	function mandatory()
    {
		var marr={'ctid':'ctid','phone':'phone','sttype':"sttype"};
		noempty=true;
		// for(var o in marr)
		// {
		// 	mmval=$("#"+o).val();
		// 	if(empty(mmval))
		// 	{
		// 		xid=marr[o];
		// 		$("#"+xid).addClass("errtxt");
		// 		noempty=false;
		// 	}
		// 	else
		// 	{
		// 		xid=marr[o];
		// 		$("#"+xid).removeClass("errtxt");
		// 	}
		// }
		return  noempty;
    }

	function getlist()
	{
		xoptn='3';
		xmflg = $("#mflg").val();
		xdflg = $("#dflg").val();
		xlookfor = $("#lookfor").val();
		$.post('glmastdet.php', {mdes:xlookfor,mmflg:xmflg,mdflg:xdflg,optn:xoptn}, function (data) {
			$("#lst").html(data);
		});
	}

	async function shwupdt(xrecno)
    {
		var arr=xrecno.split(':');
        var glc=arr[0];
		$('#glc').val(glc);
        var xqry="select * from glmast_view where glc='"+glc+"'";
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
								if(prop!='dbcr' && prop!='ctid' && prop!='sch' && prop!='catgid')
								{
									$("#"+prop).val(jsonData[obj][prop].trim());
								}
								if(prop=='dbcr') {
									dbcr = jsonData[obj][prop].trim();
									if (dbcr == 'Dr.') {
										$('#dr').prop('checked', true);
									}
									if (dbcr == 'Cr.') {
										$('#cr').prop('checked', true);
									}
								}
								if(prop=='ctid' || prop=='sch' || prop=='catgid') 
								{
									$("#"+prop).val(jsonData[obj][prop].trim()).trigger('change');
								}
							}
						}
					}
				}
			}
			$("#tab1").click();
			$("#tab1").html("Update");
			taxtype();
			
			setTimeout(() => {
				$("#gln").focus();
			}, 200);
            $("#cancel").show();

			$('#optn').val('2');
			chkempty();
			fieldchk();
			$("#warn").html("");
        });
    }

	tab1.addEventListener("click", function () {
		moptn=$("#optn").val();
		if(moptn=="1")
		{
			setTimeout(() => {
			$("#gln").focus();
		}, 150);
		}
    });

	function cancelsave()
    {
		fablank();
    }

	function del(xid)
    {
        var yn=confirm('Confirm to Delete?')
        if(yn)
        {
			$("#warn").removeClass("success");
			$("#warn").addClass("warn");
            $.post('glmastdet.php',{mrecno:xid,optn:'4'},function(data){
				if(data==1)
                {
                    $('#warn').html('Deleted');
					window.setTimeout(function(){ $("#warn").html("");},2000);
					getlist();
					fablank();
                }
                else
                {
					swal.fire('Master Cannot be deleted',data,'error');
					window.setTimeout(function(){ $("#warn").html("");},2000);
                }
            });
        }
    }

    function toggledet()
    {
        $("#bnkdet").toggleClass('hidedet');
        $("#bnkdet").toggleClass('showdet');
    }

	function getval(xval,xfield1,xfield2,xgetval)
 	{
		//alert('hi');
		var str=xval.trim();
		xqry="";
		if(xfield1=='ctid')
		{
			//alert(xval);
				xqry="select a.*,b.statdes from city a left join states b on a.statid=b.statid where ctid='"+str+"'";
				$.post('getjsondet.php',{mqry:xqry},function(data){
					if(data!=0)
					{
						//alert(data);
						var jsonData = $.parseJSON(data);
						for(var obj in jsonData)
						{
							$("#ctid").val(jsonData[obj]["ctid"]);
							$("#statid").val(jsonData[obj]["statid"]);
							$("#statdes").val(jsonData[obj]["statdes"]);
							taxtype();
						}
					}

					else
					{
						$("#ctid").val("");
						$("#statid").val("");
						$("#statdes").val("");
						taxtype();
					}
				});
				
		}
        if(xfield1=='sttype')
		{
			//alert(xval);
				xqry="select * from taxmst where sttype='"+str+"'";
				$.post('getjsondet.php',{mqry:xqry},function(data){
					if(data!=0)
					{
						//alert(data);
						var jsonData = $.parseJSON(data);
						for(var obj in jsonData)
						{
							$("#sttype").val(jsonData[obj]["sttype"]);
							$("#sdes").val(jsonData[obj]["sdes"]);
						}
					}

					else
					{
						$("#sttype").val("");
						$("#sdes").val("");
					}
				});
				
		}
	}

    async function chklength(xid) 
	{
        var xid = '#' + xid;
        var xval = $(xid).val();
		if(!empty(xval))
		{
			if (xval.length < 10 || xval.length > 10) {
				$("#warn").html('Ph. No. should be of 10 Characters!');
				$(xid).addClass("errtxt");
				$(xid).focus();
				$("#errtxt").val(false);
				return false;
			}
			else {
				$("#warn").html('');
				$(xid).removeClass("errtxt");
				$("#errtxt").val(true);
				return true;
			}
		}
	}

	function taxtype()
	{
		var xstatid=$("#statid").val();
		var xgstno=$("#gstno").val();
		//Tax Type
        $.post('taxtype.php',{statid:xstatid,gstno:xgstno},function(data){ 
			$("#sttype").html(data);
			var sttype=$("#sttype").val();
			getval(sttype,'sttype','');
		});
	}

	async function fieldchk()
	{
		glc=$("#glc").val();
		var xqry="select * from chkcatg_view where glc='"+glc+"'";
        await $.post('getjsondet.php',{mqry:xqry},function(data)
        {
			if (data!=0)
			{ 
				$("#catgid").attr("disabled",true);
			}
			else
			{
				$("#catgid").attr("disabled",false);
			}
		});
		var xqry="select * from chktaxtype_view where glc='"+glc+"'";
        await $.post('getjsondet.php',{mqry:xqry},function(data)
        {
			if (data!=0)
			{ 
				$("#sttype").attr("disabled",true);
			}
			else
			{
				$("#sttype").attr("disabled",false);
			}
		});
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
					<form id="glnform">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" value="1" id="optn" name="optn" />
                                <div class="row">
                                    <div class='col'>
                                        <div class='form-group'>
                                            <label for='gln'>Account Id:</label><span id='iderror' class='idwarn'></span>
                                            <input type="text" class="form-control" style="width:130px;" value="" id="glc" name="glc"  readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col'>
                                        <label for='gln' class='starclass'>Name </label>
                                        <input type="text" class="form-control" value="" id="gln" name="gln" onblur='toupper(this.id);' 
                                        maxlength='80' autofocus  autocomplete="off" tabindex="1" />
                                    </div>
                                </div>

                                <div class='row'>
                                    <div class='col'>
                                        <label for='dealer' class='starclass'>Schedule:</label>
                                        <select name='sch' id='sch' class='form-control' tabindex="2"  style='width:100%' >
											<?php
												$qry="select * from schmst order by schdes";
												$result=$db->getResult($qry);
												echo "<option value=''>--Select Schedule--</option>";
												while($data=mysqli_fetch_array($result))
												{
													extract($data);
													$msch=trim($sch);
													$mschdes=trim($schdes);
													echo "<option value='$sch'>$schdes</option>";
												}
											?>													
                                        </select>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="col">
                                        <div style='display:inline-block;'>
                                            <label for='dealer'>Opening Balance:</label>
                                            <input type="text" class="form-control " value="" id="yob" name="yob" data-name="Opening Balance" style='text-align:right;width:150px;'
                                            onkeyup='isnum(this.id);' maxlength='8' tabindex="3" />   
                                        </div>
                                        <div style='display:inline-block;margin-top:40px;margin-left:10px;'>
                                            <input type="radio" value="Dr." id="dr" class='yob' name="dbcr" tabindex="4" data-name="Dbcr" style='margin-right:10px;' checked/><label for="dr" style='margin-right:10px;'>Dr</label>
                                            <input type="radio" value="Cr." id="cr" class='yob' name="dbcr" tabindex="5" data-name="Dbcr"  style='margin-right:10px;'/><label for="cr" style='margin-right:10px;'>Cr</label>
                                        </div>                                    
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="col">
                                        <div class='form-group'>
                                            <label for='add1'>Billing Address:</label>
                                            <input type="text" class="form-control" value="" id="add1" name="add1" tabindex="6" autocomplete="off" data-name="Addres Line-1" maxlength='50'  />
                                            <input type="text" class="form-control" value="" id="add2" name="add2" tabindex="7" autocomplete="off" data-name="Addres Line-2" maxlength='50'/>
                                            <input type="text" class="form-control" value="" id="add3" name="add3" tabindex="8" autocomplete="off" data-name="Addres Line-3" maxlength='50'/>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-6'>
                                        <label for='ctid' class='starclass'>City:</label>
                                        <select name='ctid' id='ctid' class='form-control' onchange="getval(this.value,'ctid','');" tabindex="9"  style='width:100%' >
											<?php
												$qry="select * from city  order by city";
												$result=$db->getResult($qry);
												echo "<option value=''>--Select City--</option>";
												while($data=mysqli_fetch_array($result))
												{
													extract($data);
													$ctid=trim($ctid);
													$city=trim($city);
													echo "<option  value='$ctid'>$city</option>";
												}
											?>							
																	
                                        </select>
                                        <input type="hidden" name="statid" id="statid" class='form-control' readonly>

                                    </div>
                                    <div class='col-sm-6'>
                                        <label for='state'>State:</label>
                                        <input type="text" name="statdes" id="statdes" class='form-control' readonly>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-6'>
                                        <label for='pinno'>Pin No:</label>
                                        <input type="text" name="pinno" id="pinno" class='form-control' maxlength='10' tabindex='10' >
                                    </div>
                                    <div class='col-sm-6'>
                                        <label for='gstno'>GST No.:</label>
                                        <input type="text" name="gstno" id="gstno" class='form-control' maxlength='16' tabindex='11' onblur='taxtype();' >
                                    </div>
                                </div>
                            </div>
                     
                            <div class="col-sm-6">
                                <div class='row'>
                                    <div class='col-sm-6'>
                                        <label for='panno'>PAN No:</label>
                                        <input type="text" name="panno" id="panno" class='form-control' maxlength='15' tabindex='12' >
                                    </div>
                                    <div class='col-sm-6'>
                                        <label for='' class='starclass'>Tax Type.:</label>
                                        <select name='sttype' id='sttype' class='form-control' onchange="getval(this.value,'sttype','');" tabindex="13"  >

                                        </select>
                                        <input type="hidden" name="sdes" id="sdes" class='form-control' value=''>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-6'>
                                        <label for='phone' class='starclass'>Phone No:</label>
                                        <input type="text" name="phone" id="phone" class='form-control' 
										maxlength='10' oninput='isnum(this.id)' tabindex='14' >
                                    </div>
									<div class='col-sm-6'>
                                        <label for='catgid' class='starclass'>Accounts Category:</label>
                                        <select name='catgid' id='catgid' class='form-control cmbwdth' onchange="getval(this.value,'catgid','');" tabindex="14" style='width:100%' >
											<?php
												$qry="select * from catgmst  order by catgdes";
												$result=$db->getResult($qry);
												echo "<option value=''>--Select Category--</option>";
												while($data=mysqli_fetch_array($result))
												{
													extract($data);
													$catgid=trim($catgid);
													$catgdes=trim($catgdes);
													echo "<option  value='$catgid'>$catgdes</option>";
												}
											?>
                                        </select>
                                    </div>
                                </div>

                                <div id='bnkhead' onclick='toggledet();'>More Details</div>
                                <div id='bnkdet' class='hidedet'>
                                    <div class="row">
                                        <div class="col">
                                            <div class='form-group'>
                                                <label for='bname'>Bank Name:</label>
                                                <input type="text" class="form-control" value="" id="bname" maxlength='50' style="margin-bottom:5px;" name="bname" tabindex="15"
                                                 autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class='form-group'>
                                                <label for='brname'>Branch Name:</label>
                                                <input type="text" class="form-control" value="" id="brname" name="brname" 
                                                maxlength='50' autocomplete="off" data-name="Email"  tabindex='16'/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class='form-group'>
                                                <label for='ifsc'>IFSC Code:</label>
                                                <input type="text" class="form-control" value="" id="ifsc" name="ifsc"  autofocus tabindex="17" 
                                                autocomplete="off"  maxlength='15'/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class='form-group'>
                                                <label for='acno'>Account No:</label>
                                                <input type="text" class="form-control" value="" id="acno" name="acno" 
                                                 autofocus tabindex="18" autocomplete="off" maxlength='20'/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class='form-group'>
                                                <label for='actype'>Account Type:</label>
                                                <input type="text" class="form-control" maxlength='30' value="" id="actype" name="actype"  autofocus tabindex="19" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class='form-group'>
                                                <label for='acname'>Account Name:</label>
                                                <input type="text" class="form-control" value=""  maxlength='50' id="acname" name="acname"  autofocus tabindex="20" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class='form-group'>
                                                <label for='rem'>Remarks:</label>
                                                <input type="text" class="form-control" value="" id="rem" name="rem"  maxlength='150' autofocus tabindex="21" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        
                        <br/>
						<?php
							if($aflg)
							{
								echo "<input type='button' class='btn btn-success' value='Save' id='sav' tabindex='22' />";
							}
						?>
                        <input type='button' class='btn btn-warning' value='Cancel' id='cancel' onclick='cancelsave()' tabindex='12'/>

						<?php //include "exitbtn.php"; ?>
					</form>
				</div>

				<div id='view' class='tab-pane fade'>
					<div id="searchbox">
						<br>
						<input id="lookfor" type="text" class="form-control" placeholder='Search by Name,Account Category,Schedule' onkeyup="getlist();"/>
					</div>
					<div id='lst' style=' max-height:550px;overflow:auto;'>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

