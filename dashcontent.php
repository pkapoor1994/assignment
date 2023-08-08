<?php
session_start();

  include "dbclass.php";
  include "convert.php";
  $db=new dbclass();
  // $mdate1=$_POST['mdate1'];
  // $mdate2=$_POST['mdate1'];
  if (isset($_POST["mdate1"]))
	{
		$mdate1=$_POST["mdate1"];
	}
	else
	{
   
    $mdate1=date('Y-m-d');
	}
  // $mdate1=date('Y-m-d');
  $mdate2=date('Y-m-d');
  $Procqty=0;$Purqty=0; $Convqty=0;$Incrts=0; $totsalqty=0; $Psaleqty=0; $CSqty=0; $Scrpqty=0; $Outcrts=0;$BMilk=0;
  $curr_uid=trim($_SESSION["uid"]);
?>
<style>
    .titlelbl
  {
      color:#4e73df;
      font-weight:bold;
      margin-top:8px;
      font-size:16px;
  }

  #refbutton
  {
    padding-left:0px ;
	margin-left:5px;
    /* margin-left:-200px; */
  }
  #refresh
    {
		font-weight:bold;
	}
  @media screen and (max-width:700px) 
  {
    .card-titletxt
    {
      font-size:14px;
    }
    .card-txtval
    {
      font-size:12px;
    }
    .container,.container-fluid
    {
      padding-left:0rem;
      padding-right:0rem
    }
    #refbutton
    {
      padding-left:0px ;
      margin-left:2px;
    }
    #refresh
    {
      font-size:12px;
      /* padding:4px; */
      padding-left:2px;
      padding-right:2px;
      margin-top:5px; 
	  height:35px;
       /* margin-left:50px;  */
      /* width:170px; */
      
    }
  }
</style>
<script>
    $(document).ready(function(){
      
      var Timer1=setInterval(async () => {
            await screensize();
          }, 150);
    });

    function screensize()
    {
      var windowsize = window.innerWidth;
      if(windowsize>760)
      {
        $("#sidebarbox").hide();
      }
    }

    function hidemenu()
    {
      $("#sidebarbox").hide();
    }
    
  </script>

