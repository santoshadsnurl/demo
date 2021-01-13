<?php

include('session.php');	

/* set blank */
$id = "";
$total_page = "";
$TotalCnt = "";
$searchInput = "";
$strQuery = "";

if(isset($_REQUEST['searchQuery']) && !empty($_REQUEST['searchQuery']))
{
	$searchInput = trim($_REQUEST['searchQuery']);
	$strQuery = "WHERE title LIKE '%$searchInput%'";
}

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
	$query_delete = "DELETE FROM shop_online WHERE id='".$id."'";
	if($sql_delete = $conn->query($query_delete))
	{
		$_SESSION['response'] = "Deleted Successfully.";
		echo "<script>document.location.href='shop_online_mgmt.php';</script>";
	    exit();					
	}
}
if(isset($_POST['delete_all']) && !empty($_POST['delete_all']))
{ 
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		foreach($_POST['check_status'] as $value)
		{	
			if($sql_deleteall=$conn->query("DELETE FROM shop_online WHERE id = '".$value."'"))
			{
				$_SESSION['response'] = "Deleted Successfully.";				
			}
	    }
		echo "<script>document.location.href='shop_online_mgmt.php';</script>";
	    exit();
	}
	else
	{
		$_SESSION['error'] = "Please Select First.";
		echo "<script>document.location.href='shop_online_mgmt.php';</script>";
	    exit();	
	}
}

$pageno = 1;
$pageshow = 10;
if(isset($_GET['pageno']) && ($_GET['pageno']>0)) { $pageno = $_GET['pageno']; }
if($sql_count=$conn->query("SELECT * FROM shop_online $strQuery ORDER BY id ASC"))
{
	if($TotalCnt=$sql_count->num_rows)
	{
 		$total_page=ceil($TotalCnt/$pageshow);	
	}
	else
	{
		$total_page=0;
	}
}
if(!isset($_GET['pageno']) or $_GET['pageno']==1)
{
	$st=0;
	$pageno=1;
}
else
{
	$st=($pageno*$pageshow)-$pageshow;
}
if($total_page>$pageno)
{
	$nx=$pageno+1;
	$next='<li><a class="active" href="javascript:ShowPage('.$nx.')">Next &raquo;</a></li>';
}
else
{
	$next="";
}
if($pageno>1)
{
	$pr=($pageno-1);
	$pre='<li><a class="active" href="javascript:ShowPage('.$pr.')">&laquo; Previous</a></li>';
}
else
{
	$pre="";
}	
$limitvar = "LIMIT $st,$pageshow";
$query="SELECT * FROM shop_online $strQuery ORDER BY id ASC $limitvar";
$start_1 =($st+1);
$start =$st;
$end =($start+$pageshow);
$page="";
if($pageno <= 5)
{
	$startpage = 1;
}
else
{
	$startpage = $pageno-5;
}
if(($total_page - $pageno) <= 5)
{
	$endpage = $total_page;
}
else
{
	$endpage = $pageno+5;
}
for($i=$startpage;$i<=$endpage;$i++)
{
	$page.='<li><a class="active" href="javascript:ShowPage('.$i.')" > ' . $i .  ' </a></li>';
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
		<form name="pageinfo" method="get" action="<?php echo $_SERVER['REQUEST_URI'];?>">
			<input type="hidden" name="searchQuery" value="<?php if(isset($_GET['searchQuery'])) { echo $_GET['searchQuery']; } ?>" />
			<input type="hidden" name="pageno" value="<?php if(isset($_GET['pageno'])) { echo $_GET['pageno']; } else{ echo $pageno;} ?>" />
		</form>
		<div class="dashboard-bar">
		<h2 class="headn-h2">CMS</h2>
		</div>
		<div class="main-section">
			<?php if(isset($_SESSION['response'])) { ?> 
			<div class="alert alert-success fade in f">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<?php echo $_SESSION['response']; unset($_SESSION['response']); ?>
			</div>
			<?php } ?>
			<?php if(isset($_SESSION['error'])) { ?> 
			<div class="alert alert-danger fade in f">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
			</div>
			<?php } ?>
			<div class="col-sm-12 col-md-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					<h3 class="panel-title">Shop Online</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-4">
								<form name="searchform" method="get" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<div class="input-group">
										<input style="border:1px solid #d3d3d3; height:38.5px;" type="text" name="searchQuery" class="form-control" placeholder="Search By Title" value="<?php echo $searchInput;?>"  required/>
										<span class="input-group-btn">
										<button class="btn btn-default" type="submit" name="search" value="Search">Search</button>
										</span> 
									</div>
								</form>
								<!-- /input-group --> 
							</div>
							<form id="header" name="header" action="<?php $_SERVER['PHP_SELF'] ?>" method ="post">
							<div class="col-sm-4">
								<a href="shop_online.php"><button class="btn btn-primary center-block" type="button">Add New</button></a>
							</div>
							<div class="col-sm-4">
								<input type="submit" class="btn btn-default pull-right" name="delete_all" value="Delete" onClick="return confirm('Are you sure? You want to Delete');"/>
							</div>
						</div>
						<div class="clearfix"></div>
						<table class="table table-bordered" style="margin-top:15px;">
							<thead style="background:#d6d6d7;">
								<tr>
								<th>S.No.</th>
								<th>Title</th>
								<th>Status</th>
								<th>Action</th>
								<th><label><input type="checkbox" id="checkAllbox"/></label></th>
								</tr>
							</thead>
							<tbody>
							<?php 
							if($sql_select=$conn->query($query))
							{
								if($sql_select->num_rows>0)
								{
									$ctr=0;
									while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
									{
										$id = $result['id'];
										$ctr++;
										?>
										<tr>
											<th scope="row"><?php echo $ctr; ?></th>
											<td><?php echo $result['title']; ?></td>
											<td>
											<?php if($result['status'] == 1) { ?>
											<input type="checkbox" onclick="return chkstatus('shop_online','0','<?php echo $id;?>');" name="status<?php echo $id; ?>" id="status<?php echo $id; ?>" value="<?php echo $result['status'];?>" checked / >
											<?php }	else { ?>
											<input type="checkbox"  onclick="return chkstatus('shop_online','1','<?php echo $id;?>');" name="status<?php echo $id; ?>" id="status<?php echo $id; ?>" value="<?php echo $result['status'];?>"/ >
											<?php }	?>
											</td>
											<td>
											<a href="shop_online_mgmt.php?id=<?php echo $result['id']; ?>" title="Delete" class="btn btn-primary btn-xs" onClick="return confirm('Are you sure to delete?');"> <i class="glyphicon glyphicon-trash"></i> </a>
											<a href="shop_online.php?id=<?php echo $result['id']; ?>" title="Edit" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
											</td>
											<th>
											<label><input type="checkbox" class="checkbox" value="<?php echo $result['id']; ?>" name="check_status[]"></label>
											</th>
										</tr>
										<?php 
									}
								}
								else
								{
									?>
									<td  colspan="6" align="center"><font color="red" size="2">Record Not Found</font></td>
									<?php
								}
							}
							?>
							</tbody>
						</table>
						</form>
						<div class="bs-example" data-example-id="disabled-active-pagination"> 
							<nav aria-label="...">
								<ul class="pagination text-center center-block" style="display:table;"> 
								<?php if($TotalCnt>0) { echo $pre;?>&nbsp;<?php echo $page;?>&nbsp;<?php echo $next; } ?>	
								</ul> 
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->

<script>
function chkstatus(table,status,id)
{
	$.ajax({
			type: "GET",
			url: "changestatus.php?",
			data: "table="+table+"&status="+status+"&id="+id+"&Action=Update",
			success: function(response)
			{
				/* alert(response); */
				setTimeout(function()
				{
				   window.location.reload(1);
				}, 1000);
				return true;
			}
		});	
}
</script>
<script>
$("#checkAllbox").change(function () {
    $(".checkbox").prop('checked', $(this).prop("checked"));
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="lib/ToggleSwitch.css"/>
<script src="lib/ToggleSwitch.js"></script>
<?php  
$ban="SELECT * FROM shop_online $strQuery ORDER BY id $limitvar";
if($sql_ban = $conn->query($ban))
{
	if($sql_ban->num_rows>0)
	{
		while($result = $sql_ban->fetch_array(MYSQLI_ASSOC))
		{
			$id = $result['id']; 
			?>
			<script>
			$(function(){
			$("#status<?php echo $id; ?>").toggleSwitch();
			$("#myonoffswitch2").toggleSwitch();
			});
			</script>
			<?php 
		} 
	} 
} 
?>
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

</body>
</html>
