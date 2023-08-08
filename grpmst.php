<?php
	session_start();
	include "dbclass.php";
    $db=new dbclass();
	$formtitle="Group Master";
	$formno="03";
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
	var mgroup="";
	var worklog=[];
    $(document).ready(function(){
		getlist();
		fablank();

		$("#gdes").focus();
		$("#sav").click(function(e){
			e.preventDefault();
			if(chkempty())
			{				
				$("#warn").removeClass("errtxt");
				var gdes=$('#gdes').val();

				var mydata = $("#groupform").serialize();
				$.ajax({
					type:"POST",
					url:"grpmstdet.php",
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
									if(errmsg==3)
									{
										$("#warn").removeClass("success");
										$("#warn").addClass("danger");
										$("#warn").html("Already Exist!");
										window.setTimeout(function(){ $("#warn").html("");},2000);

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
		$("#grp").val("");
		$("#gdes").val("");
		$("#optn").val("1");
		$("#gdes").focus();
		$("#tab1").html("Add");
        $("#cancel").hide();
	}

	function chkempty()
    {
		var marr={"gdes":'gdes'};
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
		$.post('grpmstdet.php', {mdes:xlookfor,mmflg:xmflg,mdflg:xdflg,optn:xoptn}, function (data) {
			$("#lst").html(data);
		});
	}

	async function shwupdt(xrecno)
    {
		var arr=xrecno.split(':');
        var grp=arr[0];
		$('#grp').val(grp);
        var xqry="select * from grpmst where grp='"+grp+"'";
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
			setTimeout(() => {
			    $("#gdes").focus();
            }, 200);
			$('#optn').val('2');
			chkempty();
            $("#cancel").show();
			$("#warn").html("");
        });
    }
	
	function del(xid)
    {
		var gdes=$('#gdes'+xid).val();
        var yn=confirm('Confirm to Delete?')
        if(yn)
        {
			$("#warn").removeClass("success");
			$("#warn").addClass("warn");
            $.post('grpmstdet.php',{mrecno:xid,optn:'4'},function(data){
				if(data==1)
                {
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

	function cancelsave()
    {
		fablank();
    }
	tab1.addEventListener("click", function () {
		moptn=$("#optn").val();
		if(moptn=="1")
		{
			setTimeout(() => {
			$("#gdes").focus();
		}, 150);
		}
    });

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
					<form id="groupform">
						<input type="hidden" class="form-control" value="1" id="optn" name="optn" />
						<div class="row">
							<div class="col-sm-6">
								<label for='gdes' class='starclass'>Group Name: </label>
								<input type="hidden" class="form-control" value="" id="grp" name="grp" />
								<input type="text" class="form-control" value="" id="gdes" name="gdes" onblur='toupper(this.id);' maxlength='30' autofocus  autocomplete="off"/><br/>
							</div>
						</div>
					
						<?php
							if($aflg)
							{
								echo "<input type='button' class='btn btn-success' value='Save' id='sav'/>";
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

