<?php
include('session.php');
/* set variable */
$pagename = "Product";
$pagetaskname = " Add ";
/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$size = "";
$color = "";
$sizes = "";
$colors = "";
$material = "";
$materials = "";
$department = "";
$departments = "";
$fitment_type = "";
$fitment_types = "";
$style = "";
$styles = "";
$category_id = "";
$sub_category_id = 0;
$sub_sub_category_id = 0;
$brand_id = "";
$title = "";
$arabic_title = "";
$alias = "";
$sale_price = "";
$price = "";
$quantity = "";
$sku = "";
$hsn = "";
$order_no = "";
$image = "";
$alt_tag = "";
$status = "";
$sale = 0;
$hot = 0;
$sale_price = "";
$quantity = 0;
$special_price = 0;
$description = "";
$specification = "";
$care_instructions = "";
$questions = "";
$p_dimension = "";
$p_weight = "";
$arabic_description = "";
$meta_title = "";
$arabic_meta_title = "";
$meta_keyword = "";
$meta_description = "";
$sizes = array();
$fitment_types = array();
$styles = array();
$departments = array();
$materials = array();
$colors = array();
/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}
if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	/* echo "<pre>";
	print_r($_REQUEST);
	print_r($_FILES);
	echo "</pre>";
	exit; */
	$title = addslashes($_POST['title']);
	$alias = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($title))));
	$alt_tag = addslashes($_POST['alt_tag']);
	$category_id = $_POST['category_id'];
	if(isset($_POST['sub_category_id']) && $_POST['sub_category_id']!="")
	{
		$sub_category_id = $_POST['sub_category_id'];
	}
	if(isset($_POST['sub_sub_category_id']) && $_POST['sub_sub_category_id']!="")
	{
		$sub_sub_category_id = $_POST['sub_sub_category_id'];
	}
	$price = $_POST['price'];
	$special_price = $_POST['special_price'];
	$hot = $_POST['hot'];
	$sale_price = $_POST['sale_price'];
	$quantity = $_POST['quantity'];
	$p_dimension = $_POST['p_dimension'];
	$p_weight = $_POST['p_weight'];
	$description = htmlentities(addslashes($_POST['description']));
	$specification = htmlentities(addslashes($_POST['specification']));
	$care_instructions = htmlentities(addslashes($_POST['care_instructions']));
	$questions = htmlentities(addslashes($_POST['questions']));
	$arabic_title = htmlentities(addslashes($_POST['arabic_title']));
	$arabic_description = htmlentities(addslashes($_POST['arabic_description']));
	$sku = $_POST['sku'];
	$hsn = $_POST['hsn'];
	if(isset($_REQUEST['size']) && $_REQUEST['size']!="")
	{
		$size = implode(",",$_REQUEST['size']);
		$size = ",product_size='".$size."'";
	}
	if(isset($_REQUEST['color']) && $_REQUEST['color']!="")
	{
		$color = implode(",",$_REQUEST['color']);
		$color = ",product_color='".$color."'";
	}
	if(isset($_REQUEST['material']) && $_REQUEST['material']!="")
	{
		$material = implode(",",$_REQUEST['material']);
		$material = ",product_material='".$material."'";
	}
	if(isset($_REQUEST['department']) && $_REQUEST['department']!="")
	{
		$department = implode(",",$_REQUEST['department']);
		$department = ",product_department='".$department."'";
	}
	if(isset($_REQUEST['style']) && $_REQUEST['style']!="")
	{
		$style = implode(",",$_REQUEST['style']);
		$style = ",product_style='".$style."'";
	}
	if(isset($_REQUEST['fitment_type']) && $_REQUEST['fitment_type']!="")
	{
		$fitment_type = implode(",",$_REQUEST['fitment_type']);
		$fitment_type = ",product_fitment_type='".$fitment_type."'";
	}
	$meta_title = addslashes(ucwords(trim($_POST['meta_title'])));
	$meta_keyword = addslashes(trim($_POST['meta_keyword']));
	$meta_description = addslashes(trim($_POST['meta_description']));
	if(isset($_POST['sale']) && $_POST['sale']!="") { $sale=1; } else{ $sale=0;	}
	if(isset($_POST['hot']) && $_POST['hot']!="") { $hot=1; } else{ $hot=0;	}
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM products WHERE (title='".$title."' OR id='".$id."') $checkDuplicate";
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
				$query_update="UPDATE products SET title='".$title."',arabic_title='".$arabic_title."',hsn='".$hsn."',sku='".$sku."',hot='".$hot."',arabic_description='".$arabic_description."',quantity='".$quantity."',category_id='".$category_id."'$size$color$material$department$style$fitment_type,sale_price='".$sale_price."',special_price='".$special_price."',sub_category_id='".$sub_category_id."',sub_sub_category_id='".$sub_sub_category_id."',p_dimension='".$p_dimension."',p_weight='".$p_weight."',brand_id='".$brand_id."',description='".$description."',specification='".$specification."',care_instructions='".$care_instructions."',questions='".$questions."',price='".$price."',alt_tag='".$alt_tag."',alias='".$alias."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert = "INSERT INTO products SET title='".$title."',hsn='".$hsn."',sku='".$sku."',hot='".$hot."',arabic_title='".$arabic_title."',arabic_description='".$arabic_description."'$size$color$material$department$style$fitment_type,quantity='".$quantity."',sale_price='".$sale_price."',special_price='".$special_price."',category_id='".$category_id."',sub_category_id='".$sub_category_id."',sub_sub_category_id='".$sub_sub_category_id."',p_dimension='".$p_dimension."',p_weight='".$p_weight."',brand_id='".$brand_id."',description='".$description."',price='".$price."',specification='".$specification."',care_instructions='".$care_instructions."',questions='".$questions."',alt_tag='".$alt_tag."',alias='".$alias."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."'";
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
				$productimage = preg_replace("/[^-a-zA-Z0-9s]+/", "", strtolower(trim($productimage)));
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
				$mv = move_uploaded_file($_FILES['image']['tmp_name'],$productfilename);
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
					$product_image = $_FILES['product_image']['name'][$i];
					$time = time();
					$product_image = $time.$product_image;
					//Make sure we have a filepath
					if ($tmpFilePath != "")
					{
						//Setup our new file path
						$newFilePath = "../uploads/product_images/".$product_image;
						//Upload the file into the temp dir
						if(move_uploaded_file($tmpFilePath, $newFilePath)) 
						{
							//Handle other code here
							$query_insert = "INSERT INTO product_images SET product_id = '".$id."',product_image='".$product_image."',product_alt_tag='".$product_alt_tag[$i]."'";
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
			$category_id = stripslashes($result['category_id']);
			$sub_category_id = stripslashes($result['sub_category_id']);
			$sub_sub_category_id = stripslashes($result['sub_sub_category_id']);
			$brand_id = $result['brand_id'];
			$description = $result['description'];
			$specification = $result['specification'];
			$care_instructions = $result['care_instructions'];
			$questions = $result['questions'];
			$price = $result['price'];
			$sale_price = $result['sale_price'];
			$special_price = $result['special_price'];
			$quantity = $result['quantity'];
			$arabic_title = $result['arabic_title'];
			$sku = $result['sku'];
			$hsn = $result['hsn'];
			$hot = $result['hot'];
			$p_dimension = $result['p_dimension'];
			$p_weight = $result['p_weight'];
			$arabic_description = $result['arabic_description'];
			$meta_title = stripslashes($result['meta_title']);
			$meta_keyword = stripslashes($result['meta_keyword']);
			$meta_description = stripslashes($result['meta_description']);
			$sizes = explode(',', $result['product_size']);
			$colors = explode(',', $result['product_color']);
			$materials = explode(',', $result['product_material']);
			$departments = explode(',', $result['product_department']);
			$styles = explode(',', $result['product_style']);
			$fitment_types = explode(',', $result['product_fitment_type']);
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
function handleHttpResponse6()
{
	//alert(http.readyState);
	if (http.readyState == 4)
	{
		//alert(http.responseText);
		document.getElementById('refdivsub').innerHTML= http.responseText; //loads the result
	}
}
function getreference(category_id)
{
	//alert(category_id);
	var url2 = "load_category.php?"; // The server-side script
	http.open("GET",url2+"category_id="+category_id, true);
	//alert(http.open);
	http.onreadystatechange = handleHttpResponse5;
	http.send();
}
function getsubsubcat(sub_category_id)
{
	//alert(sub_category_id);
	var url2 = "load_sub_category.php?"; // The server-side script
	http.open("GET",url2+"sub_category_id="+sub_category_id, true);
	//alert(http.open);
	http.onreadystatechange = handleHttpResponse6;
	http.send();
}
</script>
<script type="text/javascript">
$(document).ready(function()
{
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><div class="row"><div class="col-sm-6"><div class="form-group"><input type="file" id="product_image" name="product_image[]" placeholder="Image" class="form-control" value=""/><span class="red" style="color:red;"><font size="2" width="bold">[ Size : 427*985 ]px</font></span></div></div><div class="col-sm-6"><div class="form-group"><div class="required"><input type="text" id="product_alt_tag" name="product_alt_tag[]" placeholder="Alt Tag" class="form-control" value=""/></div></div></div></div><div style="clear:both"></div><a href="javascript:void(0);" class="remove_button" title="Remove field">Remove</a><div style="clear:both"></div></div>'; //New input field html 
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
<script type="text/javascript">
$(document).ready(function()
{
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button_size'); //Add button selector
	var wrapper = $('.field_wrapper_size'); //Input field wrapper
	var fieldHTML = '<div><div class="row" style="margin-top:10px;"><div class="col-sm-6"><div class="form-group"><input type="text" id="product_size" name="product_size[]" placeholder="Size" class="form-control" value=""/></div></div><div class="col-sm-6"><div class="form-group"><div class="required"><input type="text" id="product_price" name="product_price[]" placeholder="Price" class="form-control" value=""/></div></div></div></div><div style="clear:both"></div><a href="javascript:void(0);" class="remove_button" title="Remove field">Remove</a><div style="clear:both"></div></div>'; //New input field html 
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
.field_wrapper div { margin-bottom:10px; }
.add_button { font-weight: 400; margin: 5px 0; padding: 5px 15px; background-color: #1F67A2; margin: 5px 0; color: #ffffff; border: none; border-radius: 5px; -moz-border-radius: 5px; border: none; margin: 25px 0; }
.remove_button { font-weight: 400; margin: 5px 0; padding: 5px 15px; background-color: #1F67A2; margin: 5px 0; color: #ffffff; border: none; border-radius: 5px; -moz-border-radius: 5px; border: none; margin: 0px 0; display: block; cursor: pointer; width: 100px; }
</style>
<style type="text/css">
.field_wrapper div { margin-bottom:10px; }
.add_button_size { font-weight: 400; margin: 5px 0; padding: 5px 15px; background-color: #1F67A2; margin: 5px 0; color: #ffffff; border: none; border-radius: 5px; -moz-border-radius: 5px; border: none; margin: 25px 0; }
.remove_button { font-weight: 400; margin: 5px 0; padding: 5px 15px; background-color: #1F67A2; margin: 5px 0; color: #ffffff; border: none; border-radius: 5px; -moz-border-radius: 5px; border: none; margin: 0px 0; display: block; cursor: pointer; width: 100px; }
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
          <div class="alert alert-danger fade in f"> <a href="#" class="close" data-dismiss="alert">&times;</a> <?php echo $msg; ?> </div>
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
                <label for="exampleInputEmail1">Heading</label>
                <input type="text" class="form-control" id="arabic_title" name="arabic_title" value="<?php echo $arabic_title; ?>">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Part Number</label>
                <input type="text" class="form-control" id="sku" name="sku" value="<?php echo $sku; ?>">
              </div>
			  <div class="form-group">
                <label for="exampleInputEmail1">HSN</label>
                <input type="text" class="form-control" id="hsn" name="hsn" value="<?php echo $hsn; ?>">
              </div>
              <div class="form-group">
                <label>Deal of the day</label>
                <br/>
                <input type="radio" class="showall2" id="chkYes"  name="hot" value="1" <?php if($hot == 1) { echo "checked"; } ?> />
                Yes
                <input type="radio" name="hot"  id="chkNo"  value="0" <?php if($hot == 0) { echo "checked"; } ?> />
                No </div>
                    <div class="form-group boxhide" id="dvPinNo" style="display: none"> 
                <label>Special Price</label>
                <input type="text" class="form-control" id="special_price" name="special_price" value="<?php echo $special_price; ?>">
              </div>
              <div class="form-group">
                <label>Category</label>
                <select name="category_id" id="category_id" class="form-control" onchange="getreference(this.value)">
                  <option value="">--Select--</option>
                  <?php
								$query = "SELECT * FROM categories WHERE status = 1 ORDER BY id DESC";
								if($stmt = $conn->query($query))
								{
									while($r = $stmt->fetch_array(MYSQLI_ASSOC))
									{
									?>
                  <option value="<?php echo $r['id'];?>" <?php if($r["id"]==$category_id) { echo "selected"; } ?>><?php echo ucwords($r['title']);?></option>
                  <?php 
									} 
								} 
								?>
                </select>
              </div>
              <div class="form-group">
                <label>Sub Category</label>
                <div id="refdiv">
                  <select name="sub_category_id" id="sub_category_id" class="form-control">
                    <option value="">--Select--</option>
                    <?php
									if($category_id!="")
									{
										$catstr = "AND category_id='$category_id'";
									}
									$query = "SELECT * FROM sub_categories WHERE status = 1 $catstr ORDER BY id DESC";
									if($stmt = $conn->query($query))
									{
										while($r = $stmt->fetch_array(MYSQLI_ASSOC))
										{
										?>
                    <option value="<?php echo $r['id'];?>" <?php if($r["id"]==$sub_category_id) { echo "selected"; } ?>><?php echo ucwords($r['title']);?></option>
                    <?php 
										} 
									} 
									?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label>Sub Sub Category</label>
                <div id="refdivsub">
                  <select name="sub_sub_category_id" id="sub_sub_category_id" class="form-control">
                    <option value="">--Select--</option>
                    <?php
									if($sub_category_id!="")
									{
										$subcatstr = "AND sub_category_id='$sub_category_id'";
									}
									$query = "SELECT * FROM sub_sub_categories WHERE status = 1 $subcatstr ORDER BY id DESC";
									if($stmt = $conn->query($query))
									{
										while($r = $stmt->fetch_array(MYSQLI_ASSOC))
										{
										?>
                    <option value="<?php echo $r['id'];?>" <?php if($r["id"]==$sub_sub_category_id) { echo "selected"; } ?>><?php echo ucwords($r['title']);?></option>
                    <?php 
										} 
									} 
									?>
                  </select>
                </div>
              </div>
              <!--<div class="form-group">
								<label>Brand</label>
								<select name="brand_id" id="brand_id" class="form-control">
								<option value="">--Select--</option>
								<?php
								$query = "SELECT * FROM brands WHERE status = 1 ORDER BY id DESC";
								if($stmt = $conn->query($query))
								{
									while($r = $stmt->fetch_array(MYSQLI_ASSOC))
									{
										$slect_brand = $r["id"];
										?>
										<option value="<?php echo $r['id'];?>" <?php if($slect_brand==$brand_id) { echo "selected"; } ?>><?php echo ucwords($r['title']);?></option> 	
										<?php 
									} 
								} 
								?>
								</select>
							</div>-->
              <div class="form-group">
                <label>Quantity</label>
                <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo $quantity; ?>">
              </div>
              <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
              </div>
              <div class="form-group">
                <label>Discount Price</label>
                <input type="text" class="form-control" id="sale_price" name="sale_price" value="<?php echo $sale_price; ?>">
              </div>
			  <div class="form-group">
                <label>Weight In GM</label>
                <input type="text" class="form-control" id="p_weight" name="p_weight" value="<?php echo $p_weight; ?>">
              </div>
              <div class="form-group">
                <label>Dimension In CM</label>
                <input type="text" class="form-control" id="p_dimension" name="p_dimension" value="<?php echo $p_dimension; ?>">
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label>Size</label>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <select name="size[]" id="lstLang" multiple class="form-control" width="100%">
                      <?php
										$query = "SELECT * FROM attributes WHERE attribute_id = 'Size' AND status = 1 ORDER BY id";
										if($stmt = $conn->query($query))
										{
											while($r = $stmt->fetch_array(MYSQLI_ASSOC))
											{
												?>
                      <option value="<?php echo $r['title'];?>" <?php if(in_array($r['title'],$sizes)) { echo "selected";}?> ><?php echo $r['title'];?></option>
                      <?php
											}
										}
										?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label>Color</label>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <select name="color[]" id="lstCol" multiple class="form-control" width="100%">
                      <?php
										$query = "SELECT * FROM attributes WHERE attribute_id = 'Color' AND status = 1 ORDER BY id";
										if($stmt = $conn->query($query))
										{
											while($r = $stmt->fetch_array(MYSQLI_ASSOC))
											{
												?>
                      <option value="<?php echo $r['title'];?>" <?php if(in_array($r['title'],$colors)) { echo "selected";}?> ><?php echo $r['title'];?></option>
                      <?php
											}
										}
										?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label>Material</label>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <select name="material[]" id="lstMat" multiple class="form-control" width="100%">
                      <?php
										$query = "SELECT * FROM attributes WHERE attribute_id = 'Material' AND status = 1 ORDER BY id";
										if($stmt = $conn->query($query))
										{
											while($r = $stmt->fetch_array(MYSQLI_ASSOC))
											{
												?>
                      <option value="<?php echo $r['title'];?>" <?php if(in_array($r['title'],$materials)) { echo "selected";}?> ><?php echo $r['title'];?></option>
                      <?php
											}
										}
										?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label>Department</label>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <select name="department[]" id="lstDep" multiple class="form-control" width="100%">
                      <?php
										$query = "SELECT * FROM attributes WHERE attribute_id = 'Department' AND status = 1 ORDER BY id";
										if($stmt = $conn->query($query))
										{
											while($r = $stmt->fetch_array(MYSQLI_ASSOC))
											{
												?>
                      <option value="<?php echo $r['title'];?>" <?php if(in_array($r['title'],$departments)) { echo "selected";}?> ><?php echo $r['title'];?></option>
                      <?php
											}
										}
										?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label>Style</label>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <select name="style[]" id="lstSty" multiple class="form-control" width="100%">
                      <?php
										$query = "SELECT * FROM attributes WHERE attribute_id = 'Style' AND status = 1 ORDER BY id";
										if($stmt = $conn->query($query))
										{
											while($r = $stmt->fetch_array(MYSQLI_ASSOC))
											{
												?>
                      <option value="<?php echo $r['title'];?>" <?php if(in_array($r['title'],$styles)) { echo "selected";}?> ><?php echo $r['title'];?></option>
                      <?php
											}
										}
										?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label>Fitment Type</label>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <select name="fitment_type[]" id="lstFit" multiple class="form-control" width="100%">
                      <?php
										$query = "SELECT * FROM attributes WHERE attribute_id = 'Fitment Type' AND status = 1 ORDER BY id";
										if($stmt = $conn->query($query))
										{
											while($r = $stmt->fetch_array(MYSQLI_ASSOC))
											{
												?>
                      <option value="<?php echo $r['title'];?>" <?php if(in_array($r['title'],$fitment_types)) { echo "selected";}?> ><?php echo $r['title'];?></option>
                      <?php
											}
										}
										?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <?php if($image!="") { ?>
                <div class="col-sm-12">
                  <div class="form-group"> <img src="../uploads/products/<?php echo $result['image']?>" alt="<?php echo $title; ?>" height="100" width="120" title="<?php echo $title; ?> Image"> </div>
                </div>
                <?php } ?>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Featured Images</label>
                    <input class="btn btn-default" type="file" id="image" name="image" value="<?php echo $result['image']?>"/>
                    <span class="red" style="color:red;"><font size="2" width="bold">[ Size : 217*250 ]px</font></span> </div>
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
                          <div class="form-group"> <img src="../uploads/product_images/<?php echo $result_product_images['product_image']; ?>"  height="100" width="120"> </div>
                          <div style="margin-top:20px; width: 120px; text-align: center;"> <a href="delete.php?id=<?php echo $result_product_images['id'];?>" class="form-control"  onClick="return confirm('Are you sure to delete?');" style="background-color:#1F67A2;color:#fff;">Delete</a> </div>
                        </div>
                        <?php 
													}
													?>
                        <div style="margin-top:20px; width: 120px; text-align: center;"> <a href="javascript:void(0);" class="add_button" title="Add field">Add More</a> </div>
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
                            <span class="red" style="color:red;"><font size="2" width="bold">[ Size : 427*985 ]px</font></span> </div>
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
                <textarea name="description" id="description" class="form-control ckeditor" rows="8" ><?php echo $description; ?></textarea>
              </div>
              <div class="row">
                <label for="exampleInputEmail1">Overview</label>
                <textarea name="arabic_description" id="arabic_description" class="form-control ckeditor" rows="8" ><?php echo $arabic_description; ?></textarea>
              </div>
              <div class="row">
                <label for="exampleInputEmail1">Specification</label>
                <textarea name="specification" id="specification" class="form-control ckeditor" rows="8" ><?php echo $specification; ?></textarea>
              </div>
              <div class="row">
                <label for="exampleInputEmail1">Care Instructions</label>
                <textarea name="care_instructions" id="care_instructions" class="form-control ckeditor" rows="8" ><?php echo $care_instructions; ?></textarea>
              </div>
              <div class="row">
                <label for="exampleInputEmail1">Questions</label>
                <textarea name="questions" id="questions" class="form-control ckeditor" rows="8" ><?php echo $questions; ?></textarea>
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
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="lib/ToggleSwitch.css"/>
<script src="lib/ToggleSwitch.js"></script> 
<script>
	$(function(){
		$("#status").toggleSwitch();
		$("#myonoffswitch2").toggleSwitch();
	});
</script> 
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>
<link href="https://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
        rel="stylesheet" type="text/css" />
<script src="https://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
        type="text/javascript"></script> 
<script type="text/javascript">
        $(function () {
            $('#lstLang').multiselect({
                includeSelectAllOption: true
            });
        });
		$(function () {
            $('#lstCol').multiselect({
                includeSelectAllOption: true
            });
        });
		$(function () {
            $('#lstMat').multiselect({
                includeSelectAllOption: true
            });
        });
		$(function () {
            $('#lstDep').multiselect({
                includeSelectAllOption: true
            });
        });
		$(function () {
            $('#lstSty').multiselect({
                includeSelectAllOption: true
            });
        });
		$(function () {
            $('#lstFit').multiselect({
                includeSelectAllOption: true
            });
        });
    </script> 
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
			image: 
			{
				required:true,
			},
		},
		messages: {
					 title:{required:"Please Enter Title."},
					 image:{required:"Please Enter Image."},
					 category_id:{required:"Please Select Category."},
					 quantity:{required:"Please Enter Quantity."},
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
			category_id: 
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
					quantity:{required:"Please Enter Quantity."},
					category_id:{required:"Please Select Category."},
					price:{required:"Please Enter Price."},
			   }
	});
}
</script>
<script>
 $(function() {
   $("input[name='hot']").click(function() {
     if ($("#chkYes").is(":checked")) {
       $("#dvPinNo").show();
     } else {
       $("#dvPinNo").hide();
     }
   });
 });
</script>
</body>
</html>