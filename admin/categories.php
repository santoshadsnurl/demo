<?php
	
include('session.php');

/* set variable */

$pagename = "Category";
$pagetaskname = " Add ";

/* set var blank */

$id = "";
$msg = "";	
$title = "";
$arabic_title = "";
$status = "";
$featured = 0;
$image = "";
$banner_image = "";
$alias = "";
$image = "";
$category_id = "";
$order_no = "";
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
	/* echo "<pre>";
	print_r($_REQUEST);
	print_r($_FILES);
	exit; */
	$title = addslashes(ucwords(trim($_POST['title'])));
	$order_no = $_POST['order_no'];
	$alias = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($title))));
	$meta_title = addslashes(ucwords(trim($_POST['meta_title'])));
	$meta_keyword = addslashes(trim($_POST['meta_keyword']));
	$meta_description = addslashes(trim($_POST['meta_description']));
	if(!empty($_POST['featured'])) { $featured=1; } else{ $featured=0;	}
	if(!empty($_POST['status'])) { $status=1; } else{ $status=0;	}

	/* check title in database */

	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM categories WHERE title='".$title."' $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		if($sql_duplicate->num_rows>0)
		{
			$msg = "This Title or Category Id is already exist!";
		}
		else
		{
			if($id!="")
			{
				$query_update="UPDATE categories SET title='".$title."',arabic_title='".$arabic_title."',arabic_meta_title='".$arabic_meta_title."',order_no='".$order_no."',featured='".$featured."',alias='".$alias."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO categories SET title='".$title."',arabic_title='".$arabic_title."',arabic_meta_title='".$arabic_meta_title."',status='1',order_no='".$order_no."',featured='".$featured."',alias='".$alias."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."'";
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$_SESSION['response'] = $pagename." Added Successfully.";
				}
			}
			if(isset($_FILES['image']) && $_FILES['image']['error']==0)
			{
				$category_image = $_FILES['image']['name'];
				$time = time();
				$category_image = $time.$category_image;
				$path_image = $site_root.'uploads/categories/'.$category_image;

				$imagename = "";
				if($id!="")
				{
					$imagename = str_replace($site_root, '../', $newobject->getInfo($conn,"categories","image",$id));
				}
				if($imagename!="")
				{
					if (file_exists($imagename)) { unlink($imagename); }
				}
				
				$logofilename = "../uploads/categories/". $category_image;
				$mv = move_uploaded_file($_FILES['image']['tmp_name'],$logofilename);
				$query_imageup="UPDATE categories SET image='".$path_image."' WHERE id='".$id."'";
				if($sql_imageup=$conn->prepare($query_imageup))
				$sql_imageup->execute();
			}
			echo "<script>document.location.href='categories_mgmt.php';</script>";
			exit;
		}
	}
}

/* Listing  */

if($id!="")
{
    $query_select="SELECT * FROM categories WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$title = stripslashes($result['title']);
			$order_no = $result['order_no'];
			$banner_image = $result['banner_image'];
			$image = $result['image'];
			$featured = $result['featured'];
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
					<h3 class="panel-title">Category</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="categories" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleInputEmail1">Category Name</label>
								<input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Order Number</label>
								<input type="text" class="form-control" id="order_no" name="order_no" value="<?php echo $order_no; ?>">
							</div>
							<div class="row">
								<?php if($image!="") { ?>
								<div class="col-sm-12">									
									<div class="form-group">
									<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" height="100" width="120" title="<?php echo $title; ?> Image">
									</div>									
								</div>
								<?php } ?>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Category Image</label>
										<input class="btn btn-default" type="file" id="image" name="image"/>
										<span class="red" style="color:red;"><font size="2" width="bold">[ Size : 309*318 ]px</font></span>	
									</div> 
								</div>
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
							<a href="categories_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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

	$("#categories").validate(
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
		},
		messages: {
					title:{required:"Please Enter Title."},
					order_no:{required:"Please Enter Order Number."},
			   }
	});
</script>

</body>
</html>
