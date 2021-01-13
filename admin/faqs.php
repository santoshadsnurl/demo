<?php
	
include('session.php');

/* set variable */

$pagename = "Faqs";
$pagetaskname = " Add ";

/* set var blank */

$id = "";
$msg = "";	
$title = "";
$description = "";
$meta_description ="";
$arabic_title = "";

/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$title = addslashes(ucwords(trim($_POST['title'])));
	$description = $_POST['description'];
	$arabic_description = $_POST['arabic_description'];
	$arabic_title = $_POST['arabic_title'];
	if(!empty($_POST['status'])) { $status=1; } else{ $status=0;	}
	
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM faqs WHERE title='".$title."' $checkDuplicate";
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
				$query_update="UPDATE faqs SET title='".$title."',status=1,arabic_title='".$arabic_title."',arabic_description='".$arabic_description."',description='".$description."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO faqs SET title='".$title."',arabic_title='".$arabic_title."',arabic_description='".$arabic_description."',status=1,description='".$description."'";
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$_SESSION['response'] = $pagename." Added Successfully.";
				}
			}
			echo "<script>document.location.href='faqs_mgmt.php';</script>";
			exit;
		}
	}
}



/* Listing  */

if($id!="")
{
    $query_select="SELECT * FROM faqs WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$title = stripslashes($result['title']);
			$description = $result['description'];
			$arabic_description = $result['arabic_description'];
			$arabic_title = $result['arabic_title'];
			$status = $result['status'];
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
					<h3 class="panel-title">Faqs</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="faqs" enctype="multipart/form-data">
							<div class="form-group">
								<label>Question</label>
								<input type="text" class="form-control" id="title" name="title" title="Please Enter Title" value="<?php echo $title; ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Arabic Question</label>
								<input type="text" class="form-control" id="arabic_title" name="arabic_title" value="<?php echo $arabic_title; ?>">
							</div>
							<div class="row">
								<label for="exampleInputEmail1">Answer</label>
								<textarea name="description" id="description" class="form-control ckeditor" rows="8" ><?php echo $description; ?></textarea>
							</div>
							<div class="row">
								<label for="exampleInputEmail1">Arabic Answer</label>
								<textarea name="arabic_description" id="arabic_description" class="form-control ckeditor" rows="8" ><?php echo $arabic_description; ?></textarea>
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="faqs_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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
$("#faqs").validate(
{
	rules: 
	{
		title: 
		{ 
			required:true,
		},
	},
	messages: {
				 title:{required:"Please Enter Question."},
		   }
});
</script>

</body>
</html>
