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
	$strQuery = "WHERE ipaddress LIKE '%$searchInput%'";
}

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
	$query_delete="DELETE FROM logindetail WHERE id='".$id."'";
	if($sql_delete=$conn->query($query_delete))
	{
		$_SESSION['response'] = "Deleted Successfully.";
		echo "<script>document.location.href='login-info.php';</script>";
	    exit();					
	}
}

if(isset($_POST['delete_all']) && !empty($_POST['delete_all']))
{ 
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		foreach($_POST['check_status'] as $value)
		{	
			if($sql_deleteall=$conn->query("DELETE FROM logindetail WHERE id = '".$value."'"))
			{
				$_SESSION['response'] = "Deleted Successfully.";				
			}
	    }
		echo "<script>document.location.href='login-info.php';</script>";
	    exit();
	}
	else
	{
		$_SESSION['error'] = "Please Select First.";
		echo "<script>document.location.href='login-info.php';</script>";
	    exit();	
	}
}

$pageno = 1;
$pageshow = 10;
if(isset($_GET['pageno']) && ($_GET['pageno']>0)) { $pageno = $_GET['pageno']; }
if($sql_count=$conn->query("SELECT * FROM logindetail $strQuery ORDER BY id DESC"))
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
$query="SELECT * FROM logindetail $strQuery ORDER BY id DESC $limitvar";
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

<form name="pageinfo" method="get" action="<?php echo $_SERVER['REQUEST_URI'];?>">
	<input type="hidden" name="searchQuery" value="<?php if(isset($_GET['searchQuery'])) { echo $_GET['searchQuery']; } ?>" />
	<input type="hidden" name="pageno" value="<?php if(isset($_GET['pageno'])) { echo $_GET['pageno']; } else{ echo $pageno;} ?>" />
</form>

<!-- Two section start here -->

<div class="container-fluid">
	<div class="left-section">
		<?php include('includes/home-left.php'); ?>
	</div>
	<div class="right-section">
		<div class="dashboard-bar">
			<h2 class="headn-h2">Dashboard</h2>
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
						<h3 class="panel-title">Login Info</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<div class="row">
							<div class="col-sm-4">
								<form name="searchform" method="get" action="<?php echo $_SERVER['REQUEST_URI'];?>">
									<div class="input-group">
										<input style="border:1px solid #d3d3d3; height:38.5px;" type="text" name="searchQuery" class="form-control" placeholder="Search By IP" value="<?php echo $searchInput;?>"  required/>
										<span class="input-group-btn">
										<button class="btn btn-default" type="submit" name="search" value="Search">Search</button>
										</span> 
									</div>
								</form>
							</div>
							<form id="header" name="header" action="<?php $_SERVER['PHP_SELF'] ?>" method ="post">
							<div class="col-sm-4 col-sm-offset-4">
								<input type="submit" class="btn btn-default pull-right" name="delete_all" value="Delete" onClick="return confirm('Are you sure? You want to Delete');"/>
							</div>
						</div>
						<div class="clearfix"></div>
						<table class="table table-bordered" style="margin-top:15px;">
							<thead style="background:#d6d6d7;">
								<tr>
								<th>S.No.</th>
								<th>IP Address</th>
								<th>Login Date And Time</th>
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
										$ctr++;
										?>
										<tr>
										<th scope="row"><?php echo $ctr; ?></th>
										<td><?php echo $result['ipaddress']; ?></td>
										<td><?php echo $result['logindate']; ?></td>
										<td>
										<a href="login-info.php?id=<?php echo $result['id']; ?>" title="Delete" class="btn btn-primary btn-xs" onClick="return confirm('Are you sure to delete?');"> <i class="glyphicon glyphicon-trash"></i> </a>
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

</body>
</html>
