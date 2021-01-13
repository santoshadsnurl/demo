<?php
error_reporting(0);
	
include('session.php');

/* set variable */
$pagename = "CSV";
$pagetaskname = " Submit ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";

/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$path = rand().$_FILES['csv']['name'];
	$ret = move_uploaded_file($_FILES['csv']['tmp_name'],$path);
	$csvfile = fopen($path,'r');
	$i = 0;
	$a = 0;

	while (!feof($csvfile)) 
	{
		$csv_data[] = fgetcsv($csvfile, 10000);	
	}
	
	/* echo "<pre>";
	print_r($csv_data);
	//exit; */
	
	$random_str = '1234567890';
	$shuffle_str = str_shuffle($random_str);
	$alias_id = substr($shuffle_str,0,3);
	
	foreach ($csv_data as $krys => $csv_array)
	{
		$insert_csv = array();
		$img = array();
		if($csv_array[0]!="")
		{
			$insert_csv['category_id'] = $csv_array[0];
		}
		if($csv_array[1]!="")
		{
			$insert_csv['sub_category_id'] = $csv_array[1];
		}
		if($csv_array[2]!="")
		{
			$insert_csv['sub_sub_category_id'] = $csv_array[2];
		}
		$insert_csv['title'] = addslashes($csv_array[3]);
		$alias = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($csv_array[3]))));
		$insert_csv['alias'] = $alias.'-'.$alias_id;
		$insert_csv['arabic_title'] = addslashes($csv_array[4]);
		$insert_csv['sku'] = $csv_array[5];
		$insert_csv['hot'] = $csv_array[6];
		$insert_csv['quantity'] = $csv_array[7];
		$insert_csv['price'] = $csv_array[8];
		$insert_csv['sale_price'] = $csv_array[9];
		if($csv_array[10]=="")
		{
			$insert_csv['special_price'] = 0;
		}
		else
		{
			$insert_csv['special_price'] = $csv_array[10];
		}
		$insert_csv['product_color'] = str_replace("/",",",$csv_array[11]);
		$insert_csv['product_size'] = str_replace("/",",",$csv_array[12]);
		$insert_csv['product_material'] = str_replace("/",",",$csv_array[13]);
		$insert_csv['product_department'] = str_replace("/",",",$csv_array[14]);
		$insert_csv['product_style'] = str_replace("/",",",$csv_array[15]);
		$insert_csv['product_fitment_type'] = str_replace("/",",",$csv_array[16]);
		$insert_csv['image'] = $csv_array[17];
		$insert_csv['alt_tag'] = $csv_array[18];
		$insert_csv['description'] = htmlentities(addslashes($csv_array[35]));
		$insert_csv['arabic_description'] = htmlentities(addslashes($csv_array[36]));
		$insert_csv['specification'] = htmlentities(addslashes($csv_array[37]));
		$insert_csv['care_instructions'] = htmlentities(addslashes($csv_array[38]));
		$insert_csv['questions'] = htmlentities(addslashes($csv_array[39]));
		$insert_csv['meta_title'] = $csv_array[40];
		$insert_csv['meta_keyword'] = $csv_array[41];
		$insert_csv['meta_description'] = $csv_array[42];

		$img = array($csv_array[19],$csv_array[21],$csv_array[23],$csv_array[25],$csv_array[27],$csv_array[29],$csv_array[31],$csv_array[33]);
		$at = array($csv_array[20],$csv_array[22],$csv_array[24],$csv_array[26],$csv_array[28],$csv_array[30],$csv_array[32],$csv_array[34]);
		/* echo "<pre>";
		print_r($img);
		exit; */

		$total = count($img);

		if($insert_csv['category_id']!="")
		{
			if($i!=0)
			{
				$query_duplicate = "SELECT * FROM products WHERE title = '$insert_csv['title']'";
				if($sql_duplicate = $conn->query($query_duplicate))
				{
					if($sql_duplicate->num_rows==0)
					{
						$query_insert="INSERT INTO products(category_id,sub_category_id,sub_sub_category_id,title,alias,arabic_title,sku,hot,quantity,price,sale_price,special_price,description,arabic_description,specification,care_instructions,questions,product_color,product_size,product_material,product_department,product_style,product_fitment_type,image,alt_tag,meta_title,meta_keyword,meta_description) VALUES ('".$insert_csv['category_id']."','".$insert_csv['sub_category_id']."','".$insert_csv['sub_sub_category_id']."','".$insert_csv['title']."','".$insert_csv['alias']."','".$insert_csv['arabic_title']."','".$insert_csv['sku']."','".$insert_csv['hot']."','".$insert_csv['quantity']."','".$insert_csv['price']."','".$insert_csv['sale_price']."','".$insert_csv['special_price']."','".$insert_csv['description']."','".$insert_csv['arabic_description']."','".$insert_csv['specification']."','".$insert_csv['care_instructions']."','".$insert_csv['questions']."','".$insert_csv['product_color']."','".$insert_csv['product_size']."','".$insert_csv['product_material']."','".$insert_csv['product_department']."','".$insert_csv['product_style']."','".$insert_csv['product_fitment_type']."','".$insert_csv['image']."','".$insert_csv['alt_tag']."','".$insert_csv['meta_title']."','".$insert_csv['meta_keyword']."','".$insert_csv['meta_description']."')";
						if($sql_insert=$conn->prepare($query_insert))
						{
							$sql_insert->execute();
							$id = mysqli_insert_id($conn);
							$_SESSION['response'] = $pagename." Uploaded Successfully.";

							for($a=0; $a<$total; $a++)
							{
								if(!empty($img[$a]))
								{
									$product_image = $img[$a];
									$product_alt_tag = $at[$a];
									$query_insertt = "INSERT INTO product_images SET product_id = '".$id."',product_image='".$product_image."',product_alt_tag='".$product_alt_tag."'";
									if($sql_insert = $conn->prepare($query_insertt))
									{
										$sql_insert->execute();
										$_SESSION['response'] = $pagename." Added Successfully.";
									}
								}
							}
						} 
					}
				}
			}
			$i++;

		}
	}
	fclose($csvfile);
	echo "<script>document.location.href='products_mgmt.php';</script>";
	exit;
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
		<h2 class="headn-h2">Catelog</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-md-6 col-lg-offset-3 col-xs-12">
				<div class="panel panel-default">
					<?php if($msg!="") { ?> 
					<div class="alert alert-danger fade in" style="margin:10px 10px 10px 10px;">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $msg; ?>
					</div>
					<?php } ?>
					<div class="panel-heading">
					<h3 class="panel-title">Product Upload</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="subscribers" enctype="multipart/form-data">
							<div class="form-group">
								<label>Add CSV File</label>
								<input class="btn btn-default" type="file" id="csv" title="Please Upload CSV File" name="csv" value="" required/>
								<span class="red" style="color:red;"><font size="2" width="bold"></font></span>	
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
$("#subscribers").validate(
{
	rules: 
	{
		
	},
	messages: {

		   }
});
</script>

</body>
</html>
