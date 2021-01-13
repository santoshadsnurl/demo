<?php
error_reporting(0);
$keyword = "";
if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']!="")
{
	$keyword = $_REQUEST['keyword'];
}

$sliders_image = $newobject->getallrecords($conn,"sliders","ORDER BY id DESC");
$sliders = $newobject->getallrecords($conn,"sliders","ORDER BY id DESC");
$brands = $newobject->getallrecords($conn,"brands","ORDER BY order_no");
$categories = $newobject->getlimit($conn,"categories","ORDER BY order_no","LIMIT 7");
$categories_header = $newobject->getlimit($conn,"categories","ORDER BY order_no","LIMIT 7");
$categories_filte = $newobject->getlimit($conn,"categories","ORDER BY order_no","LIMIT 60");
$cart_session = $newobject->getconrecords($conn,"cart", "session_id = '$session_id'");
$most_viewed = $newobject->getconlimit($conn,"most_viewed","product_id!=0","ORDER BY total_count DESC","LIMIT 5");
$most_product_id = "";
if($most_viewed->num_rows>0)
{
	$a = 0;
	while($result_product = $most_viewed->fetch_array(MYSQLI_ASSOC))
	{
		if($a==0)
		{
			$most_product_id .= "'".$result_product['product_id']."'";
		}
		else
		{
			$most_product_id .= ','."'".$result_product['product_id']."'";
		}
		$a++;
	}
}

$most_viewed_products = $newobject->getconrecords($conn,"products","id IN ($most_product_id)");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<meta name="keywords" content="">
<meta name="robots" content="all">
<title>Ramanta</title>
<link rel="icon" href="<?php echo $site_root; ?>assets/images/favicon.ico" type="image/ico" sizes="16x16">
<link rel="stylesheet" href="<?php echo $site_root; ?>assets/css/theme.css">
<link rel="stylesheet" href="<?php echo $site_root; ?>assets/css/owl.carousel.css">
<link rel="stylesheet" href="<?php echo $site_root; ?>assets/css/owl.transitions.css">
<link rel="stylesheet" href="<?php echo $site_root; ?>assets/css/animate.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $site_root; ?>assets/css/hover.css">
<link rel="stylesheet" href="<?php echo $site_root; ?>assets/css/mmenu-light.css" />
<link rel="stylesheet" href="<?php echo $site_root; ?>assets/css/main.css">
<link rel="stylesheet" href="<?php echo $site_root; ?>assets/css/responsive.css">
<link href="<?php echo $site_root; ?>assets/css/bootstrapValidator.css" rel="stylesheet" />

<!-- js start here -->
<script src="<?php echo $site_root; ?>assets/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo $site_root; ?>assets/js/theme.js"></script>
<script src="<?php echo $site_root; ?>assets/js/bootstrap-hover-dropdown.min.js"></script>
<script src="<?php echo $site_root; ?>assets/js/bootstrapValidator.js"></script>
<!-- js end here -->

<!-- Fonts -->
<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,900' rel='stylesheet'>
<style>
/* CSS cartbox */
.count { display: inline-block; width: 17px; height: 17px; line-height: 18px; text-align: center; font-weight: bold; -webkit-border-radius: 50%; -moz-border-radius: 50%; border-radius: 50%; background-color: #E46E00; position: relative; color: #fff; }
/* CSS cartbox */
/* CSS Auto Search */
.ui-widget-content { width: 200PX; max-height: 400px; overflow-y: auto; overflow-x: hidden; }
.ui-menu .ui-menu-item { font-size:13px; }
.lstng-dtl .tc-features .block img { width: 100%; }
/* CSS Auto Search */

div#popup_content { margin:15px; }
#toPopup { font-family: "lucida grande", tahoma, verdana, arial, sans-serif; background: none repeat scroll 0 0 #444444; border: 7px solid #FFFFFF; border-radius: 2px 2px 2px 2px; color: #FFFFFF; display: none; font-size: 14px; position: fixed; top: 23%; width: 400px; z-index: 9999; left:50%; text-align:center !important; -ms-transform: translate(-50%); -webkit-transform: translate(-50%); -moz-transform: translate(-50%); -o-transform: translate(-50%); transform:translate(-50%) }
.not-active { pointer-events: none; cursor: default; }
.input-groupss.vldmaterial img { border: 3px solid #bb171b; }
.input-groupss.vldcol img { border: 3px solid #bb171b; }
.input-groupss.vldqty input { border: 1px solid #ff0006; }
.input-groupss.vldsize select { border: 1px solid #ff0006; }
</style>
</head>
<body oncontextmenu="return true;">
<!-- ======= HEADER ======= -->
<header class="header-style-1"> 
  
  <!-- ======= TOP MENU ======= -->
  <div class="top-bar animate-dropdown">
    <div class="container">
      <div class="header-top-inner">
        <div class="cnt-block ">
          <ul class="list-unstyled list-inline">
            <li><a href="#"> <img src="<?php echo $site_root; ?>assets/images/icon/location.png" alt="location"> INDIA’s FASTEST SHOPPING DESTINATION</a></li>
          </ul>
          <!-- /.list-unstyled --> 
        </div>
        <div class="cnt-account">
          <ul class="list-unstyled">
		  
	
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!="") { ?>
            <li><a href="#" id="cat2"><i class="icon fa fa-user"></i>My Account</a></li>
            <div class="blok2" style="display:none"> <a class="dropdown-item" href="<?php echo $site_root; ?>my-account/"> <i class="fa fa-user" aria-hidden="true"></i>My Account </a> <a class="dropdown-item" href="<?php echo $site_root; ?>my-order/"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Order </a> <a class="dropdown-item" href="<?php echo $site_root; ?>my-wishlist/"> <i class="fa fa-heart-o" aria-hidden="true"></i> Wishlist </a> <a class="dropdown-item" href="<?php echo $site_root; ?>manage-address/"> <i class="fa fa-address-book" aria-hidden="true"></i> Manage Address </a> <a class="dropdown-item" href="<?php echo $site_root; ?>logout/"><i class="fa fa-sign-in" aria-hidden="true"></i> Logout</a> </div>
            <?php } else { ?>
            <li><a href="<?php echo $site_root; ?>login/"><i class="icon fa fa-lock"></i>Login</a></li>
            <?php } ?>
            <li><a href="<?php echo $site_root; ?>cart/"><i class="icon fa fa-shopping-cart"></i>My Cart</a></li>
			
				  
		   <li >
		   <a href="https://www.delhivery.com/" target="_blink" class="hvr-shrink" title="Delhivery Service"><img src="<?php echo $site_root; ?>assets/images/delivery-icon.png" alt="delivery-icon" class="delivery_icon"> </a></li>
		  
          </ul>
        </div>
        <!-- /.cnt-account -->
        
        <div class="clearfix"></div>
      </div>
      <!-- /.header-top-inner --> 
    </div>
    <!-- /.container --> 
  </div>
  <!-- /.header-top --> 
  <!-- ======= TOP MENU : END ======= -->
  <div class="main-header">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 logo-holder"> 
          <!-- ======= LOGO ======= -->
          <div class="logo"> <a href="<?php echo $site_root; ?>"> <img src="<?php echo $site_root; ?>assets/images/logo.png" alt="logo"> </a> </div>
          <div id="category-main" class="header_menuicon nav-icon"> <a href="#menu" class="mobile_menu"> <span></span> <span></span> <span></span> </a>
            <nav id="menu" class="mmenu_item">
              <ul>
                <li> <span> Automotive </span>
                  <ul>
                    <li> <span> Desktops </span>
                      <ul>
                        <li> <a href="https://projects.adsandurl.com/ramanta/super-sub-categories/laptop-skins-2/">Laptop Skins </a> </li>
                        <li> <a href="https://projects.adsandurl.com/ramanta/super-sub-categories/car-antenna-1/">Car Antenna </a> </li>
                      </ul>
                    </li>
                    <li> <span> Car Parts &amp; Accessories </span>
                      <ul >
                        <li><a href="https://projects.adsandurl.com/ramanta/super-sub-categories/keyboards-4/">Keyboards </a></li>
                        <li><a href="https://projects.adsandurl.com/ramanta/super-sub-categories/webcam-3/">Webcam </a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li> <span> Automotive </span>
                  <ul>
                    <li> <span> Desktops </span>
                      <ul>
                        <li> <a href="https://projects.adsandurl.com/ramanta/super-sub-categories/laptop-skins-2/">Laptop Skins </a> </li>
                        <li> <a href="https://projects.adsandurl.com/ramanta/super-sub-categories/car-antenna-1/">Car Antenna </a> </li>
                      </ul>
                    </li>
                    <li> <span> Car Parts &amp; Accessories </span>
                      <ul >
                        <li><a href="https://projects.adsandurl.com/ramanta/super-sub-categories/keyboards-4/">Keyboards </a></li>
                        <li><a href="https://projects.adsandurl.com/ramanta/super-sub-categories/webcam-3/">Webcam </a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
            
            <!-- ======= NAVBAR : END ======= --> 
            
          </div>
          <!-- ======= LOGO : END ======= --> </div>
        <div class="col-xs-12 col-sm-12 col-md-7 top-search-holder"> 
          
          <!-- ======= SEARCH AREA ======= -->
          <div class="search-area">
            <form name="headerfrm" id="headerfrm" action="<?php echo $site_root; ?>search/" method="post">
              <div class="control-group">
                <input class="search-field" name="keyword" id="keyword" value="<?php echo $keyword; ?>" placeholder="Search best quality products..." />
                <a class="search-button btn-blues" href="javascript:void(0);" onClick="javascript:document.getElementById('headerfrm').submit();" ></a> </div>
            </form>
          </div>
          
          <!-- ======= SEARCH AREA : END ====== --> </div>
        <!-- /.top-search-holder -->
        
        <div class="col-xs-12 col-sm-12 col-md-2 animate-dropdown top-cart-row"> 
          <!-- ======= SHOPPING CART DROPDOWN ======= -->
          
          <div class="dropdown dropdown-cart" id="carthtml"> <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
            <div class="items-cart-inner">
              <div class="basket"> <img src="<?php echo $site_root; ?>assets/images/icon/cart.png" alt=""> </div>
              <div class="basket-item-count"><span id="totalincart" class="count"><?php echo $newobject->gettotalitem($conn,$session_id); ?></span> </div>
              <div class="total-price-basket"> <span class="total-price"> <span class="sign"> &#x20b9; </span><span class="value" ><?php echo number_format($newobject->subTotal($conn,$session_id),2); ?></span> </span> </div>
            </div>
            </a>
            <?php if($cart_session->num_rows>0) { ?>
            <ul class="dropdown-menu">
              <li>
                <div class="cart-item product-summary">
                  <?php
				while($result_cart = $cart_session->fetch_array(MYSQLI_ASSOC))
				{
					$product_id = $result_cart['product_id'];
					$cart_quantity = $result_cart['product_quantity'];
					$title = $newobject->getInfo($conn,"products",$arabic."title",$product_id);
					$price = $newobject->getInfo($conn,"products","sale_price",$product_id);
					$image = $newobject->getInfo($conn,"products","image",$product_id);
					$alias = $newobject->getInfo($conn,"products","alias",$product_id);
					?>
                  <div class="row">
                    <div class="col-xs-4">
                      <div class="image"> <a href="<?php echo $site_root; ?>detail/<?php echo $alias; ?>/"><img src="<?php echo $site_root; ?>uploads/products/<?php echo $image; ?>" alt=""></a> </div>
                    </div>
                    <div class="col-xs-7">
                      <h3 class="name"><a href="<?php echo $site_root; ?>detail/<?php echo $alias; ?>/"><?php echo $title; ?></a></h3>
                      <div class="price"><?php echo $cart_quantity; ?> x &#x20b9; <?php echo $price; ?></div>
                    </div>
                    <div class="col-xs-1 action"> <a href="javascript:void(0);" onClick="DeleteProduct('<?php echo $product_id; ?>');"><i class="fa fa-trash"></i></a> </div>
                  </div>
                  <?php
				}
				?>
                </div>
                <!-- /.cart-item -->
                <div class="clearfix"></div>
                <hr>
                <div class="clearfix cart-total">
                  <div class="pull-right"> <span class="text">Sub Total :</span><span class="price" id="totalvalues"> &#x20b9; <?php echo number_format($newobject->subTotal($conn,$session_id),2); ?></span> </div>
                  <div class="clearfix"></div>
                  <a href="<?php echo $site_root; ?>cart/" class="btn btn-upper btn-primary btn-block m-t-20">Proceed</a> </div>
                <!-- /.cart-total--> 
                
              </li>
            </ul>
            <?php } ?>
            <!-- /.dropdown-menu--> 
          </div>
          <!-- /.dropdown-cart --> 
          
          <!-- ======= SHOPPING CART DROPDOWN : END ======= --> </div>
        <!-- /.top-cart-row --> 
      </div>
      <!-- /.row --> 
      
    </div>
    <!-- /.container --> 
    
  </div>
  <!-- /.main-header --> 
  
  <!-- ======= NAVBAR ======= -->
  <div class="header-nav animate-dropdown">
    <div class="container">
      <div class="yamm navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        </div>
        <div class="nav-bg-class">
          <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
            <div class="nav-outer">
              <ul class="nav navbar-nav">
                <?php 
				if($categories->num_rows>0)
				{
					while($categories_result = $categories->fetch_array(MYSQLI_ASSOC))
					{
						$category_id = $categories_result['id'];
						?>
                <li class="dropdown mega-menu toggleli"> <a href="<?php echo $site_root; ?>categories/<?php echo $categories_result['alias']; ?>/"  data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown"> <?php echo $categories_result['title']; ?></a>
                  <div class="caret">
                    <?php 
						$sub_categories = $newobject->getcondrecords($conn,"sub_categories","category_id = '$category_id'","ORDER BY order_no");
						if($sub_categories->num_rows>0)
						{
							?>
                    <ul class="dropdown-menu container">
                      <li>
                        <div class="yamm-content">
                          <div class="row">
                            <div class="col-md-8">
                              <?php
									while($sub_categories_result = $sub_categories->fetch_array(MYSQLI_ASSOC))
									{
										$sub_category_id = $sub_categories_result['id'];
										?>
                              <div class="col-menu">
                                <h2 class="title"><a href="<?php echo $site_root; ?>sub-categories/<?php echo $sub_categories_result['alias']; ?>/"><?php echo $sub_categories_result['title']; ?></a></h2>
                                <?php 
										$sub_sub_categories = $newobject->getconrecords($conn,"sub_sub_categories","sub_category_id = '$sub_category_id'");
										if($sub_sub_categories->num_rows>0)
										{
											?>
                                <ul class="links">
                                  <?php
											while($sub_sub_categories_result = $sub_sub_categories->fetch_array(MYSQLI_ASSOC))
											{
												?>
                                  <li><a href="<?php echo $site_root; ?>super-sub-categories/<?php echo $sub_sub_categories_result['alias']; ?>/"><?php echo $sub_sub_categories_result[$arabic.'title']; ?> </a></li>
                                  <?php
											}
											?>
                                </ul>
                                <?php
										}
										?>
                              </div>
                              <?php
									}
									?>
                            </div>
                            <div class="col-md-4">
                              <div class="col-menu custom-banner"> <a href="javascript:void(0);"><img alt="banner images" src="<?php echo $categories_result['image']; ?>" class="img-responsive"></a> </div>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                    <?php
						}
						?>
                  </div>
                </li>
                <?php
					}
				}
				?>
              </ul>
              <!-- /.navbar-nav -->
              <div class="clearfix"></div>
            </div>
            <!-- /.nav-outer --> 
          </div>
          <!-- /.navbar-collapse --> 
          
        </div>
        <!-- /.nav-bg-class --> 
      </div>
      <!-- /.navbar-default --> 
    </div>
    <!-- /.container-class --> 
    
  </div>
  <!-- /.header-nav --> 
  <!-- ======= NAVBAR : END ======= -->
  
  <div class="clearfix"></div>
  <div id="toPopup" class="lodmod">
    <div id="popup_content"> <!--your content start-->
      <div class="lodmod1"> <strong><span id="loadmsgpromo"></span></strong> </div>
    </div>
    <!--your content end--> 
  </div>
</header>
