<?php
	
include('session.php');

/* set variable */

$pagename = "Compose Mail";
$pagetaskname = " Send ";

/* set var blank */

$id = "";
$msg = "";	
$subject = "";
$message = "";

/* get id */

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$subject = ucwords(addslashes(trim($_POST['subject'])));
	$message = $_POST['message'];
	$from =  $newobject->getInfo($conn,"admin","contact_id",1);
	
	$query = "SELECT * FROM subscribers";
	if($sql_query = $conn->query($query))
	{
		if($sql_query->num_rows>0)
		{
			while($result = $sql_query->fetch_array(MYSQLI_ASSOC))
			{
				
				$to = $result['email'];
				
				$email_message =  '<html>
							<head>
								<title>'.$subject.'</title>
							</head>
							<body>
							<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
								<tbody>
									<tr>
										<td valign="top" style="padding:0in 0in 0in 0in">
										<div>
											<p align="center" style="margin-top:0in;text-align:center"><img src="'.$site_root.'images/logo.png" alt="Alaat" class="CToWUd"><u></u><u></u></p>
										</div>
										<div align="center">
										<table border="1" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#fdfdfd;border:solid gainsboro 1.0pt;border-radius:3px!important">
										<tbody>
									</tr>
									<td valign="top" style="border:none;padding:0in 0in 0in 0in">
									<div align="center">
									<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#557da1;border-radius:3px 3px 0 0!important">
									<tbody>
									<tr>
									<td style="padding:10.0pt .5in 27.0pt .5in">
										<h1 style="margin:0in;margin-bottom:.0001pt;line-height:150%"><span style="font-size:22.5pt;line-height:150%;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:white;font-weight:normal">'.$subject.'<u></u><u></u></span></h1>
									</td>
									</tr>
								</tbody>
							</table>
								</div>
								</td>
								</tr>
								<tr>
								<td valign="top" style="border:none;padding:0in 0in 0in 0in">
								<div align="center">
								<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in">
								<tbody>
								<tr>
								<td valign="top" style="background:#fdfdfd;padding:0in 0in 0in 0in">
								<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
								<tbody>
								<tr>
								<td valign="top" style="padding:.5in .5in .5in .5in">
								<p style="margin-right:0in;margin-bottom:12.0pt;margin-left:0in;line-height:150%"><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#737373">
								'.$message.'.</p>
								</td>
								</tr>
									</tbody>
									</table>
									</td>
								</tr>
									</tbody>
									</table>
							</div>
							</td>
							</tr>
							<tr>
								<td valign="top" style="border:none;padding:0in 0in 0in 0in">
									<div align="center">
										<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in">
											<tbody>
												<tr>
													<td valign="top" style="padding:0in 0in 0in 0in">
														<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
															<tbody>
																<tr>
																	<td style="padding:0in .5in .5in .5in">
																		<p align="center" style="text-align:center;line-height:125%"><span style="font-size:9.0pt;line-height:125%;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#99b1c7"><a href='.$site_root.'>Alaat</a><u></u><u></u></span></p>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</td>
							</tr>
							</tbody>
							</table>
							</div>
							</td>
							</tr>
							</tbody>
						</table>
					</body>
				</html>';
				/* echo $email_message;
				exit; */
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From:<".$from."> \r\n";
				
				@mail($to, $subject, $email_message, $headers);
			}
			$_SESSION['response'] = "Mail has been sent";
			echo "<script>document.location.href='subscribers_mgmt.php';</script>";
			exit;
		}
		else
		{
			$msg = "There is no any email id to sent mail";
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
	<?php include('includes/customer-left.php'); ?>	
	</div>
	<div class="right-section">
		<div class="dashboard-bar">
		<h2 class="headn-h2">Customers</h2>
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
					<h3 class="panel-title">Compose Mail</h3>
					</div>
					<div class="panel-body" style="padding:30px;">
						<form method="post" name="<?php echo strtolower($pagename); ?>" id="subscribers" enctype="multipart/form-data">
							<div class="form-group">
								<label for="exampleInputEmail1">Subject</label>
								<input type="text" class="form-control" id="subject" name="subject" title="Please Enter Subject" value="<?php echo $subject; ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Message</label>
								<textarea class="form-control" rows="5" id="message" name="message" title="Please Enter Message"><?php echo $message; ?></textarea>
							</div>
							<button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
							<a href="subscribers_mgmt.php" class="btn btn-primary pull-right">Cancel</a>
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
$("#subscribers").validate(
{
	rules: 
	{
		subject: 
		{
			required: true,
		},		  
		message:
		{
			required:true
		},
	},
	messages: {

		   }
});
</script>

</body>
</html>
