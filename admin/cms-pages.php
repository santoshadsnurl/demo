<?php

include('session.php');

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
					<?php if(isset($_SESSION['response'])) { ?> 
					<div class="alert alert-success fade in f">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $_SESSION['response']; unset($_SESSION['response']); ?>
					</div>
					<?php } ?>
					<div class="panel-heading">
					<h3 class="panel-title">Pages</h3>
					</div>
					<div class="panel-body">
						<ul class="list-none">
							<?php 
							$query = "SELECT * FROM pages WHERE status = 1";
							if($sql_query = $conn->query($query))
							{
								if($sql_query->num_rows>0)
								{
									while($result = $sql_query->fetch_array(MYSQLI_ASSOC))
									{
										?>
										<li><a href="pages.php?id=<?php echo $result['id']; ?>" ><?php echo $result['title']; ?> <span class="badge pull-right"><i class="glyphicon glyphicon-pencil"></i></span></a></li>
										<?php
									}
								}
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end here -->

</body>
</html>
