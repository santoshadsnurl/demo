<?php 

include('config/function.php');

$response =""; 
$error =""; 

if(isset($_POST['submitcontact']))
{	
	$name = trim($_REQUEST['name']);
	$email = trim($_REQUEST['email']);
	$phone = trim($_REQUEST['phone']);
	$comment = trim($_REQUEST['comment']);

	$message =  '<html>
					<head>
						<title>Contact Us</title>
					</head>
					<body>
					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
						<tbody>
							<tr>
								<td valign="top" style="padding:0in 0in 0in 0in">
								<div>
									<p align="center" style="margin-top:0in;text-align:center"><img src="'.$site_root.'images/logo.png" alt="Ramanta" class="CToWUd"><u></u><u></u></p>
								</div>
								<div align="center">
								<table border="1" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#fdfdfd;border:solid gainsboro 1.0pt;border-radius:3px!important">
								<tbody>
							</tr>
							<td valign="top" style="border:none;padding:0in 0in 0in 0in">
							<div align="center">
							<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#E46E00;border-radius:3px 3px 0 0!important">
							<tbody>
							<tr>
							<td style="padding:10.0pt .5in 27.0pt .5in">
								<h1 style="margin:0in;margin-bottom:.0001pt;line-height:150%"><span style="font-size:22.5pt;line-height:150%;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:white;font-weight:normal">Contact Us<u></u><u></u></span></h1>
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
						<td valign="top" style="padding:.2in .2in .1in .5in">Name :</td>
						<td valign="top" style="padding:.2in .2in .1in .5in">'.$name.'</td>
						</tr>
						<tr>
						<td valign="top" style="padding:.1in .2in .1in .5in">Email :</td>
						<td valign="top" style="padding:.1in .2in .1in .5in">'.$email.'</td>
						</tr>
						<tr>
						<td valign="top" style="padding:.1in .2in .1in .5in">Contact No :</td>
						<td valign="top" style="padding:.1in .2in .1in .5in">'.$phone.'</td>
						</tr>
						<tr>
						<td valign="top" style="padding:.1in .2in .1in .5in">Message :</td>
						<td valign="top" style="padding:.1in .2in .1in .5in">'.$comment.'</td>
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
																<p align="center" style="text-align:center;line-height:125%"><span style="font-size:9.0pt;line-height:125%;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#99b1c7"><a href='.$site_root.'>Ramanta</a><u></u><u></u></span></p>
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
		/* echo $message;
		exit; */
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: < contact@ramanta.in >'. "\r\n";
		
		//$to  = "contact@ramanta.in"; // note the comma
		$to  = "santosh.sharma@adsandurl.com"; // note the comma

		$subject = 'Contact Us'; // subject
		
		$revert = @mail($to, $subject, $Message, $headers);
		
		if($revert)
		{
			$response = "Hi <strong>$name</strong> , Thank you for contacting us. Our team member will contact you as soon as possible. ";
		}
		else
		{
			$error = "Mailer Error: ";
		}
}
?>
<?php include 'include/header.php';?>
<div class="body-content bg-gray innerpagenor">
	<div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-inner">
				<ul class="list-inline list-unstyled">
					<li><a href="<?php echo $site_root; ?>">Home</a></li>
					<li class='active'>Contact</li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->
	<div class="container">
		<div class="contact-page">
			<div class="row">
				<?php if($response!="") { ?>
				<div class="alert alert-success"><?php echo $response; ?></div>
				<?php } ?>
				<?php if($error!="") { ?>
				<div class="alert alert-danger"><?php echo $error; ?></div>
				<?php } ?>
				<div class="col-md-12 contact-map outer-bottom-vs">
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13994.774384627093!2d77.1673988!3d28.7287016!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd407c9fb793fa8a1!2sRamanta%20Store!5e0!3m2!1sen!2sin!4v1596787271535!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
				</div>
				<div class="col-md-8 contact-form">
				<div class="col-md-12 contact-title">
					<h4>Contact Form</h4>
				</div>
				<form class="register-form" role="form" name="contactfrm" id="contactfrm" method="post">
				<div class="col-md-4">
					<div class="form-group">
					<label class="info-title" for="exampleInputName">Your Name <span>*</span></label>
					<input type="text" class="form-control unicase-form-control text-input" placeholder="<?php echo changelanguage($conn,"Only Alphabets Allowed","فقط الحروف الهجائية المسموح بها"); ?>" id="name" name="name">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					<label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
					<input type="email" class="form-control unicase-form-control text-input" id="email" name="email" placeholder="<?php echo changelanguage($conn,"Valid Email","صحيح البريد الإلكتروني"); ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					<label class="info-title" for="exampleInputTitle">Mobile Number <span>*</span></label>
					<input type="txet" class="form-control unicase-form-control text-input" placeholder="<?php echo changelanguage($conn,"Only Number Allowed","عدد الوحيد الذي سمح"); ?>" id="phone" name="phone">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
					<label class="info-title" for="exampleInputComments">Your Comments <span>*</span></label>
					<textarea class="form-control unicase-form-control" name="comment" placeholder="<?php echo changelanguage($conn,"Enter Message","اكتب رسالتك"); ?>"></textarea>
					</div>
				</div>
				<div class="col-md-12 outer-bottom-small m-t-20">
					<button type="submit" name="submitcontact" class="btn btn-blues">Send Message</button>
				</div>
				</form>
				</div>
				<div class="col-md-4 contact-info">
					<div class="contact-title">
						<h4>Information</h4>
					</div>
					<div class="clearfix address">
						<span class="contact-i"><i class="fa fa-map-marker"></i></span>
						<span class="contact-span">
		
				
				1179, 4th Floor, Block-B, Mangal Bazar Rd, Jahangirpuri, Delhi, 110033
				
				
				
				</span>
					</div>
					<div class="clearfix phone-no">
						<span class="contact-i"><i class="fa fa-mobile"></i></span>
						<span class="contact-span">+91-9205104267</span>
					</div>
					<div class="clearfix email">
						<span class="contact-i"><i class="fa fa-envelope"></i></span>
						<span class="contact-span"><a href="mailto:contact@ramanta.in">contact@ramanta.in</a></span>
					</div>
				</div>			
			</div><!-- /.contact-page -->
		</div><!-- /.row -->
	</div>
</div>
<?php include 'include/footer.php';?>
<script type="text/javascript">
$(document).ready(function() {
    $('#contactfrm').bootstrapValidator({
		//live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The name is required and cannot be empty'
                    }
                }
            },
            email: {
                validators: {
					notEmpty: {
						message: 'The email required and cannot be empty'
					},
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
			phone: {
                validators: {
                    notEmpty: {
						message: 'The Phone required and cannot be empty'
					},
                    digits: {
						message: 'The Phone must be digits '
					}
                }
            },
			comment: 
			{
				validators: 
				{
					stringLength: 
					{
						min: 10,
						max: 200,
						message:'Please enter at least 10 characters and no more than 200'
					},
					notEmpty: 
					{
						message: 'The message is required and cannot be empty'
					}
				}
			}
        }
    });
});
</script>