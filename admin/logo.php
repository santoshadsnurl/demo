<?php

include('session.php');

if(isset($_FILES['image']) && $_FILES['image']['error']==0)
{
	$logoimage = $_FILES['image']['name'];
	$time =time();
	$logoimage = $time.$logoimage;
	$path_image = $site_root.'uploads/logo/'.$logoimage;
	$logoimagename = "";
	$logoimagename = str_replace($site_root, '../', $newobject->getInfo($conn,"logo","image",$id));
	if($logoimagename!="")
	{
		if (file_exists($logoimagename)) { unlink($logoimagename); }
	}
	$logofilename = "../uploads/logo/". $logoimage;
	$mv =move_uploaded_file($_FILES['image']['tmp_name'],$logofilename);
	$query_imageup="UPDATE logo SET image='".$path_image."' WHERE id = 1";
	if($sql_imageup=$conn->prepare($query_imageup))
	$sql_imageup->execute();
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
					<div class="panel-heading">
						<h3 class="panel-title">Logo</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="logo" enctype="multipart/form-data">
							<div class="col-sm-12" style="margin-left:30%;">									
								<div class="form-group">
								<img src="<?php echo $newobject->getInfo($conn,"logo","image",1); ?>" alt="Logo" height="100" width="120" title="Logo Image">
								</div>									
							</div>
							<div class="form-group">
								<input class="btn btn-default" type="file" id="image" name="image" value="" required/>
								<span class="red" style="color:red;"><font size="2" width="bold">[ Size : 122*51 ]</font></span>	
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary">Update</button>
							<a href="logo.php" class="btn btn-primary pull-right">Cancel</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>
<script>
$("#logo").validate(
{
	rules: 
	{
		image: 
		{ 
			required:true,
		},
	},
	messages: {
				 image:{required:"Please Enter Image."},
		   }
});
</script>

</body>
</html>
