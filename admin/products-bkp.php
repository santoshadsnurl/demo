<?php
	
include('session.php');

/* set variable */
$pagename = "Product";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$category_id = "";
$category_id = "";
$sub_category_id = "";
$sub_sub_category_id = "";
$brand_id = "";
$title = "";
$alias = "";
$price = "";
$heading = "";
$quantity = "";
$image = "";
$alt_tag = "";
$heading = "";
$sku = "";
$sale_price = "";
$status = "";
$popular = 0;
$quantity = 0;
$short_description = "";
$overview = "";
$specifications = "";
$meta_title = "";
$meta_keyword = "";
$meta_description = "";

/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
/* 	echo "<pre>";
	print_r($_REQUEST);
	print_r($_FILES);
	echo "</pre>";
	//exit; */
	$title = addslashes(ucwords(trim($_POST['title'])));
	$alias = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($title))));
	$alt_tag = addslashes(ucwords(trim($_POST['alt_tag'])));
	$sub_sub_category_id = $_POST['sub_sub_category_id'];
	$category_id = $_POST['category_id'];
	$sub_category_id = $newobject->getdata($conn,"sub_sub_categories","sub_category_id","sub_sub_category_id",$sub_sub_category_id);
	$brand_id = $_POST['brand_id'];
	$price = $_POST['price'];
	$sku = $_POST['sku'];
	$heading = $_POST['heading'];
	$quantity = $_POST['quantity'];
	$sale_price = $_POST['sale_price'];
	$short_description = $_POST['short_description'];
	$overview = $_POST['overview'];
	$specifications = $_POST['specifications'];
	$meta_title = addslashes(ucwords(trim($_POST['meta_title'])));
	$meta_keyword = addslashes(trim($_POST['meta_keyword']));
	$meta_description = addslashes(trim($_POST['meta_description']));
	if(!empty($_POST['popular'])) { $popular=1; } else{ $popular=0;	}
	
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM products WHERE title='".$title."' $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		if($sql_duplicate->num_rows>0)
		{
			$msg = "This Title is already exist, please try with another.";
		}
		else
		{
			if($id!="")
			{
				$query_update="UPDATE products SET title='".$title."',heading='".$heading."',quantity='".$quantity."',category_id='".$category_id."',sub_category_id='".$sub_category_id."',sub_sub_category_id='".$sub_sub_category_id."',popular='".$popular."',brand_id='".$brand_id."',sku='".$sku."',sale_price='".$sale_price."',short_description='".$short_description."',overview='".$overview."',price='".$price."',specifications='".$specifications."',alt_tag='".$alt_tag."',alias='".$alias."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO products SET title='".$title."',heading='".$heading."',quantity='".$quantity."',category_id='".$category_id."',sub_category_id='".$sub_category_id."',sub_sub_category_id='".$sub_sub_category_id."',brand_id='".$brand_id."',popular='".$popular."',sku='".$sku."',sale_price='".$sale_price."',short_description='".$short_description."',overview='".$overview."',specifications='".$specifications."',price='".$price."',status=1,alt_tag='".$alt_tag."',alias='".$alias."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."'";
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
				}				
			}
			if(isset($_FILES['image']) && $_FILES['image']['error']==0)
			{
				$productimage = $_FILES['image']['name'];
				$time =time();
				$productimage = $time.$productimage;
				$productimagename = "";
				if($id!="")
				{
					$productimagename = $newobject->getInfo($conn,"products","image",$id);
				}
				if($productimagename!="")
				{
					$unlkheaderfile = "../uploads/products/".$productimagename;
					if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
				}
				$productfilename = "../uploads/products/". $productimage;
				$mv =move_uploaded_file($_FILES['image']['tmp_name'],$productfilename);
				$query_imageup="UPDATE products SET image='".$productimage."' WHERE id='".$id."'";
				if($sql_imageup=$conn->prepare($query_imageup))
				$sql_imageup->execute();
			}
			if(isset($_POST['product_alt_tag']) && $_POST['product_alt_tag']!="")
			{
				$product_alt_tag = $_REQUEST['product_alt_tag'];
				$total = count($product_alt_tag);
				for($i=0; $i<$total; $i++)
				{
					//Get the temp file path
					$tmpFilePath = $_FILES['product_image']['tmp_name'][$i];
					//Make sure we have a filepath
					if ($tmpFilePath != "")
					{
						//Setup our new file path
						$newFilePath = "../uploads/product_images/".$_FILES['product_image']['name'][$i];
						//Upload the file into the temp dir
						if(move_uploaded_file($tmpFilePath, $newFilePath)) 
						{
							//Handle other code here
							$query_insert = "INSERT INTO product_images SET product_id = '".$id."',product_image='".$_FILES['product_image']['name'][$i]."',product_alt_tag='".$product_alt_tag[$i]."'";
							if($sql_insert = $conn->prepare($query_insert))
							{
								$sql_insert->execute();
								$_SESSION['response'] = $pagename." Added Successfully.";
							}
						}
					}
					
				}
			}
			echo "<script>document.location.href='products_mgmt.php';</script>";
			exit;
		}
	}
}

/* Listing  */
if($id!="")
{
    $query_select="SELECT * FROM products WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$title = stripslashes($result['title']);
			$alt_tag = stripslashes($result['alt_tag']);
			$status = $result['status'];
			$sub_sub_category_id = stripslashes($result['sub_sub_category_id']);
			$category_id = stripslashes($result['category_id']);
			$brand_id = $result['brand_id'];
			$short_description = $result['short_description'];
			$price = $result['price'];
			$sku = $result['sku'];
			$quantity = $result['quantity'];
			$heading = $result['heading'];
			$sale_price = $result['sale_price'];
			$popular = $result['popular'];
			$overview = $result['overview'];
			$specifications = $result['specifications'];
			$meta_title = stripslashes($result['meta_title']);
			$meta_keyword = stripslashes($result['meta_keyword']);
			$meta_description = stripslashes($result['meta_description']);
			$image = $result['image'];
			$pagetaskname = " Update ";
		}
		else
		{
			echo "<script>document.location.href='products_mgmt.php';</script>";
			exit;
		}
    }
}

?>

<!DOCTYPE HTML>
<html>

<head>
<?php include('includes/head.php'); ?>
<script language="javascript">
function getHTTPObject() 
{
	var xmlhttp;
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined')
	{
		try
		{
			xmlhttp = new XMLHttpRequest();
		}
		catch (e)
		{
			xmlhttp = false;
		}
	}
	return xmlhttp;
}
var http = getHTTPObject(); // We create the HTTP Object]

function handleHttpResponse5()
{
	//alert(http.readyState);
	if (http.readyState == 4)
	{
		//alert(http.responseText);
		document.getElementById('refdiv').innerHTML= http.responseText; //loads the result
	}
}

function getreference(sub_sub_category_id)
{
	//alert(sub_sub_category_id);
	var url2 = "load_sub_sub_category.php?"; // The server-side script
	http.open("GET",url2+"sub_sub_category_id="+sub_sub_category_id, true);
	//alert(http.open);
	http.onreadystatechange = handleHttpResponse5;
	http.send();
}

</script>
<script type="text/javascript">
$(document).ready(function()
{
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><div class="row"><div class="col-sm-6"><div class="form-group"><input type="file" id="product_image" name="product_image[]" placeholder="Image" class="form-control" value=""/></div></div><div class="col-sm-6"><div class="form-group"><div class="required" style="margin-bottom:-10px;"><input type="text" id="product_alt_tag" name="product_alt_tag[]" placeholder="Alt Tag" class="form-control" value=""/></div></div></div></div><div style="clear:both"></div><a href="javascript:void(0);" class="remove_button" title="Remove field">Remove</a><div style="clear:both"></div></div>'; //New input field html 
	var x = 1; //Initial field counter is 1
	$(addButton).click(function(){ //Once add button is clicked
		if(x < maxField){ //Check maximum number of input fields
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
});
</script>
<style type="text/css">
.field_wrapper div{ margin-bottom:10px;}
.add_button{
    font-weight: 400;
    margin: 5px 0;
    padding: 5px 15px;
    background-color: #1F67A2;
    margin: 5px 0;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    -moz-border-radius: 5px;
    border: none;
    margin: 25px 0;
}
.remove_button{
    font-weight: 400;
    margin: 5px 0;
    padding: 5px 15px;
    background-color: #1F67A2;
    margin: 5px 0;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    -moz-border-radius: 5px;
    border: none;
	margin: 0px 0;
    display: block;
    cursor: pointer;
    width: 100px;
}
</style>
</head>

<body>

<!-- header section start here -->
<?php include('includes/header.php'); ?>
<!-- end here --> 

<!-- Two section start here -->
<div class="container-fluid">
	<div class="left-section">
		<?php include('includes/catelog-left.php'); ?>
	</div>
	<div class="right-section">
		<div class="dashboard-bar">
		<h2 class="headn-h2">Catalog</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-md-6 col-lg-offset-3 col-xs-12">
				<div class="panel panel-default">
					<?php if($msg!="") { ?> 
					<div class="alert alert-danger fade in f">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $msg; ?>
					</div>
					<?php } ?>
					<div class="panel-heading">
					<h3 class="panel-title">Products</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="products" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleInputEmail1">Product Name</label>
								<input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Product SKU</label>
								<input type="text" class="form-control" id="sku" name="sku" value="<?php echo $sku; ?>">
							</div>
							<div class="form-group">
								<label>Sub Sub Category</label>
								<select name="sub_sub_category_id" id="sub_sub_category_id" class="form-control" onchange="getreference(this.value)">
								<option value="">--Select--</option>
								<?php
								$query = "SELECT * FROM sub_sub_categories WHERE status=1 ORDER BY order_no ASC";
								if($stmt = $conn->query($query))
								{
									while($r = $stmt->fetch_array(MYSQLI_ASSOC))
									{
										?>
										<option value="<?php echo $r['sub_sub_category_id'];?>" <?php if($r["sub_sub_category_id"]==$sub_sub_category_id) { echo "selected"; } ?>><?php echo ucwords($r['title']);?></option> 	
										<?php 
									} 
								} 
								?>
								</select>
							</div>
							<div class="form-group">
								<label>Category</label>
								<div id="refdiv">
								<select name="category_id" id="category_id" class="form-control">
								<option value="">--Select--</option>
								<?php
								$query = "SELECT * FROM categories WHERE status=1 ORDER BY order_no ASC";
								if($stmt = $conn->query($query))
								{
									while($r = $stmt->fetch_array(MYSQLI_ASSOC))
									{
										?>
										<option value="<?php echo $r['category_id'];?>" <?php if($r["category_id"]==$category_id) { echo "selected"; } ?>><?php echo ucwords($r['title']);?></option> 	
										<?php 
									} 
								} 
								?>
								</select>
								</div>
							</div>
							<div class="form-group">
								<label>Brand</label>
								<select name="brand_id" id="brand_id" class="form-control">
								<option value="">--Select--</option>
								<?php
								$query = "SELECT * FROM brands WHERE status = 1 ORDER BY id DESC";
								if($stmt = $conn->query($query))
								{
									while($r = $stmt->fetch_array(MYSQLI_ASSOC))
									{
										$slect_brand = $r["brand_id"];
										?>
										<option value="<?php echo $r['brand_id'];?>" <?php if($slect_brand==$brand_id) { echo "selected"; } ?>><?php echo ucwords($r['title']);?></option> 	
										<?php 
									} 
								} 
								?>
								</select>
							</div>
							<div class="form-group">
								<label>Heading</label>
								<input type="text" class="form-control" id="heading" name="heading" value="<?php echo $heading; ?>">
							</div>
							<div class="form-group">
								<label>Quantity</label>
								<input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo $quantity; ?>">
							</div>
							<div class="form-group">
								<label>Price</label>
								<input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
							</div>
							<div class="form-group">
								<label>Sale Price</label>
								<input type="text" class="form-control" id="sale_price" name="sale_price" value="<?php echo $sale_price; ?>">
							</div>
							<div class="form-group">
								<label>Popular</label><br/>
								<input type="radio" name="popular" value="1" <?php if($popular=="1") { echo "checked"; } ?> />Yes
								<input type="radio" name="popular" value="0" <?php if($popular== "0") { echo "checked"; } ?> />No
					        </div>
							<div class="row">
								<?php if($image!="") { ?>
								<div class="col-sm-12">									
									<div class="form-group">
									<img src="../uploads/products/<?php echo $result['image']?>" alt="<?php echo $title; ?>" height="100" width="120" title="<?php echo $title; ?> Image">
									</div>									
								</div>
								<?php } ?>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Featured Images</label>
										<input class="btn btn-default" type="file" id="image" name="image" value="<?php echo $result['image']?>"/>
										<span class="red" style="color:red;"><font size="2" width="bold">[ Size : 448*448 ]</font></span>	
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Alt Tag</label>
								<input type="text" class="form-control" id="alt_tag" name="alt_tag" value="<?php echo $alt_tag; ?>">
							</div>
							<?php 
							$select_product_images = "SELECT * FROM product_images WHERE product_id = '$id'";
							if($sql_product_images = $conn->query($select_product_images))
							{
								if($sql_product_images->num_rows>0)
								{
									?>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label for="exampleInputEmail1">Other Images</label>
												<div class="field_wrapper">
													<div class="row">
													<?php
													while($result_product_images = $sql_product_images->fetch_array(MYSQLI_ASSOC))
													{
														?>
														<div class="col-sm-6">
															<div class="form-group">
																<img src="../uploads/product_images/<?php echo $result_product_images['product_image']; ?>"  height="100" width="120">
															</div>
															<div style="margin-top:20px; width: 120px; text-align: center;">
																<a href="delete.php?id=<?php echo $result_product_images['id'];?>" class="form-control"  onClick="return confirm('Are you sure to delete?');" style="background-color:#1F67A2;color:#fff;">Delete</a> 
															</div>
														</div>
														<?php 
													}
													?>
													</div>											
												</div>							
											</div>
										</div>
									</div>
									<?php
								}
								else
								{
									?>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label for="exampleInputEmail1">Other Images</label>
												<div class="field_wrapper">
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<input type="file" id="product_image" name="product_image[]"  placeholder="Image" class="form-control" value=""/>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<div class="required" style="margin-bottom:-10px;">
																	<input type="text" id="product_alt_tag" name="product_alt_tag[]" placeholder="Alt Tag" class="form-control" value=""/>
																</div>
															</div>
														</div>
													</div>
													<div style="clear:both"></div>
													<a href="javascript:void(0);" class="add_button" title="Add field">Add More</a>
													<div style="clear:both"></div>
												</div>							
											</div>
										</div>
									</div>
									<?php
								}
							}
							?>
							<div class="row">
								<label for="exampleInputEmail1">Short Description</label>
								<textarea name="short_description" id="short_description" class="form-control ckeditor" rows="8" ><?php echo $short_description; ?></textarea>
							</div>
							<div class="row">
								<label for="exampleInputEmail1">Overview</label>
								<textarea name="overview" id="overview" class="form-control ckeditor" rows="8" ><?php echo $overview; ?></textarea>
							</div>
							<div class="row">
								<label for="exampleInputEmail1">Specifications</label>
								<textarea name="specifications" id="specifications" class="form-control ckeditor" rows="8" ><?php echo $specifications; ?></textarea>
							</div>
							<div class="form-group">
								<label>Meta Title</label>
								<input type="text" class="form-control" id="meta_title" name="meta_title" value="<?php echo $meta_title; ?>">
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Meta Keyword</label>
										<textarea name="meta_keyword" id="meta_keyword" class="form-control" rows="4" ><?php echo $meta_keyword; ?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Meta Description</label>
										<textarea name="meta_description" id="meta_description" class="form-control" rows="4" ><?php echo $meta_description; ?></textarea>
									</div>
								</div>
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="products_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="lib/ToggleSwitch.css"/>
<script src="lib/ToggleSwitch.js"></script>
<script>
	$(function(){
		$("#status").toggleSwitch();
		$("#myonoffswitch2").toggleSwitch();
	});
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'https://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>

<script>

var Id = "<?php echo $id;?>";

if(Id == "")

{

	$("#products").validate(

	{

		rules: 
		{

			title: 
			{ 
				required:true,
			},
			brand_id: 
			{ 
				required:true,
			},
			sku: 
			{ 
				required:true,
			},
			sub_sub_category_id: 
			{ 
				required:true,
			},
			category_id: 
			{ 
				required:true,
			},
			price: 
			{ 
				required:true,
			},
			quantity: 
			{ 
				required:true,
			},
			heading: 
			{ 
				required:true,
			},
			image: 
			{
				required:true,
			},

		},

		messages: {

					 title:{required:"Please Enter Title."},
					 image:{required:"Please Enter Image."},
					 sub_sub_category_id:{required:"Please Select Sub Sub Category."},
					 category_id:{required:"Please Select Category."},
					 brand_id:{required:"Please Enter Brands ID."},
					 sku:{required:"Please Enter SKU."},
					 quantity:{required:"Please Enter Quantity."},
					 heading:{required:"Please Enter Heading."},
					 price:{required:"Please Enter Price."},

			   }

	});

}

else

{

	$("#products").validate(

	{

		rules: 

		{

			title: 
			{ 

				required:true,

			},
			brand_id: 
			{ 
				required:true,
			},
			order_no: 
			{ 
				required:true,
			},
			sub_sub_category_id: 
			{ 
				required:true,
			},
			category_id: 
			{ 
				required:true,
			},
			sku: 
			{ 
				required:true,
			},
			heading: 
			{ 
				required:true,
			},
			quantity: 
			{ 
				required:true,
			},
			price: 
			{ 
				required:true,
			},

		},

		messages: {

					 title:{required:"Please Enter Title."},
					 brand_id:{required:"Please Enter Brands ID."},
					sku:{required:"Please Enter SKU."},
					heading:{required:"Please Enter Heading."},
					quantity:{required:"Please Enter Quantity."},
					category_id:{required:"Please Select Category."},
					sub_sub_category_id:{required:"Please Select Sub Sub Category."},
					price:{required:"Please Enter Price."},

			   }

	});

}

</script>

</body>
</html>
