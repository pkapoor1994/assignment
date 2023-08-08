<?php
	session_start();
	include "dbclass.php";
    $db=new dbclass();
	$formtitle="GST Category Master";
	$formno="04";
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
				var gstdes=$('#gstdes').val();

				var mydata = $("#gstform").serialize();
				$.ajax({
					type:"POST",
					url:"gstcatgdet.php",
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
		$("#gsttype").val("");
		$("#gstdes").val("");
		$("#gstype").val("");
		$("#gper1").val("");
		$("#gper2").val("");
		$("#gper3").val("");
		$("#rem").val("");
		$("#optn").val("1");
		$("#gstdes").focus();
        $("#cancel").hide();
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
		var marr={"gstdes":'gstdes','gstype':'gstype'};
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
		$.post('gstcatgdet.php', {mdes:xlookfor,mmflg:xmflg,mdflg:xdflg,optn:xoptn}, function (data) {
			$("#lst").html(data);
		});
	}

	async function shwupdt(xrecno)
    {
		var arr=xrecno.split(':');
        var gsttype=arr[0];
		$('#gsttype').val(gsttype);
        var xqry="select * from gstcatg where gsttype='"+gsttype+"'";
        await $.post('getjsondet.php',{mrecno:xrecno,mqry:xqry},function(data)
        {
			//alert(data);
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
								$("#"+prop).val(jsonData[obj][prop].trim());
							}
						}
					}
				}
			}
			$("#tab1").html('Update');
			$("#tab1").click();
			$("#gstdes").focus();
			setTimeout(() => {
			    $("#gstdes").focus();
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
            $.post('gstcatgdet.php',{mrecno:xid,optn:'4'},function(data){
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
			$("#gstdes").focus();
		}, 150);
		}
    });

	function cancelsave()
    {
		fablank();
    }

</script>
<div class='mastercont'>
	<div class='frmtitlebar'>
		<?php echo $formtitle; ?>
		<a class='btn cornerclose' id='exitbtn' href="dashboard.php" data-toggle='tooltip'  title='Close' data-original-title='Close' ><i class="fas fa-times-circle" ></i></a>

	</div>
	<div clas='masterform'>
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
                                <div class='row'>	
                                    <div class='col'>
                                        <div class="form-group">
                                            <label for='gstdes' class='starclass'>GST Category: </label>
                                            <input type="hidden" class="form-control" value="" id="gsttype" name="gsttype" />
                                            <input type="text" class="form-control" value="" id="gstdes" name="gstdes" onblur='toupper(this.id);' tabindex='1' maxlength='30'
                                             autofocus  autocomplete="off" />
							            </div>
							        </div>
							    </div>
                                <div class='row'>
                                    <div class='col'>	
                                        <div class="form-group">
                                            <label for='statdes' class='starclass'>Tax Type: </label>
                                            <select name='gstype' id='gstype' class='form-control' onchange="getval(this.value,'glc','');" tabindex="2"  >
                                                <option value=''>-- Select Tax Type --</option>
                                                <option value='GOODS'>GOODS</option>
                                                <option value='SERVICE'>SERVICE</option>
                                            </select>
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
                                                    oninput='isnum(this.id);' onblur='getcal();' maxlength='6' tabindex='3' autocomplete="off"/>
                                                </div>	
                                            </div>	
                                            <div class='col'>	
                                                <div class="form-group">
                                                    <label for='gper'>CGST:</label>
                                                    <input type="text" class="form-control size text-right" style="width:90px;" value="0" id="gper2" name="gper2" placeholder='0.00' 
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
                                <div class='row'>
                                    <div class='col'>	
                                        <label for='rem'>Remarks: </label>
                                        <input type="text" class="form-control size" value="" id="rem" name="rem" tabindex='4'
                                         maxlength='40' autocomplete="off"/>
                                         <br>
                                    </div>
                                </div>
                            </div>
                            
						</div>

						<?php
							if($aflg)
							{
								echo "<input type='button' class='btn btn-success' value='Save' id='sav'  tabindex='5'/>";
							}
						?>
                        <input type='button' class='btn btn-warning' value='Cancel' id='cancel' onclick='cancelsave()' tabindex='6'/>
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

