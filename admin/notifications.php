<?php

include('../config/function.php'); 

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
	header('location:login.php');
	exit();
}

if(isset($_POST['title']))
{
	/* echo "<pre>";
	print_r($_POST);
	exit; */
	require_once __DIR__ . '/notification.php';
	$notification = new Notification();

	$title = $_POST['title'];
	$message = isset($_POST['message'])?$_POST['message']:'';
	$imageUrl = isset($_POST['image_url'])?$_POST['image_url']:'';
	$action = isset($_POST['action'])?$_POST['action']:'';
	
	$actionDestination = isset($_POST['action_destination'])?$_POST['action_destination']:'';

	if($actionDestination ==''){
		$action = '';
	}
	$notification->setTitle($title);
	$notification->setMessage($message);
	$notification->setImage($imageUrl);
	$notification->setAction($action);
	$notification->setActionDestination($actionDestination);
	
	$firebase_token = $_POST['firebase_token'];
	$user_id = $newobject->getdata($conn,"users","id","fcm_token",$firebase_token);
	$firebase_api = $_POST['firebase_api'];
	
	$topic = $_POST['topic'];
	
	$requestData = $notification->getNotificatin();
	
	if($_POST['send_to']=='topic'){
		$fields = array(
			'to' => '/topics/' . $topic,
			'data' => $requestData,
		);
		
	}else{
		
		$fields = array(
			'to' => $firebase_token,
			'data' => $requestData,
		);
	}		

	// Set POST variables
	$url = 'https://fcm.googleapis.com/fcm/send';

	$headers = array(
		'Authorization: key=' . $firebase_api,
		'Content-Type: application/json'
	);
	
	// Open connection
	$ch = curl_init();

	// Set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// Disabling SSL Certificate support temporarily
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

	// Execute post
	$result = curl_exec($ch);
	
	if($result === FALSE){
		die('Curl failed: ' . curl_error($ch));
	}

	// Close connection
	curl_close($ch);
	
	/* echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
	echo json_encode($fields,JSON_PRETTY_PRINT);
	echo '</pre></p><h3>Response </h3><p><pre>';
	echo $result;
	echo '</pre></p>';
	//exit; */
	$result_data = json_decode($result);
	if($_POST['send_to']=='sngle'){
	$result_data->success;
	if($result_data->success==1)
	{
		$query = "INSERT INTO notifications SET server_key = '".$firebase_api."', date = now(), user_id = '".$user_id."' , topic = 'Janaral' , firebase_token = '".$firebase_token."' , title = '".$fields['data']['title']."', message = '".$fields['data']['message']."' , image = '".$fields['data']['image']."', action = '".$fields['data']['action']."', action_destination = '".$fields['data']['action_destination']."'";
		if($sql_query = $conn->prepare($query))
		{
			$sql_query->execute();
			$_SESSION['response'] = "Notification Send Successfully.";	
			echo "<script>document.location.href='notifications_mgmt.php';</script>";
			exit;
		}
	}
	}
	if($_POST['send_to']=='topic'){
	$query_users_san = "SELECT * FROM users WHERE status = 1 AND fcm_token!='' ORDER BY id DESC";
	if($stmt_users_san = $conn->query($query_users_san))
	{
		if($stmt_users_san->num_rows>0)
		{
			while($r_users_san = $stmt_users_san->fetch_array(MYSQLI_ASSOC))
			{
				$query = "INSERT INTO notifications SET server_key = '".$firebase_api."', topic = '".$topic."', date = now(), user_id = '".$r_users_san['id']."', firebase_token = '".$r_users_san['fcm_token']."', title = '".$fields['data']['title']."', message = '".$fields['data']['message']."' , image = '".$fields['data']['image']."', action = '".$fields['data']['action']."', action_destination = '".$fields['data']['action_destination']."'";
				if($sql_query = $conn->prepare($query))
				{
					$sql_query->execute();
				}
			}
			$_SESSION['response'] = "Notification Send Successfully.";	
			echo "<script>document.location.href='notifications_mgmt.php';</script>";
			exit;
		}
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
		<a href="index.php" title=""><img src="images/logo.png" alt="logo" class="img-responsive"></a>
		<h3 class="headn-h3">Admin Panel</h3>
		<div class="bs-example" data-example-id="simple-nav-stacked">
			<ul class="nav nav-pills nav-stacked nav-pills-stacked-example">
				<li role="presentation" class="active"><a href="notifications_mgmt.php">Notifications</a></li>
			</ul>
		</div>
		<div class="develop">
			<div class="row">
			<div class="col-sm-6">
			<p>Developed By: </p>
			</div>
			<div class="col-sm-6"> <a href="javascript:void(0);"><img src="images/logo.png" alt="logo" class="img-responsive"></a> </div>
			</div>
		</div>
	</div>
	<div class="right-section">
		<div class="dashboard-bar">
			<h2 class="headn-h2">Notifications</h2>
		</div>
		<div class="main-section">
			<div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					<h3 class="panel-title">Notifications</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="container">
								<div class="row">
									<div class="col-lg-6">
										<h2>Send Firebase Push Notification</h2>
										<hr/>
										<form action="" method="post">
											<div class="form-group">
												<label for="send_to">Send To:</label>
												<select name="send_to" id="send_to" class="form-control">
													<option value="sngle">Single Device</option>
													<option value="topic">Topic</option>
												</select>
											</div>
											<input type="hidden" name="firebase_api" value="AIzaSyDkTjrsq6x4o8Xh5qj7pdIKO_bSMhTf4k8">
											<div class="form-group" id="firebase_token_group">
												<label for="firebase_token">User:</label>
												<select name="firebase_token" id="firebase_token" class="form-control" required>
												<option value="">--Select--</option>
												<?php
												$query_users = "SELECT * FROM users WHERE status = 1 AND fcm_token!='' ORDER BY id DESC";
												if($stmt_users = $conn->query($query_users))
												{
													while($r_users = $stmt_users->fetch_array(MYSQLI_ASSOC))
													{
														?>
														<option value="<?php echo $r_users['fcm_token'];?>"><?php echo ucwords($r_users['name']);?></option> 	
														<?php 
													} 
												} 
												?>
												</select>
											</div>
											<div class="form-group" style="display: none" id="topic_group">
												<label for="topic">Topic Name:</label>
												<input type="text" class="form-control" id="topic" placeholder="Enter Topic Name" name="topic">
											</div>
											<div class="form-group">
												<label for="title">Title:</label>
												<input type="text" required="" class="form-control" id="title" placeholder="Enter Notification Title" name="title">
											</div>
											<div class="form-group">
												<label for="message">Message:</label>
												<textarea required="" class="form-control" rows="5" id="message" placeholder="Enter Notification Message" name="message"></textarea>
											</div>
											<div class="checkbox">
												<label><input type="checkbox"id="include_image" name="include_image">Include Image</label>
											</div>
											<div class="form-group" style="display: none" id="image_url_group">
												<label for="image_url">Image URL:</label>
												<input type="url" class="form-control" id="image_url" placeholder="Enter Image URL" name="image_url">
											</div>
											<div class="checkbox">
												<label><input type="checkbox" id="include_action" name="include_action">Include Action</label>
											</div>
											<div class="form-group" style="display: none" id="action_group">
												<label for="action">Action:</label>
												<select name="action" id="action" class="form-control">
													<option value="url">Open URL</option>
													<option value="activity">Open Activity</option>
												</select>
											</div>
											<div class="form-group" style="display: none" id="action_destination_group">
												<label for="action_destination">Destination:</label>
												<input type="text" class="form-control" id="action_destination" placeholder="Enter Destination URL or Activity name" name="action_destination">
											</div>
											<button type="submit" class="btn btn-primary">Submit</button>
										</form>
									</div>
								</div>
							</div>
							
							<script>
								$('#include_image').change(function(e){
										if($(this).prop("checked")==true){
											$('#image_url_group').show();
											$("#image_url").prop('required',true);
										}else{
											$('#image_url_group').hide();
											$("#image_url").prop('required',false);
										
										
										}
									});
								$('#include_action').change(function(e){
										if($(this).prop("checked")==true){
											$('#action_group').show();
											$('#action_destination_group').show();
											$("#action_destination").prop('required',true);
										}else{
											$('#action_group').hide();
											$('#action_destination_group').hide();
											$("#action_destination").prop('required',false);
										
										
										}
									});
									
								$('#send_to').change(function(e){
										var selectedVal = $("#send_to option:selected").val();
										if(selectedVal=='topic'){
											$('#topic_group').show();
											$("#topic").prop('required',true);
											$('#firebase_token_group').hide();
											$("#firebase_token").prop('required',false);
										}else{
											$('#topic_group').hide();
											$("#topic").prop('required',false);
											$('#firebase_token_group').show();
											$("#firebase_token").prop('required',true);
										}
									});
							</script>
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
