<?php 

include('config/function.php'); 

if(isset($_REQUEST['alias']) && $_REQUEST['alias']!="")
{
	/* echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>"; */
	$alias = $_REQUEST['alias'];
	$sub_category_id_categories = $newobject->getdata($conn,"sub_categories","id","alias",$alias);
	$category_id_list = $newobject->getdata($conn,"sub_categories","category_id","alias",$alias);
	$category_title = $newobject->getdata($conn,"categories","title","id",$category_id_list);
	$sortby = "";
	$total_page = "";
	$addsubqry = "";
	$brand_id = "";
	$priceqry = "";
	$brand_ids = array();
	$price = array();
	$price_ids = array("","0 - 499","500 - 999","1000 - 1499","500 - 1999","2000 and above");
	$orderby = " ORDER BY id DESC";
	$pageaction = $site_root."sub-categories/".$alias.'/';
	if(isset($_REQUEST['sortby']) && $_REQUEST['sortby']!="")
	{
		$sortby = $_REQUEST['sortby'];
		if($sortby == "lowtohigh")
		{
			$orderby = " ORDER BY price ASC ";
		}
		else if($sortby == "hightolow")
		{
			$orderby = " ORDER BY price DESC ";
		}
		else if($sortby == "newest")
		{
			$orderby = " ORDER BY id DESC ";
		}
		else if($sortby == "oldest")
		{
			$orderby = " ORDER BY id ASC ";
		}
		else if($sortby == "bestselling")
		{
			$orderby = " ORDER BY best_selling ASC ";
		}
		else
		{
			$orderby = "";
		}
	}
	if(isset($_REQUEST['brand_id']) && $_REQUEST['brand_id']!="")
	{
		$brand_ids = $_REQUEST['brand_id'];
		for($i = 0; $i < count($brand_ids); $i++)
		{
			if($i==0)
			{
				$brand_id .= "'".$brand_ids[$i]."'";
			}
			else
			{
				$brand_id .= ','."'".$brand_ids[$i]."'";
			}
		}
		$addsubqry .= " AND brand_id IN ($brand_id) ";
	}
	if(isset($_REQUEST['price']) && $_REQUEST['price']!="")
	{
		$price = $_REQUEST['price'];
		$cntprice = count($price);
		for($a=0;$a<$cntprice;$a++)
		{
			if($price[$a]==1)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` <='499'";
				}
				else
				{
					$priceqry .= " or `price` <='499'";
				}
			}
			if($price[$a]==2)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` between 500 and 999";
				}
				else
				{
					$priceqry .= " or (`price` between 500 and 999)";
				}
			}
			if($price[$a]==3)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` between 1000 and 1499";
				}
				else
				{
					$priceqry .= " or (`price` between 1000 and 1499)";
				}
			}
			if($price[$a]==4)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` between 1500 and 1999";
				}
				else
				{
					$priceqry .= " or (`price` between 1500 and 1999)";
				}
			}
			if($price[$a]==4)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` >='2000' ";
				}
				else
				{
					$priceqry .= " or (`price` >='2000')";
				}
			}		
		}
		$priceqry =  " AND ( ".$priceqry.")";
	}
	/* pagination stat here */
	$pageno = 1;
	$pageshow = 15;
	if(isset($_REQUEST['pageno']) && ($_REQUEST['pageno']>0)) 
	{
		$pageno = $_REQUEST['pageno']; 
	}
	if(isset($_REQUEST['prodperpage']) && ($_REQUEST['prodperpage']>0)) 
	{
		$pageshow = $_REQUEST['prodperpage']; 
	}
	$query = "SELECT * FROM products WHERE sub_category_id = '$sub_category_id_categories' $addsubqry $priceqry AND status = 1 $orderby";
	$sql_query = $conn->query($query);
	if($TotalCnt = $sql_query->num_rows)
	{
		$total_page = ceil($TotalCnt/$pageshow); 
	}
	else
	{
		$total_page=0;
	}
	if(!isset($pageno) or $pageno==1)
	{
		$st=0;
		$pageno=1;
	}
	else
	{
		$st=($pageno*$pageshow)-$pageshow;
	}
	if($total_page>$pageno)
	{
		$nx=$pageno+1;
		$next='<li><a href="javascript:ShowPage('.$nx.')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
	}
	else
	{
		$next="";
	}
	if($pageno>1)
	{
		$pr=($pageno-1);
		$pre='<li><a href="javascript:ShowPage('.$pr.')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
	}
	else
	{
		$pre="";
	}
	$limitvar = "LIMIT $st,$pageshow";
	$query_listing = "SELECT * FROM products WHERE sub_category_id = '$sub_category_id_categories' $addsubqry $priceqry AND status = 1 $orderby $limitvar";
	$categories_listing = $conn->query($query_listing);
	$start_1 =($st+1);
	$start =$st;
	$end =($start+$pageshow);
	$page="";
	if($pageno <= 5)
	{
		$startpage = 1;
	}
	else
	{
		$startpage = $pageno-5;
	}
	if(($total_page - $pageno) <= 5)
	{
		$endpage = $total_page;
	}
	else
	{
		$endpage = $pageno+5;
	}
	for($i=$startpage;$i<=$endpage;$i++)
	{
		if($i==$pageno)
		{
			$page.='<li class="active"><a href="javascript:ShowPage('.$i.')">'.$i.'<span class="sr-only">(current)</span></a></li>';
		}
		else
		{
			$page.='<li><a href="javascript:ShowPage('.$i.')">'.$i.'<span class="sr-only">(current)</span></a></li>';		
		}
	}
}
else
{
	echo "<script>document.location.href='".$site_root."'</script>";
	exit;
}

include 'include/header.php';

?>
<script type="text/javascript" language="javascript">
function ShowPage(pageno)
{
	document.pageinfo.pageno.value=pageno;
	document.getElementById("pageinfo").action="<?php echo $pageaction;?>"+pageno+"/";
	document.forms["pageinfo"].submit();
}
</script>
<form name="pageinfo" id="pageinfo" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
	<input type="hidden" name="pageno" id="pageno" value="<?php echo $pageno; ?>" />
</form>
<div class="container"> 
  <!--container-->
  <div class="row"> 
    <!-- row-->
    <div class="col-md-3 col-sm-6">
      <div class="sidebar"> 
        <!-- sidebar-->
        <div class="filter">
          <div class="filter-head">
            <h4 class="cate-heading"> Filters </h4>
            <a class="flear-all" href="javascript:void(0)"> CLEAR ALL </a> </div>
        </div>
        <div class="side-box">
          <h4 class="cate-heading"> CATEGORIES</h4>
          <form>
            <label class="checkbox">Watches <span>(3582) </span>
              <input type="checkbox">
              <span class="checkmark ctg"></span> </label>
            <label class="checkbox">Watch Gift Set<span>(146) </span>
              <input type="checkbox">
              <span class="checkmark ctg"></span> </label>
            <label class="checkbox">Smart Watches <span>(74)</span>
              <input type="checkbox">
              <span class="checkmark"></span> </label>
            <label class="checkbox">Watch Organiser <span>(42) </span>
              <input type="checkbox">
              <span class="checkmark"></span> </label>
            <label class="checkbox">Fitness Bands<span>(34)</span>
              <input type="checkbox">
              <span class="checkmark"></span> </label>
          </form>
        </div>
        <div class="side-box">
          <h4 class="cate-heading"> PRICE</h4>
          <form>
            <label class="checkbox">Rs. <span>447</span> to Rs. <span>34636</span> <span>(3827)</span>
              <input type="checkbox">
              <span class="checkmark ctg"></span> </label>
            <label class="checkbox">Rs. <span>4427</span> to Rs.<span> 68636 </span> <span>(27)</span>
              <input type="checkbox">
              <span class="checkmark ctg"></span> </label>
            <label class="checkbox">Rs. <span>23589</span> to Rs. <span>68636</span> <span>(27)</span>
              <input type="checkbox">
              <span class="checkmark"></span> </label>
            <label class="checkbox">Rs. <span>10427</span> to Rs. <span>68636</span> <span>(235)</span>
              <input type="checkbox">
              <span class="checkmark"></span> </label>
          </form>
        </div>
      </div>
      <!-- sidebar end--> 
    </div>
    <div class="col-md-9 col-ms-6">
	<?php 
	if($categories_listing->num_rows>0) 
	{
		?>
      <div class="product-right">
        <div class="custom-bread">
          <ol class="breadcrumb">
            <li><a href="<?php echo $site_root; ?>">Home</a></li>
            <li><a href="<?php echo $site_root; ?>categories/<?php echo $newobject->getdata($conn,"categories","alias","id",$category_id_list); ?>"><?php echo $category_title; ?></a></li>
            <li class="active"> <?php echo $newobject->getdata($conn,"sub_categories","title","alias",$alias); ?></li>
          </ol>
          <span class="showing"> (Showing <?php echo $st; ?>-<?php echo $pageshow; ?> Products of <?php echo $TotalCnt; ?> product)</span> </div>
        
        <!-- new product filter start here -->
        <section class="main-sorts">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-2 col-sm-2 col-xs-12 width10">
                <div class="sort_by">
                  <label>Sort By</label>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="sort_options">
                  <select class="">
                    <option value="">Select</option>
                    <option value="manual">Featured</option>
                    <option value="price-ascending">Price: Low to High</option>
                    <option value="price-descending">Price: High to Low</option>
                    <option value="title-ascending">A-Z</option>
                    <option value="title-descending">Z-A</option>
                    <option value="created-ascending">Oldest to Newest</option>
                    <option value="created-descending">Newest to Oldest</option>
                    <option value="best-selling" selected="selected">Best Selling</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 col-sm-2 col-xs-12 width10">
                <div class="sort_by">
                  <label>Type </label>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="sort_options">
                  <select class="">
                    <option value="">Select</option>
                    <option value="Analog">Analog</option>
                    <option value="Digital">Digital</option>
                    <option value="Price: High to Low">Price: High to Low</option>
                    <option value="Analog-Digital">Analog-Digital</option>
                    <option value="Hbrid">Hbrid</option>
                    <option value="Smartwatch"  selected="selected">Smartwatch</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </section>
        
        <!-- new product filter start here -->
        
        <div class="products-section">
          <div class="row">
			<?php 
			while($categories_listing_result = $categories_listing->fetch_array(MYSQLI_ASSOC))
			{
				?>
            <div class="col-md-3 col-ms-4">
              <div class="product product-sec-item">
                <div class="product-image">
                  <div class="image"> <a href="product-detail.php"><img src="assets/images/products/man-watch/item1.jpg" alt="#"></a> </div>
                 
                </div>
                <div class="product-info text-left"> 
                  <h3 class="name"><a href="#">Zidax Copper twin shine...</a></h3>
                  <div class="product-price"> <span class="price"> ₹300 </span> <span class="price-before-discount"> ₹ 500</span> <span class="dis-off"> 80% Off </span> </div>
                  <div class="cat_ratings"> <a href="javascript:void(0)" class="exrates"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <span>100 Customer Ratings</span> </a>
                    <div class="custo_ratings">
                      <div class="thrats"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <span>4.5 Out Of 5</span>
                        <p>1,637 customer ratings</p>
                      </div>
                      <div class="ratings_progress">
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">5 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%"></div>
                          </div>
                          <div class="b_star col-xs-2">50%</div>
                        </div>
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">4 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:20%"></div>
                          </div>
                          <div class="b_star col-xs-2">20%</div>
                        </div>
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">3 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:10%"></div>
                          </div>
                          <div class="b_star col-xs-2">10%</div>
                        </div>
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">2 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width:5%"></div>
                          </div>
                          <div class="b_star col-xs-2">5%</div>
                        </div>
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">1 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width:15%"></div>
                          </div>
                          <div class="b_star col-xs-2">15%</div>
                        </div>
                        <hr class="hrsh">
                        <div class="showes_all"> <a href="javascript:void(0)">See all customer reviews <i class="fa fa-angle-right"></i></a> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<?php
			}
			?>
          </div>
        </div>
        <div class="custom-pagination">
          <div class="show-page"> Page <span>1</span> of <span> <?php echo $TotalCnt; ?> </span> </div>
          <ul class="pagination">
            <?php if($total_page>1) { echo $pre;?>&nbsp;<?php echo $page;?>&nbsp;<?php echo $next; } ?>
		  </div>
      </div>
		<?php
		}
		else
		{
			?>
			<div class="alert alert-danger" style="text-align:center; margin-top:50px;"><strong>There is no product in this category we are adding !</strong></div>
			<?php
		}
		?>
    </div>
  </div>
  <!--row end--> 
  
</div>
<!--container end-->
<?php include 'include/footer.php';?>