<?php



$fname = "";

$phone_no = "";



$query = "SELECT * FROM users WHERE email='".$_SESSION['user_name']."'";

if($sql_select = $conn->query($query))

{

	if($sql_select->num_rows>0)

	{

		$result = $sql_select->fetch_array(MYSQLI_ASSOC);

		$fname = $result['fname'];

		$lname = $result['lname'];

		$name = $fname.' '.$lname;

		$phone_no = $result['phone_no'];

	}

}



$urls = basename($_SERVER['PHP_SELF'],'.php');  

?>

<div class="sidebarmyaccount">
  <div class="myprofile">
    <div class="myprofileimg"> <img src="<?php echo $site_root; ?>assets/images/profile.png" class="img-responsive media-object"    alt="profile icon"> </div>
    <div class="myprofilename">
      <h4>Hello,</h4>
      <p><?php echo $name; ?></p>
    </div>
  </div>
  <div class="navaccount">
    <ul>
      <li <?php if($urls == 'my-account') { ?> class="active" <?php } ?>><a href="<?php echo $site_root; ?>my-account/"> <span> <img src="<?php echo $site_root; ?>assets/images/icon/order.png" alt="order"></span> My Account </a> </li>
      <li <?php if($urls == 'my-order') { ?> class="active" <?php } ?> ><a href="<?php echo $site_root; ?>my-order/"> <span> <img src="<?php echo $site_root; ?>assets/images/icon/order.png" alt="order icon"></span> My orders </a> </li>
      <li <?php if($urls == 'manage-address') { ?> class="active" <?php } ?>><a href="<?php echo $site_root; ?>manage-address/"> <span> <img src="<?php echo $site_root; ?>assets/images/icon/address.png" alt="address icon"></span> Manage Address </a> </li>
      <li <?php if($urls == 'my-wishlist') { ?> class="active" <?php } ?>><a href="<?php echo $site_root; ?>my-wishlist/"> <span> <img src="<?php echo $site_root; ?>assets/images/icon/wishlist2.png" alt="order icon"></span> Wishlist </a> </li>
      <li <?php if($urls == 'change-password') { ?> class="active" <?php } ?>><a href="<?php echo $site_root; ?>change-password/"> <span> <img src="<?php echo $site_root; ?>assets/images/icon/change-password.png" alt="password icon"></span> Change password </a> </li>
      <li><a href="<?php echo $site_root; ?>logout/"> <span> <img src="<?php echo $site_root; ?>assets/images/icon/logout.png" alt="logout icon"></span> Logout </a> </li>
    </ul>
  </div>
</div>
