<?php 

include('config/function.php');

$num = 0;
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))
{
	echo "<script>document.location.href='".$site_root."';</script>";
	exit;
}
else
{
	$query = "SELECT * FROM `orders` WHERE user_id = '".$_SESSION['user_id']."'";
	$sql_query_order = $conn->query($query);
	$num = $sql_query_order->num_rows;
}

include 'include/header.php';

if(isset($_REQUEST['submit_review']))
{
	/* echo "<pre>";
	print_r($_REQUEST);
	exit; */
	$order_id = $_REQUEST['order_id'];
	$product_id = $_REQUEST['product_id'];
	$reviews = $_REQUEST['reviews'];
	$rating = $_REQUEST['rating'];
	
	$query_update = "INSERT INTO reviews SET rating='".$rating."',product_id='".$product_id."',reviews='".$reviews."',order_id='".$order_id."',user_id='".$_SESSION['user_id']."',date=now()";
	if($sql_update=$conn->prepare($query_update))
	{
		$sql_update->execute();
		$news_response = "Submited Successfully !";
		echo "<script>popmsz('$news_response');</script>";
	}
}

if(isset($_REQUEST['cancel_order']))
{
	/* echo "<pre>";
	print_r($_REQUEST);
	exit; */
	$cancel_reason = $_REQUEST['cancel_reason'];
	$order_id = $_REQUEST['order_id'];
	
	$query_update = "UPDATE `orders` SET reason='".$cancel_reason."',status='Canceled' WHERE id='".$order_id."'";
	if($sql_update=$conn->prepare($query_update))
	{
		$sql_update->execute();
		$news_response = "Order Canceled Successfully !";
		echo "<script>popmsz('$news_response');</script>";
	}
}

if(isset($_REQUEST['return_order']))
{
	/* echo "<pre>";
	print_r($_REQUEST);
	exit; */
	$return_reason = $_REQUEST['return_reason'];
	$order_id = $_REQUEST['order_id'];
	
	$query_update = "UPDATE `orders` SET reason='".$return_reason."',status='Returned' WHERE id='".$order_id."'";
	if($sql_update=$conn->prepare($query_update))
	{
		$sql_update->execute();
		$news_response = "Returned Placed Successfully !";
		echo "<script>popmsz('$news_response');</script>";
	}
}

?>

<div class="body-content"> 
  <!-- /.body-content -->
  <div class="container">
    <div class="my-wishlist-page">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-12 ">
          <?php include 'include/left.php';?>
        </div>
        <div class="col-lg-9 col-md-8 col-12 my-wishlist my-order">
          <?php if($num>0) { ?>
			<?php
			while($result = $sql_query_order->fetch_array(MYSQLI_ASSOC))
			{
				$order_id = $result['id'];
				$nextWeeks = strtotime($result['order_date']) + (7 * 24 * 60 * 60);
				$nextWeek = date('d-F-Y', $nextWeeks);
				?>
				<div class="wishlistarea">
				<div class="orderheader">
				<div class="row">
				<div class="col-sm-6 col-xs-12">
				<h6>order placed <span><?php echo date("d-F-Y",strtotime($result['order_date'])); ?></span></h6>
				</div>
				<div class="col-sm-6 col-xs-12">
				<h6 class="pull-right">order status <span><?php echo $result['status']; ?></span></h6>
				</div>
				</div>
				</div>
				<div class="ordermain pb5">
				<div class="row">
				<div class="col-lg-9 col-md-8 col-xs-12">
				<ul class="myorderdelivered">
				<li> Delivered : <span>
				<?php  if($result['d_date']) { echo date("d-F-Y",strtotime($result['d_date'])); } else { echo "1 week expected"; } ?>
				</span> </li>
				<!--<li class="myordertxt"> Package was handed directly to the customer. </li>-->
				</ul>
				<?php
				$query = "SELECT * FROM `cart` WHERE order_id = '$order_id'";
				$sql_query = $conn->query($query);
				if($sql_query->num_rows>0)
				{
					while($result_cart = $sql_query->fetch_array(MYSQLI_ASSOC))
					{
						$pro_id = $result_cart['product_id'];
						$title = $newobject->getInfo($conn,"products","title",$pro_id);
						$image = $newobject->getInfo($conn,"products","image",$pro_id);
						$price = $newobject->getInfo($conn,"products","price",$pro_id);
						?>
						<div class="ordermain ordermainimg ">
						<div class="row">
						<div class="col-md-3 col-xs-12">
						<div class="wishlistitemimg"> <img src="<?php echo $site_root; ?>uploads/products/<?php echo $image; ?>" alt="imga"> </div>
						</div>
						<div class="col-md-9 col-xs-12">
						<div class="product-name"><a href="#"><?php echo $title; ?></a></div>
						<div class="price"> <i class="fa fa-rupee"></i><?php echo number_format($price,2); ?> </div>
						<div class="returntxt">Return window will be closed on <?php echo $nextWeek; ?></div>
						</div>
						</div>
						</div>
						<?php 
					}
				}
				?>
				</div>
				<div class="col-lg-3 col-md-4  col-xs-12">
				<div class="btnmyorder"> <a href="#" class="btn-upper btn btn-blues btn-default"data-toggle="modal" data-target="#modelReturn<?php echo $order_id; ?>">Return </a>
				<div class="modal fade model_design" id="modelReturn<?php echo $order_id; ?>" role="dialog">
				<div class="modal-dialog"> 
				<!-- Modal content-->
				<div class="modal-content">
				<div class="modal-header">
				<h4 class="modal-title">Return Order</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">

				<p>Write Your Reason</p>
				<form action="" method="post">
				<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
				<div class="form-group">
				<label for="comment">Reason:</label>
				<textarea class="form-control" rows="5" name="return_reason" required></textarea>
				</div>
				<button type="button" class="btn btn-border btn-blues"  data-dismiss="modal"> Cancel </button>
				<button type="submit" name="return_order" class="btn btn-blues">Submit</button>
				</form>
				</div>
				</div>
				</div>
				</div>
				<a href="#" class="btn-upper btn btn-default btn-blues" data-toggle="modal" data-target="#myModal<?php echo $order_id; ?>">Cancel Order </a>
				<div class="modal fade model_design" id="myModal<?php echo $order_id; ?>" role="dialog">
				<div class="modal-dialog"> 
				<!-- Modal content-->
				<div class="modal-content">
				<div class="modal-header">
				<h4 class="modal-title">Cancel Order</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
				<p>Write Your Reason</p>
				<form action="" method="post">
				<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
				<div class="form-group">
				<label for="comment">Reason:</label>
				<textarea class="form-control" rows="5" name="cancel_reason" required></textarea>
				</div>
				<button type="button" class="btn btn-border btn-blues"  data-dismiss="modal" > Cancel </button>
				<button type="submit" name="cancel_order" class="btn btn-blues">Submit</button>
				</form>
				</div>
				</div>
				</div>
				</div>
				<a href="#" class="btn-upper btn btn-default btn-blues mb0" data-toggle="modal" data-target="#myReview<?php echo $pro_id; ?>">Write A review</a>
				<div class="modal fade model_design" id="myReview<?php echo $pro_id; ?>" role="dialog">
				<div class="modal-dialog"> 
				<!-- Modal content-->
				<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
				<h4 class="">Write a Review</h4>
				<form action="" method="post">
				<input type="hidden" name="product_id" value="<?php echo $pro_id; ?>">
				<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
				<input type="hidden" name="product_id" value="<?php echo $pro_id; ?>">
				<select class="form-control" name="rating" required>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				</select>
				<div class="form-group">
				<label for="comment">Review:</label>
				<textarea class="form-control" rows="5" name="reviews"></textarea>
				</div>
				<button type="button" class="btn btn-border btn-blues" data-dismiss="modal"> Cancel </button>
				<button type="submit" name="submit_review" class="btn btn-blues">Submit</button>
				</form>
				</div>
				</div>
				</div>
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
        <?php } else { ?>
        <div class="alert alert-danger" style="text-align:center; margin-top:25px;"><strong>There is no orders yet !</strong></div>
        <?php } ?>
      </div>
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.sigin-in--> 
</div>
</div>
<!-- Modal -->
<?php include 'include/footer.php';?>
