
<?php
 $year=date('Y', strtotime($mfdate));
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarTop" class="btn btn-link d-md-none rounded-circle mr-3" onclick='opnmenu();'>
  <i class="fa fa-bars"></i>
</button>

<!-- Topbar Search -->
<!---<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
  <div class="input-group">
    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
    <div class="input-group-append">
      <button class="btn btn-primary" type="button">
        <i class="fas fa-search fa-sm"></i>
      </button>
    </div>
  </div>
</form>-->
<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
  <div class="company_name">
  <?php echo $mcname."(".$year.'-'.substr($mcyymm,2,4).")"; ?>
  </div>
</form>
<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

  <!-- Nav Item - Search Dropdown (Visible Only XS) -->
  <li class="nav-item dropdown no-arrow d-sm-none">
    <div class="company_name_small">
        <?php echo $mcname."(".$year.'-'.substr($mcyymm,2,4).")"; ?>
    </div>
        <!--<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-search fa-fw"></i>
    </a>-->
    <!-- Dropdown - Messages -->
    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
      <form class="form-inline mr-auto w-100 navbar-search">
        <div class="input-group">
          <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </li>

  <?php
    //include "notification.php";
  ?>
  <!-- Nav Item - User Information -->
  <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $mcuid; ?><input type="hidden" id='mcuid' value="<?php  echo $mcuid; ?>" /></span>
      <img class="img-profile rounded-circle" src="img/userimg.png">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Logout
      </a>
    </div>
  </li>

</ul>

</nav>



<div id='sidebarbox'>
    <div class='toscroll' >
        <div id='sidebarboxbg' onclick='hidemenu();'></div>
        <div id="sidebarboxcont" >
            <img src='bloader.gif' id='contgif' />
            <h4>Loading.........</h4><br/>
        </div>
    </div>
</div>

<script>
  function opnmenu()
	{
		$('#sidebarbox').show();
		$.post('sidebarmobile.php',{},function(sidedata){ 
			$('#sidebarboxcont').html(sidedata);
		});
	}
</script>