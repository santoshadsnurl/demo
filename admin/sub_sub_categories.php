<?php
	
include('session.php');

/* set variable */

$pagename = "Sub Sub Category";
$pagetaskname = " Add ";

/* set var blank */

$id = "";
$msg = "";	
$title = "";
$arabic_title = "";
$status = "";
$alias = "";
$category_id = "";
$sub_category_id = "";
$sub_sub_category_id = "";
$order_no = "";
$image = "";
$meta_title ="";
$arabic_meta_title ="";
$meta_keyword ="";
$meta_description ="";

/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$title = addslashes(ucwords(trim($_POST['title'])));
	$sub_category_id = $_POST['sub_category_id'];
	$category_id = $_POST['category_id'];
	$order_no = $_POST['order_no'];
	$alias = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($title))));
	$meta_title = addslashes(ucwords(trim($_POST['meta_title'])));
	$meta_keyword = addslashes(trim($_POST['meta_keyword']));
	$meta_description = addslashes(trim($_POST['meta_description']));;
	if(!empty($_POST['status'])) { $status=1; } else{ $status=0;	}

	/* check title in database */

	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	 $query_duplicate="SELECT * FROM sub_sub_categories WHERE ((title='".$title."' AND category_id='".$category_id."' AND sub_category_id='".$sub_category_id."' OR id='".$id."')) $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		if($sql_duplicate->num_rows>0)
		{
			$msg = "This Title or Sub Category Id is already exist!";
		}
		else
		{
			if($id!="")
			{
				$alias = $alias.'-'.$id;
				$query_update="UPDATE sub_sub_categories SET title='".$title."',arabic_title='".$arabic_title."',arabic_meta_title='".$arabic_meta_title."',category_id='".$category_id."',sub_category_id='".$sub_category_id."',sub_sub_category_id='".$sub_sub_category_id."',order_no='".$order_no."',alias='".$alias."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO sub_sub_categories SET title='".$title."',arabic_title='".$arabic_title."',arabic_meta_title='".$arabic_meta_title."',category_id='".$category_id."',sub_category_id='".$sub_category_id."',status='1',sub_sub_category_id='".$sub_sub_category_id."',order_no='".$order_no."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."'";
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$_SESSION['response'] = $pagename." Added Successfully.";

				}
				$alias = $alias.'-'.$id;
				$query_update = "UPDATE sub_sub_categories SET alias='".$alias."' WHERE id='".$id."'";
				if($sql_update = $conn->prepare($query_update))
				{
					$sql_update->execute();
				}
			}
			echo "<script>document.location.href='sub_sub_categories_mgmt.php';</script>";
			exit;
		}
	}
}

/* Listing  */

if($id!="")
{
    $query_select="SELECT * FROM sub_sub_categories WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$title = stripslashes($result['title']);
			$sub_category_id = $result['sub_category_id'];
			$category_id = $result['category_id'];
			$order_no = $result['order_no'];
			$arabic_meta_title = $result['arabic_meta_title'];
			$arabic_title = $result['arabic_title'];
			$meta_title = stripslashes($result['meta_title']);
			$meta_keyword = stripslashes($result['meta_keyword']);
			$meta_description = stripslashes($result['meta_description']);
			$pagetaskname = " Update ";
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

function getreference(category_id)
{
	//alert(category_id);
	var url2 = "load_category.php?"; // The server-side script
	http.open("GET",url2+"category_id="+category_id, true);
	//alert(http.open);
	http.onreadystatechange = handleHttpResponse5;
	http.send();
}

</script>
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
					<h3 class="panel-title">Sub Sub Categories</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="sub_sub_categories" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleInputEmail1">Sub Sub Category Name</label>
								<input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
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
							<label for="exampleInputPassword1">Order Number</label>
							<input type="text" class="form-control" id="order_no" name="order_no" value="<?php echo $order_no; ?>">
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
							<a href="sub_sub_categories_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>

<script>

$("#sub_sub_categories").validate(

{

	rules: 

	{

		title: 

		{ 

			required:true,

		},
		order_no: 
		{ 
			required:true,
		},
		category_id: 
		{ 
			required:true,
		},
		sub_category_id: 
		{ 
			required:true,
		}

	},

	messages: {

				 title:{required:"Please Enter Title."},
				 category_id:{required:"Please Select Category."},
				 sub_category_id:{required:"Please Select Sub Category."},
				 order_no:{required:"Please Enter Order Number."},

		   }

});

</script>

</body>
</html>
