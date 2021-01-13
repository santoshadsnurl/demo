<?php
	
include('session.php');

/* set variable */

$pagename = "Attribute";
$pagetaskname = " Add ";

/* set var blank */

$id = "";
$msg = "";	
$attribute_id = "";	
$title = "";

/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$title = $_POST['title'];
	$attribute_id = $_POST['attribute_id'];
	if(!empty($_POST['status'])) { $status=1; } else{ $status=0;	}

	/* check title in database */

	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM attributes WHERE title='".$title."' $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		if($sql_duplicate->num_rows>0)
		{
			$msg = "This Pin Code is already exist!";
		}
		else
		{
			if($id!="")
			{
				$query_update="UPDATE attributes SET  title='".$title."',attribute_id='".$attribute_id."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO attributes SET title='".$title."',attribute_id='".$attribute_id."'";
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$_SESSION['response'] = $pagename." Added Successfully.";
				}
			}
			echo "<script>document.location.href='attributes_mgmt.php';</script>";
			exit;
		}
	}
}

/* Listing  */

if($id!="")
{
    $query_select="SELECT * FROM attributes WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$title = $result['title'];
			$attribute_id = $result['attribute_id'];
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
					<h3 class="panel-title">Attributes</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="attributes" enctype="multipart/form-data">
							<div class="row">
								<div class="col-sm-12"><label>Attributes Type</label></div>
								<div class="col-sm-12">
									<div class="form-group">
										<select name="attribute_id" class="form-control">
										<option value="Size" <?php if($attribute_id == "Size") { echo "selected";}?>>Size</option>
										<option value="Color" <?php if($attribute_id == "Color") { echo "selected";}?>>Color</option>
										<option value="Material" <?php if($attribute_id == "Material") { echo "selected";}?>>Material</option>	
										<option value="Department" <?php if($attribute_id == "Department") { echo "selected";}?>>Department</option>	
										<option value="Style" <?php if($attribute_id == "Style") { echo "selected";}?>>Style</option>					
										<option value="Fitment Type" <?php if($attribute_id == "Fitment Type") { echo "selected";}?>>Fitment Type</option>	</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Attribute</label>
								<input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="attributes_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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

	$("#attributes").validate(
	{
		rules: 
		{
			title: 
			{ 
				required:true,
			}
		},
		messages: {
					title:{required:"Please Enter Attribute."}
			   }
	});
</script>

</body>
</html>
