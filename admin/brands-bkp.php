<?php
	
include('session.php');

/* set variable */

$pagename = "Brands";
$pagetaskname = " Add ";

/* set var blank */

$id = "";
$msg = "";	
$title = "";
$status = "";
$alias = "";
$brand_id = "";
$order_no = "";
$image = "";
$meta_title ="";
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
	$brand_id = $_POST['brand_id'];
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
	$query_duplicate="SELECT * FROM brands WHERE (title='".$title."' OR brand_id='".$brand_id."') $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		if($sql_duplicate->num_rows>0)
		{
			$msg = "This Title or Brands Id is already exist!";
		}
		else
		{
			if($id!="")
			{
				$query_update="UPDATE brands SET title='".$title."',brand_id='".$brand_id."',order_no='".$order_no."',alias='".$alias."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO brands SET title='".$title."',status='1',brand_id='".$brand_id."',order_no='".$order_no."',alias='".$alias."',meta_title='".$meta_title."',meta_keyword='".$meta_keyword."',meta_description='".$meta_description."'";
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$_SESSION['response'] = $pagename." Added Successfully.";
				}
			}
			if(isset($_FILES['image']) && $_FILES['image']['error']==0)
			{
				$brand_image = $_FILES['image']['name'];
				$time =time();
				$brand_image = $time.$brand_image;
				$logoimagename = "";
				if($id!="")
				{
					$logoimagename = $newobject->getInfo($conn,"brands","image",$id);
				}
				if($logoimagename!="")
				{
					$unlkheaderfile = "../uploads/brands/".$logoimagename;
					if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
				}
				$logofilename = "../uploads/brands/". $brand_image;
				$mv =move_uploaded_file($_FILES['image']['tmp_name'],$logofilename);
				$query_imageup="UPDATE brands SET image='".$brand_image."' WHERE id='".$id."'";
				if($sql_imageup=$conn->prepare($query_imageup))
				$sql_imageup->execute();
			}
			echo "<script>document.location.href='brands_mgmt.php';</script>";
			exit;
		}
	}
}

/* Listing  */

if($id!="")
{
    $query_select="SELECT * FROM brands WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$title = stripslashes($result['title']);
			$brand_id = $result['brand_id'];
			$order_no = $result['order_no'];
			$image = $result['image'];
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
					<h3 class="panel-title">Brands</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="brands" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleInputEmail1">Brands Name</label>
								<input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Brands ID</label>
								<input type="text" class="form-control" id="brand_id" name="brand_id" value="<?php echo $brand_id; ?>">
							</div>
							<div class="form-group">
							<label for="exampleInputPassword1">Order Number</label>
							<input type="text" class="form-control" id="order_no" name="order_no" value="<?php echo $order_no; ?>">
							</div>
							<div class="row">
								<?php if($image!="") { ?>
								<div class="col-sm-12">									
									<div class="form-group">
									<img src="../uploads/brands/<?php echo $image; ?>" alt="<?php echo $alt_tag; ?>" height="100" width="120" title="<?php echo $title; ?> Image">
									</div>									
								</div>
								<?php } ?>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Brand Image</label>
										<input class="btn btn-default" type="file" id="image" name="image" value="<?php echo $image; ?>"/>
										<span class="red" style="color:red;"><font size="2" width="bold">[ Size : 167*94 ]</font></span>	
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
							<a href="brands_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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

	$("#brands").validate(

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

			image: 

			{

				required:true,

			},

		},

		messages: {

					 title:{required:"Please Enter Title."},

					 image:{required:"Please Enter Image."},
					 brand_id:{required:"Please Enter Brands ID."},
					order_no:{required:"Please Enter Order Number."},

			   }

	});

}

else

{

	$("#brands").validate(

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

		},

		messages: {

					 title:{required:"Please Enter Title."},
					 brand_id:{required:"Please Enter Brands ID."},
					order_no:{required:"Please Enter Order Number."},

			   }

	});

}

</script>

</body>
</html>
