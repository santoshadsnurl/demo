<?php
	
include('session.php');

/* set variable */
$pagename = "Discount";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$dist_rate = "";
$description = "";
$image = "";
$alias = "";
$status = "";
$startdate = "";
$enddate = "";
$code = "";

/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$code = $_POST['code'];
	$dist_rate = $_POST['dist_rate'];
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	$description = $_POST['description'];
	if(!empty($_POST['status'])) { $status=1; } else{ $status=0;	}
	
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM discount WHERE dist_rate='".$dist_rate."' $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		if(isset($_SESSION['level']) && $_SESSION['level'] == "Finance Admin") 
		{ 
			$msg = "You are not Authorised.";
		}
		else
		{
			if($sql_duplicate->num_rows>0)
			{
				$msg = "This Rate is already exist, please try another.";
			}
			else
			{
				if(strtotime($startdate) > strtotime($enddate))
				{
					$msg = "End date should be grater than start date";
				}
				else
				{
					if($id!="")
					{
						$query_update="UPDATE discount SET dist_rate='".$dist_rate."',code='".$code."',startdate='".$startdate."',enddate='".$enddate."',description='".$description."',status='".$status."' WHERE id='".$id."'";
						if($sql_update=$conn->prepare($query_update))
						{
							$sql_update->execute();
							$sess_msg = $pagename." Update Successfully.";	
						}
					}
					else
					{
						$query_insert="INSERT INTO discount SET dist_rate='".$dist_rate."',code='".$code."',description='".$description."',startdate='".$startdate."',enddate='".$enddate."',status='".$status."'";
						if($sql_insert=$conn->prepare($query_insert))
						{
							$sql_insert->execute();
							$id = mysqli_insert_id($conn);
							$sess_msg = $pagename." Added Successfully.";
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
						$query_imageup="UPDATE discount SET image='".$path_image."' WHERE id='".$id."'";
						if($sql_imageup=$conn->prepare($query_imageup))
						$sql_imageup->execute();
					}
					echo "<script>document.location.href='discount_mgmt.php?msg=".$sess_msg."';</script>";
					exit;
				}
			}
		}
	}
}

/* Listing  */
if($id!="")
{
    $query_select="SELECT * FROM discount WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$dist_rate = stripslashes($result['dist_rate']);
			$status = $result['status'];
			$code = $result['code'];
			$startdate = $result['startdate'];
			$enddate = $result['enddate'];
			$description = $result['description'];
			$image = $result['image'];
			$pagetaskname = " Update ";
		}
		else
		{
			echo "<script>document.location.href='discount_mgmt.php';</script>";
			exit;
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
					<h3 class="panel-title">Discount</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="discount" enctype="multipart/form-data">
							<div class="form-group">
								<label>Promo Code</label>
								<input type="text" class="form-control" id="code" name="code" value="<?php echo $code; ?>">
							</div>
							<div class="form-group">
								<label>Discount In %</label>
								<input type="text" class="form-control" id="dist_rate" name="dist_rate" value="<?php echo $dist_rate; ?>">
							</div>
							<div class="form-group">
								<label>Start Date</label>
								<input type="text" class="form-control" id="datepicker" name="startdate" value="<?php echo $startdate; ?>">
							</div>
							<div class="form-group">
								<label>End Date</label>
								<input type="text" class="form-control" id="datepicker2" name="enddate" value="<?php echo $enddate; ?>">
							</div>
							<div class="row">
								<?php if($image!="") { ?>
								<div class="col-sm-12">									
									<div class="form-group">
									<img src="<?php echo $image; ?>" alt="<?php echo $code; ?>" height="40" width="40" title="<?php echo $code; ?> Image">
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
								<input type="text" class="form-control" id="description" title="Please Enter Description" name="description" value="<?php echo $description; ?>">
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="discount_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {
$( "#datepicker" ).datepicker();
$( "#datepicker2" ).datepicker();
});
</script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>
<script>

	$("#discount").validate(
	{
		rules: 
		{
			dist_rate: 
			{ 
				required:true,
				pattern: /^[0-9]*$/
			},
			startdate: 
			{ 
				required:true,
			},
			code: 
			{ 
				required:true,
			},
			enddate: 
			{ 
				required:true,
			},
		},
		messages: {
					 code:{required:"Please Enter Code."},
					 dist_rate:{required:"Please Enter Title."},
					 startdate:{required:"Please Enter Start Date."},
					 enddate:{required:"Please Enter End Date."},
			   }
	});
</script>

</body>
</html>
