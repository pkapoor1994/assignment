<style>
  .collapse {
    width:200px;
  }
  .innersub{
    color:#242424;
    display:block;
    text-align:left;
    margin:0px;
    margin-left:15px;
    margin-right:15px;
    padding:5px;
    padding-left:10px;
    border-bottom:1px solid #ebebeb;
    font-size:14px;
    cursor:pointer;
  }
  .innersub:hover {
		background: #4e73df;
    color:white;
    text-decoration:none;
    border-radius:2px;
	}

  .innersub div{
    display: inline-block;
    width:40%;
  }
  .navicon
  {
    text-align:right;
  }
  /* sideba font */
  .sidebar.toggled .nav-item .nav-link span , .sidebar .nav-item .nav-link i{
    font-size:14px;
  }
  .inner_menu{
    display:none;
  }
</style>

<script>
  function shwinner_menu(xid)
  {
    console.log('menuid:'+xid);
    // $(".inner_menu").hide();
    // $('.inner_menu').filter(':not(#navicon'+xid+')').hide();

    $(".inner_menu").each(function() {
        id = this.id;
        if(id!=="inner_"+xid)
        {
          $(this).hide();
          $('#navicon'+id).toggleClass("fa fa-angle-down");
          $('#navicon'+id).toggleClass("fa fa-angle-right");
        }
    });

    $("#inner_"+xid).toggle();
    $('#navicon'+xid).toggleClass("fa fa-angle-down");
    $('#navicon'+xid).toggleClass("fa fa-angle-right");
  }
</script>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
  <div class="sidebar-brand-icon">
    <i class="fa fa-tachometer-alt"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Dashboard</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">
<!-- Divider -->
<hr class="sidebar-divider">

<?php
  $mqry="select catg from userdet where uname='$mcuid' group by catg order by find_in_set(catg,'M,T,R')";
  $res=$db->getResult($mqry) or die(mysqli_error($con));


  $sidehead="";
  $menuid=0;
  while($rw=mysqli_fetch_array($res))
  {
      $mcatg=$rw["catg"];
        //head
      $menuicon="trash";
      if($sidehead!=$mcatg)
      {
          $sidehead=$mcatg;
          if($mcatg=="M")
          {
            $mheadname="Masters";
            $menuid++;
            $menuicon="table";
          }

          if($mcatg=="T")
          {
            $mheadname="Transaction";
            $menuid++;
            $menuicon="landmark";
          }

          if($mcatg=="R")
          {
            $mheadname="Reports";
            $menuid++;
            $menuicon="landmark";
          }

          $mqry1="select * from userdet where uname='$mcuid' and catg='$mcatg' and eflg='1' order by orderno";
          $res1=$db->getResult($mqry1);
          $rowcount=mysqli_num_rows($res1);
          if($rowcount>0)
          {
            echo "<li class='nav-item'>
            <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapse$menuid' aria-expanded='true' aria-controls='collapse$menuid'>
              <i class='fas fa-fw fa-$menuicon '></i>
              <span>$mheadname</span>
            </a>";
          }
      }


        echo "<div id='collapse$menuid' class='collapse' aria-labelledby='heading$menuid' data-parent='#accordionSidebar'>
                <div class='bg-white py-2 collapse-inner rounded'>";

                  $mqry1="select * from userdet where uname='$mcuid' and catg='$mcatg' order by orderno";
                  $res1=$db->getResult($mqry1) or die(mysqli_error($con));
                  while($rw2=mysqli_fetch_array($res1))
                  {
                    $mpg='"'.$rw2["pg"].'"';
                    $moptdes=$rw2["optdes"];
                    $moptn=$rw2["optn"];
                    $meflg=$rw2["eflg"];
                    $Ptc='"'.$rw2["tc"].'"';
                    if($meflg==1)
                    {
                      echo "<a class='innersub' style='white-space:normal;'  href='#' onclick='shwpg($mpg,$Ptc);'>$moptdes($mpg)</a>";
                    }
                  }
    
      echo "</div>
              </div>
          </li>";

    
  }

?>
<hr class="sidebar-divider d-none d-md-block">
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
