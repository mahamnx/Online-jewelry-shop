<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark ">
    <!-- Left navbar links -->
    <div class="container">
      <ul class="navbar-nav">
        <?php if(isset($_SESSION['login_id'])): ?>
        <li class="nav-item">
          <!-- <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a> -->
        </li>
      <?php endif; ?>
        <li>
          <a class="nav-link text-white"  href="./" role="button"> <large><b>Online Jewelry Shop</b></large></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
       
        <li class="nav-item">
          <a class="nav-link nav-home" href="./">
            <b>Home</b>
          </a>
        </li>
        <?php if(!isset($_SESSION['login_id'])): ?>
          <li class="nav-item">
            <a class="nav-link nav-login" href="login.php" id="login">
              <b>Signin</b>
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link nav-login" href="index.php?page=my_order" id="login">
              <b>My Orders</b>
            </a>
          </li>
          <li class="nav-item dropdown">
              <a class="dropdown-toggle nav-link" data-toggle="dropdown"  href="javascript:void(0)" aria-expanded="true">
                <div class="badge badge-danger cart-count">0</div>
                <i class="fa fa-shopping-cart"></i>
                <span>Cart</span>
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:25vw">
                <div class="cart-list w-100" id="cart_product">
                
                  
                </div>
                
                <div class="d-flex bg-light justify-content-center w-100 p-2">
                    <a href="index.php?page=cart" class="btn btn-sm btn-primary btn-block col-sm-4 text-white"><i class="fa fa-edit"></i>  View Cart</a>
                </div>
              </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
              <span>
                <div class="d-felx badge-pill">
                  <span class="fa fa-user mr-2"></span>
                  <span><b><?php echo ucwords($_SESSION['login_firstname']) ?></b></span>
                  <span class="fa fa-angle-down ml-2"></span>
                </div>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
              <a class="dropdown-item" href="signup.php" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
              <a class="dropdown-item" href="admin/ajax.php?action=logout2"><i class="fa fa-power-off"></i> Logout</a>
            </div>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
  <style>
     .cart-img {
          width: calc(25%);
          max-height: 13vh;
          overflow: hidden;
          padding: 3px
      }
      .cart-img img{
        width: 100%;
        /*height: 100%;*/
      }
      .cart-qty {
        font-size: 14px
      }
  </style>
  <!-- /.navbar -->
  <script>
    $(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      if($('.nav-link.nav-'+page).length > 0){
        $('.nav-link.nav-'+page).addClass('active')
          console.log($('.nav-link.nav-'+page).hasClass('tree-item'))
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
          $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
      $('.manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id='+$(this).attr('data-id'))
      })
    })
  </script>
