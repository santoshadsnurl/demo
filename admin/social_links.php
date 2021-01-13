<?php
	
include('session.php');

/* set variable */

$pagename = "Social Links";
$pagetaskname = " Add ";

/* set var blank */

$id = "";
$msg = "";	
$title = "";
$image = "";
$url = "";

/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$title = addslashes(trim($_POST['title']));
	$url = addslashes(trim($_POST['url']));
	
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM social_links WHERE title='".$title."' $checkDuplicate";
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
				$query_update="UPDATE social_links SET title='".$title."',url='".$url."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO social_links SET title='".$title."',url='".$url."'";
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
				$time = time();
				$sliderimage = $time.$sliderimage;
				$path_image = $site_root.'uploads/social_links/'.$sliderimage;
				
				$sliderimagename = "";
				if($id!="")
				{
					$sliderimagename = str_replace($site_root, '../', $newobject->getInfo($conn,"social_links","image",$id));
				}
				if($sliderimagename!="")
				{
					if (file_exists($sliderimagename)) { unlink($sliderimagename); }
				}
				
				$sliderfilename = "../uploads/social_links/". $sliderimage;
				$mv = move_uploaded_file($_FILES['image']['tmp_name'],$sliderfilename);
				
				$query_imageup="UPDATE social_links SET image='".$path_image."' WHERE id='".$id."'";
				if($sql_imageup=$conn->prepare($query_imageup))
				$sql_imageup->execute();
			}
			echo "<script>document.location.href='social_links_mgmt.php';</script>";
			exit;
		}
	}
}



/* Listing  */

if($id!="")
{
    $query_select="SELECT * FROM social_links WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$title = stripslashes($result['title']);
			$url = stripslashes($result['url']);
			$status = $result['status'];
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
					<h3 class="panel-title">Social Links</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="social_links" enctype="multipart/form-data">
							<div class="form-group">
								<label>Title</label>
								<input type="text" class="form-control" id="title" name="title" title="Please Enter Title" value="<?php echo $title; ?>">
							</div>
							<div class="row">
								<?php if($image!="") { ?>
								<div class="col-sm-12">									
									<div class="form-group">
									<img src="<?php echo $image; ?>" alt="<?php echo $url; ?>" height="40" width="40" title="<?php echo $title; ?> Image">
									</div>									
								</div>
								<?php } ?>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Add Images</label>
										<input class="btn btn-default" type="file" id="image" title="Please Enter Image" name="image" value="<?php echo $image; ?>"/>
										<span class="red" style="color:red;"><font size="2" width="bold">[ Size : 78*78 ]</font></span>	
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>URL</label>
								<input type="text" class="form-control" id="url" title="Please Enter URL" name="url" value="<?php echo $url; ?>">
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="social_links_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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
	$("#social_links").validate(
	{
		rules: 
		{
			title: 
			{ 
				required:true,
			},
			url: 
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
					 url:{required:"Please Enter URL."},
					 image:{required:"Please Enter Image."},
			   }
	});
}
else
{
	$("#social_links").validate(
	{
		rules: 
		{
			title: 
			{ 
				required:true,
			},
			url: 
			{ 
				required:true,
			},
		},
		messages: {
					 title:{required:"Please Enter Title."},
					 url:{required:"Please Enter URL."},
			   }
	});
}
</script>

</body>
</html>
