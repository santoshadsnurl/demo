<?php
	
include('session.php');

/* set variable */

$pagename = "Sliders";
$pagetaskname = " Add ";

/* set var blank */

$id = "";
$msg = "";	
$title = "";
$image = "";
$offer = "";
$order_no = "";

/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$title = addslashes(ucwords(trim($_POST['title'])));
	$offer = $_POST['offer'];
	$order_no = $_POST['order_no'];
	
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM sliders WHERE title='".$title."' $checkDuplicate";
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
				$query_update="UPDATE sliders SET title='".$title."',order_no='".$order_no."',offer='".$offer."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO sliders SET title='".$title."',order_no='".$order_no."',offer='".$offer."'";
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$_SESSION['response'] = $pagename." Added Successfully.";
				}
			}
			if(isset($_FILES['image']) && $_FILES['image']['error']==0)
			{
				$sliderimage = $_FILES['image']['name'];
				$time =time();
				$sliderimage = $time.$sliderimage;
				$path_image = $site_root.'uploads/sliders/'.$sliderimage;
				
				$sliderimagename = "";
				if($id!="")
				{
					$sliderimagename = str_replace($site_root, '../', $newobject->getInfo($conn,"sliders","image",$id));
				}
				if($sliderimagename!="")
				{
					if (file_exists($sliderimagename)) { unlink($sliderimagename); }
				}

				$sliderfilename = "../uploads/sliders/". $sliderimage;
				$mv = move_uploaded_file($_FILES['image']['tmp_name'],$sliderfilename);
				$query_imageup="UPDATE sliders SET image='".$path_image."' WHERE id='".$id."'";
				if($sql_imageup=$conn->prepare($query_imageup))
				$sql_imageup->execute();
			}
			echo "<script>document.location.href='sliders_mgmt.php';</script>";
			exit;
		}
	}
}



/* Listing  */

if($id!="")
{
    $query_select="SELECT * FROM sliders WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$title = stripslashes($result['title']);
			$offer = $result['offer'];
			$order_no = $result['order_no'];
			$image = $result['image'];
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
	<?php include('includes/cms-left.php'); ?>	
	</div>
	<div class="right-section">
		<div class="dashboard-bar">
		<h2 class="headn-h2">CMS</h2>
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
					<h3 class="panel-title">Sliders</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="sliders" enctype="multipart/form-data">
							<div class="form-group">
								<label>Title</label>
								<input type="text" class="form-control" id="title" name="title" title="Please Enter Title" value="<?php echo $title; ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">URL</label>
								<input type="text" class="form-control" id="order_no" name="order_no" value="<?php echo $order_no; ?>">
							</div>
							<div class="row">
								<?php if($image!="") { ?>
								<div class="col-sm-12">									
									<div class="form-group">
									<img src="<?php echo $image; ?>" alt="<?php echo $offer; ?>" height="40" width="40" title="<?php echo $title; ?> Image">
									</div>									
								</div>
								<?php } ?>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Add Images</label>
										<input class="btn btn-default" type="file" id="image" title="Please Enter Image" name="image" value="<?php echo $image; ?>"/>
										<span class="red" style="color:red;"><font size="2" width="bold">[ Size : 1036*216 ]</font></span>	
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Description</label>
								<input type="text" class="form-control" id="offer" title="Please Enter Description" name="offer" value="<?php echo $offer; ?>">
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="sliders_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>
<script>
var Id = "<?php echo $id;?>";

if(Id == "")
{
	$("#sliders").validate(
	{
		rules: 
		{
			title: 
			{ 
				required:true,
			},
			offer: 
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
					 offer:{required:"Please Enter Description."},
					 image:{required:"Please Enter Image."},
			   }
	});
}
else
{
	$("#sliders").validate(
	{
		rules: 
		{
			title: 
			{ 
				required:true,
			},
			offer: 
			{ 
				required:true,
			},
		},
		messages: {
					title:{required:"Please Enter Title."},
					offer:{required:"Please Enter Description."},
			   }
	});
}
</script>

</body>
</html>
