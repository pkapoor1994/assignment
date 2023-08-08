<?php
 include "mainheader.php";
 ?>
<style>
  .bg-login-image{
    background: url(img/concreteimg.jpg);
    background-size: cover;
  }
  .firmlogo{
    height: 110px;
    width: auto;
    margin-bottom:20px;
  }
  #uname{
    font-size:16px;
    font-weight:bold;
  }
  #upass{
    font-size:16px;
    font-weight:bold;
  }  

  #btnlogin{
    font-size:16px;
    font-weight:bold;
  }
  #btnotp{
    font-size:16px;
    font-weight:bold;
  }
</style>
<script>

</script>
<script src='js/comman.js'></script>
<script src='js/custom.js'></script>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <img src='img/firmlogo.jpg' class='firmlogo' />
                    <h1 class="h4 text-gray-900 mb-2"><b>Login</b></h1>
                  </div>
                  <div  id="warn" class='warn'></div>
                    <form class="user">
        
                    <div class='login'>
                        <div class="form-group">
                          <input type="text" class="form-control form-control-user" id="uname" aria-describedby="emailHelp" placeholder="Enter User Name" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                          <input type="password" class="form-control form-control-user" id="upass" placeholder="Password"  autocomplete="off" >
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary btn-user btn-block" id="btnlogin" onclick='chklogin();'>
                      Login
                    </a>
                   

                    </div>
                    <div class="text-center">
                      <img src='img/kvr.jpg' style='width:20px;height:20px; margin:8px;' />
                      <h6 class='h5 text-gray-900 mb-2'>Kvr Technologies</h6>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

<?php
  include "scripts.php";
?>
 <script>
    $(document).ready(function(){
      //  $('.otps').hide();
    });
    </script>
</body>
</html>