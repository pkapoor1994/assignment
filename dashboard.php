<?php
  $Pfdate=date('Y-m');
  $Pfdate=$Pfdate.'-01';
  echo "<input type='hidden' id='Pfdate' name='Pfdate' value='$Pfdate'/>";

    session_start();
    include "mainheader.php";
    include "dbclass.php";
    $db=new dbclass();
    if(isset($_SESSION['uname']))
    {
      $mqry="select * from control";
      $res=$db->getResult($mqry) or die(mysqli_error($con));
      while($rw=mysqli_fetch_array($res))
      {
        $_SESSION["cname"]=$rw["cname"];
        $_SESSION["cadd1"]=$rw["cadd1"];
        $_SESSION["cadd2"]=$rw["cadd2"];
        $_SESSION["cadd3"]=$rw["cadd3"];
        
      }
      $mcuid=$_SESSION["uname"];
      $mcname=$_SESSION["cname"];
      $mcyymm=$_SESSION["yymm"];
      global $mcuid;
      $mfdate=$_SESSION['datef'];
      $mtdate=$_SESSION['datet'];
     
      $mcurdt=date('Y-m-d');
      echo "<input type='hidden' id='curdate' name='curdate' value='$mcurdt' />";
      echo "<input type='hidden' id='mfdate' name='mfdate' value='$mfdate' />";
      echo "<input type='hidden' id='mtdate' name='mtdate' value='$mtdate' />";
      echo "<input type='hidden' id='mcyymm' name='mcyymm' value='$mcyymm' />";
    }
    else
    {
        echo "<script>window.open('index.php','_self')</script>";

    }
?>
<link rel="stylesheet" href="css/dashboard.css?rev=<?php echo time();?>">

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
      <?php include "sidenvabar.php"; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
          <?php
            include "dashtopbar.php";
          ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div id="dashcontent">
            <?php
             // include "dashcontent.php";
            ?>
          </div>
          <!-- End of Main Content -->

          <?php
            include "mainfooter.php";
          ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal--> 
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidde n="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <?php include "scripts.php"; ?>

  <script>
    $(document).ready(function(){
        shwmainmenu();
        $('#sidebarToggleTop').click();

    });

    function shwmainmenu()
    {
      mcuid=$("#mcuid").val();
      $("#dashcontent").html("<center><i class='fas fa-sync fa-spin'></i>&nbsp;&nbsp;<b>Loading...</b></center><br/><br/>");

        $.post("dashcontent.php",{xcuid:mcuid},function(data){
            $("#dashcontent").html(data);
            hidesubmenu();
            chgdate();
        });
    }

    function hidesubmenu()
    {
      $(".mysubmenu").hide();
    }

    $('#dashcontent').click(function(){
      if($('.collapse').hasClass("show"))
        {
          $('.collapse').removeClass('show');
        }
    });

    function shwsubmenu(xid)
    {
      $("#"+xid).toggle();
    }
    
    function shwpg(xpg,xPtc)
    {
      $('#accordionSidebar').addClass('toggled');
      $('.collapse').removeClass('show');
      $("#dashcontent").html("<center><i class='fas fa-sync fa-spin'></i>&nbsp;&nbsp;<b>Loading...</b></center><br/><br/>");
      $.post(xpg,{Ptc:xPtc},function(data){
          $("#dashcontent").html(data);
          hidemenu();
      });
    }

    function chgdate(xid)
    {
        mdocdt=$("#P_docdt").val();
        $("#P_docdt").val(mdocdt);
        maindash();
    }

    function maindash()
    {
      pathai_cnt();
      financial_cnt();
    }

    function pathai_cnt()
    {
      P_docdt=$("#P_docdt").val();
      $.post("getdashdet.php",{P_docdt:P_docdt,P_optn:1},function (data)
      {
          arr=data.split(":");
          P_today_bqty=parseInt(arr[0]);
          P_today_tqty=parseInt(arr[1]);
          P_month_bqty=parseInt(arr[2]);
          P_month_tqty=parseInt(arr[3]);
          P_year_bqty=parseInt(arr[4]);
          P_year_tqty=parseInt(arr[5]);
          
          K_today_bqty=parseInt(arr[6]);
          K_today_tqty=parseInt(arr[7]);
          K_month_bqty=parseInt(arr[8]);
          K_month_tqty=parseInt(arr[9]);
          K_year_bqty=parseInt(arr[10]);
          K_year_tqty=parseInt(arr[11]);

          L_today_bqty=parseInt(arr[12]);
          L_today_tqty=parseInt(arr[13]);
          L_month_bqty=parseInt(arr[14]);
          L_month_tqty=parseInt(arr[15]);
          L_year_bqty=parseInt(arr[16]);
          L_year_tqty=parseInt(arr[17]);

          C_today_bqty=parseInt(arr[18]);
          C_today_tqty=parseInt(arr[19]);
          C_month_bqty=parseInt(arr[20]);
          C_month_tqty=parseInt(arr[21]);
          C_year_bqty=parseInt(arr[22]);
          C_year_tqty=parseInt(arr[23]);

          N_today_bqty=parseInt(arr[24]);
          N_today_tqty=parseInt(arr[25]);
          N_month_bqty=parseInt(arr[26]);
          N_month_tqty=parseInt(arr[27]);
          N_year_bqty=parseInt(arr[28]);
          N_year_tqty=parseInt(arr[29]);

          M_today_Count=parseInt(arr[30]);
          M_month_Count=parseInt(arr[31]);
          M_year_Count=parseInt(arr[32]);
        

          $("#P_today_bqty").html(P_today_bqty);
          $("#P_today_tqty").html(P_today_tqty);
          $("#P_month_bqty").html(P_month_bqty);
          $("#P_month_tqty").html(P_month_tqty);
          $("#P_year_bqty").html(P_year_bqty);
          $("#P_year_tqty").html(P_year_tqty);

          $("#K_today_bqty").html(K_today_bqty);
          $("#K_today_tqty").html(K_today_tqty);
          $("#K_month_bqty").html(K_month_bqty);
          $("#K_month_tqty").html(K_month_tqty);
          $("#K_year_bqty").html(K_year_bqty);
          $("#K_year_tqty").html(K_year_tqty);

          $("#C_today_bqty").html(C_today_bqty);
          $("#C_today_tqty").html(C_today_tqty);
          $("#C_month_bqty").html(C_month_bqty);
          $("#C_month_tqty").html(C_month_tqty);
          $("#C_year_bqty").html(C_year_bqty);
          $("#C_year_tqty").html(C_year_tqty);

          $("#L_today_bqty").html(L_today_bqty);
          $("#L_today_tqty").html(L_today_tqty);
          $("#L_month_bqty").html(L_month_bqty);
          $("#L_month_tqty").html(L_month_tqty);
          $("#L_year_bqty").html(L_year_bqty);
          $("#L_year_tqty").html(L_year_tqty);

          $("#N_today_bqty").html(N_today_bqty);
          $("#N_today_tqty").html(N_today_tqty);
          $("#N_month_bqty").html(N_month_bqty);
          $("#N_month_tqty").html(N_month_tqty);
          $("#N_year_bqty").html(N_year_bqty);
          $("#N_year_tqty").html(N_year_tqty);

          $("#M_today_Count").html(M_today_Count);
          $("#M_month_Count").html(M_month_Count);
          $("#M_year_Count").html(M_year_Count);
      });
    }

    function financial_cnt()
    {
      P_docdt=$("#P_docdt").val();
      $.post("getdashdet.php",{P_docdt:P_docdt,P_optn:2},function (data)
      {
          arr=data.split(":");
          R_today_amount=parseFloat(arr[0]);
          R_till_amount=parseFloat(arr[1]);
          P_today_amount=parseFloat(arr[2]);
          P_till_amount=parseFloat(arr[3]);
          debtors_amount=parseFloat(arr[4]);
          credtors_amount=parseFloat(arr[5]);
          debtors_total=parseInt(arr[6]);
          credtors_total=parseInt(arr[7]);
          total_receipt=parseFloat(arr[8]);
          total_payments=parseFloat(arr[9]);
          mobal=arr[10];
          mob=arr[11];
          D_today_amount=parseFloat(arr[12]);

          $("#R_today_amount").html('TODAY : '+R_today_amount);
          $("#R_till_amount").html('TILL DATE : '+R_till_amount);
          $("#P_today_amount").html('TODAY : '+P_today_amount);
          $("#P_till_amount").html('TILL DATE : '+P_till_amount);
          $("#debtors_amount").html(debtors_amount);
          $("#credtors_amount").html(credtors_amount);
          $("#debtors_total").html(debtors_total);
          $("#credtors_total").html(credtors_total);
          $("#total_receipt").html('Rs. '+total_receipt);
          $("#total_payments").html('Rs '+total_payments);
          $("#mobal").html('Rs '+mobal);
          $("#mob").html('Rs '+mob);
          $("#D_today_amount").html('Rs '+D_today_amount);



      });
    }

</script>

</body>
</html>