<?php 

include('config/function.php');

$search_id = "";

if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']!="")
{
	$keyword = mysqli_real_escape_string($conn, $_REQUEST['keyword']);
	$orderby = " ORDER BY id DESC";
	$pageaction = $site_root."search/";
	
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
		else if($sortby == "titlea")
		{
			$orderby = " ORDER BY title ASC ";
		}
		else if($sortby == "titled")
		{
			$orderby = " ORDER BY title DESC ";
		}
		else
		{
			$orderby = "";
		}
	}

	/* pagination stat here */

	$pageno = 1;
	$pageshow = 12;
	if(isset($_REQUEST['pageno']) && ($_REQUEST['pageno']>0)) 
	{
		$pageno = $_REQUEST['pageno']; 
	}
	if(isset($_REQUEST['prodperpage']) && ($_REQUEST['prodperpage']>0)) 
	{
		$pageshow = $_REQUEST['prodperpage']; 
	}
	$query = "SELECT * FROM products WHERE (title LIKE '%$keyword%') AND status = 1 $orderby";
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
		$next='<li><a href="javascript:ShowPage('.$nx.')" aria-label="Next"><span aria-hidden="true">Next</span></a></li>';
	}
	else
	{
		$next="";
	}
	if($pageno>1)
	{
		$pr=($pageno-1);
		$pre='<li><a href="javascript:ShowPage('.$pr.')" aria-label="Previous"><span aria-hidden="true">Previous</span></a></li>';
	}
	else
	{
		$pre="";
	}
	$limitvar = "LIMIT $st,$pageshow";
	$query_listing = "SELECT * FROM products WHERE (title LIKE '%$keyword%') AND status = 1 $orderby  $limitvar";
	$product_listing = $conn->query($query_listing);
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
<input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
<div class="container"> 
	<div class="row"> 
	<?php
	if($keyword!="") 
	{				
		if($product_listing->num_rows>0) 
		{
			?>
			<div class="col-md-12 col-ms-6">
			  <div class="product-right">
				<div class="custom-bread">
				  <ol class="breadcrumb">
					<li><a href="<?php echo $site_root; ?>">Home</a></li>
					<li class="active">Search</li>
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
						<select name="sortby" id="sortby" onchange="javascript:document.getElementById('pageinfo').submit();">
						  <option value="bestselling" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "bestselling") { echo "SELECTED"; } ?> >Best Selling</option>
						  <option value="lowtohigh" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "lowtohigh") { echo "SELECTED"; } ?> >Price - Low to High</option>
						  <option value="hightolow" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "hightolow") { echo "SELECTED"; } ?> >Price - High to Low</option>
						  <option value="newest" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "newest") { echo "SELECTED"; } ?> >Newest First</option>
						  <option value="oldest" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "oldest") { echo "SELECTED"; } ?> >Oldest First</option>
						  <option value="titlea" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "titlea") { echo "SELECTED"; } ?> >A - Z</option>
						  <option value="titled" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "titled") { echo "SELECTED"; } ?> >Z - A</option>
						</select>
						</div>
					  </div>
					</div>
				  </div>
				</section>
				</form>
				<!-- new product filter start here -->
				
				<div class="products-section">
				  <div class="row">
					<?php 
					while($categories_listing_result = $product_listing->fetch_array(MYSQLI_ASSOC))
					{
						?>
					<div class="col-md-3 col-ms-4">
					  <div class="product product-sec-item">
						<div class="product-image">
						<a href="<?php echo $site_root; ?>detail/<?php echo $categories_listing_result['alias']; ?>/"><img src="<?php echo $site_root; ?>uploads/products/<?php echo $categories_listing_result['image']; ?>" alt="#"></a>
						</div>
						<div class="product-info text-left"> 
						  <h3 class="name"><a href="<?php echo $site_root; ?>detail/<?php echo $categories_listing_result['alias']; ?>/"><?php echo $categories_listing_result['title']; ?></a></h3>
						  <div class="product-price"> <span class="price"> ₹<?php echo $categories_listing_result['sale_price']; ?> </span> <span class="price-before-discount"> ₹ <?php echo $categories_listing_result['price']; ?></span> <span class="dis-off"> <?php echo number_format((100 - ($categories_listing_result['sale_price'] * (100/$categories_listing_result['price']))),0); ?>% Off </span> </div>
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
				<div class="alert alert-danger" style="text-align:center; margin-top:50px;"><strong>There is no match found !</strong></div>
				<?php
			}
		}
		else
		{
			?>
			<div class="alert alert-danger" style="text-align:center; margin-top:50px;"><strong>Please Enter Search Keyword !</strong></div>
			<?php
		}
		?>
		</div>
	</div> 
</div>
<!--container end-->
<?php include 'include/footer.php';?>