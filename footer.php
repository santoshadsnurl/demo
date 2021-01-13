<!-- ======== FOOTER ======== -->

<footer id="footer" class="footer color-bg">
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-2">
          <div class="module-heading">
            <h4 class="module-title"> Also buy from</h4>
          </div>
          <div class="module-body m-t-10">
            <ul class="list-unstyled">
              <li class="first"><a href="https://www.amazon.in/s?k=Ramanta&ref=bl_dp_s_web_15096015031" target="_blank"> Amazon</a></li>
              <li><a href="https://www.flipkart.com/search?q=ramanta&as=on&as-show=on&otracker=AS_Query_HistoryAutoSuggest_1_7_na_na_na&otracker1=AS_Query_HistoryAutoSuggest_1_7_na_na_na&as-pos=1&as-type=HISTORY&suggestionId=ramanta&requestId=8c440d6b-9c1e-4ab3-b35f-758b32823b4d&as-searchtext=ramanta" target="_blank">Flipkart</a></li>
              <li><a href="http://ramanta-store.shopclues.com" target="_blank">Shopclues </a></li>
              <li class="last"><a href="javascript:void(0);"> </a></li>
            </ul>
          </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-7">
          <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
              <div class="module-heading">
                <h4 class="module-title">Contact Us</h4>
              </div>
              <!-- /.module-heading -->
              
              <div class="module-body">
                <ul class="list-unstyled">
                  <li class="first"><a href="tel:+919205104267"><span> <img src="<?php echo $site_root; ?>assets/images/phone-icon.png" alt="phone"> </span> +91-9205104267</a></li>
                  <li><a href="mailto:contact@ramanta.in"><span> <img src="<?php echo $site_root; ?>assets/images/msg-icon.png" alt="phone"> </span> contact@ramanta.in</a></li>
                </ul>
              </div>
              <!-- /.module-body --> 
            </div>
            <!-- /.col -->
            
            <div class="col-xs-12 col-sm-4 col-md-4">
              <div class="module-heading">
                <h4 class="module-title">Policies &amp; info</h4>
              </div>
              <!-- /.module-heading -->
              
              <div class="module-body">
                <ul class="list-unstyled">
                  <li class="first"><a href="<?php echo $site_root; ?>terms-conditions/"> Terms &amp; Conditions </a></li>
                  <li><a href="<?php echo $site_root; ?>privacy-policy/"> Privacy Policy</a></li>
                  <li><a href="<?php echo $site_root; ?>about/">About</a></li>
                  <li><a href="<?php echo $site_root; ?>contact/">Contact Us </a></li>
                  <li class="last"><a href="<?php echo $site_root; ?>faq/">FAQ </a></li>
                </ul>
              </div>
              <!-- /.module-body --> 
            </div>
            <!-- /.col -->
            
            <div class="col-xs-12 col-sm-4 col-md-4">
              <div class="module-heading">
                <h4 class="module-title">Help</h4>
              </div>
              <!-- /.module-heading -->
              
              <div class="module-body">
                <ul class="list-unstyled">
                  <?php 
				$shop_online = $newobject->getallrecords($conn,"shop_online","ORDER BY id");
				if($shop_online->num_rows>0)
				{
					while($shop_online_result = $shop_online->fetch_array(MYSQLI_ASSOC))
					{
						?>
                  <li><a href="<?php echo $site_root; ?>help/<?php echo $shop_online_result['alias']; ?>/"><?php echo $shop_online_result[$arabic.'title']; ?></a></li>
                  <?php
					}
				}
				?>
                </ul>
              </div>
              <!-- /.module-body --> 
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3">
          <div class="module-heading">
            <h4 class="module-title"> Offline Store </h4>
          </div>
          <!-- /.module-heading -->
          
          <div class="offline_mpa">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13994.774384627093!2d77.1673988!3d28.7287016!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd407c9fb793fa8a1!2sRamanta%20Store!5e0!3m2!1sen!2sin!4v1596787271535!5m2!1sen!2sin" width="100%" height="150" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
          </div>
          <!-- /.module-body --> 
        </div>
      </div>
    </div>
  </div>
  <div class="copyright-bar">
    <div class="container">
      <div class="col-xs-12 col-sm-4 no-padding">
        <div class="clearfix">
          <ul class="crpanel">
            <li>"SHIPPING PARTNERS FEDEX, DELHIVERY &amp; DTDC"</li>
            <li class="text-white foocopyright">Copyright © 2020 SR TRADERS all rights reserved </li>
          </ul>
        </div>
        <!-- /.payment-methods --> 
      </div>
      <div class="col-xs-12 col-sm-4 no-padding social">
        <div class="payments_icon"> <img src="http://projects.adsandurl.com/ramanta/assets/images/Payment-Icons.png" class="img-responsive" alt="payment icon"> </div>
      </div>
      <div class="col-xs-12 col-sm-4 no-padding social">
        <ul class="link">
          <li class="fb pull-left"><a target="_blank" rel="nofollow" href=" https://www.facebook.com/RamantaStore/" title="Facebook"></a></li>
          <li class="tw pull-left"><a target="_blank" rel="nofollow" href=" https://twitter.com/RamantaStore" title="Twitter"></a></li>
          <li class="linkedin pull-left"><a target="_blank" rel="nofollow" href="https://in.linkedin.com/in/ramantastore" title="Linkedin"></a></li>
          <li class="instagram pull-left"><a target="_blank" rel="nofollow" href="https://www.instagram.com/ramantastore" title="Instagram"></a></li>
          <li class="youtube pull-left"><a target="_blank" rel="nofollow" href="https://www.youtube.com/channel/UCrgcGLJyaVr2NtkIk74WRXw" title="Youtube"></a></li>
        </ul>
      </div>
    </div>
  </div>
  
  <!-- whatsapp start here -->
  <div class="fixed_chat_whatsapp"> <a href="javascript:void(0)"  title="Message us">
    <div role="button" tabindex="0" type="bubble" class="Bubble__BubbleComponent">
      <div class="Icon__ComponentBubble"> <img src="<?php echo $site_root;?>assets/images/whatsapp2.png"> </div>
    </div>
    </a> </div>
  <!-- whatsapp start here --> 
  
</footer>
<form name="Cart" id="Cart" action="<?php echo $site_root;?>cartprogress/" method="post">
  <input type="hidden" name="proceed" id="proceed" value="" />
  <input type="hidden" name="product_id" id="product_id" value="" />
</form>
<script src="<?php echo $site_root; ?>assets/js/functions.js"></script> 
<script src="<?php echo $site_root; ?>assets/js/owl.carousel.min.js"></script> 
<script src="<?php echo $site_root; ?>assets/js/jquery.easing-1.3.min.js"></script> 
<script  src="<?php echo $site_root; ?>assets/js/lightbox.min.js"></script> 
<script src="<?php echo $site_root; ?>assets/js/wow.min.js"></script> 
<script src="<?php echo $site_root; ?>assets/js/scripts.js"></script> 
<script src="<?php echo $site_root; ?>assets/js/mmenu-light.js"></script> 
<script>

$('.mobile_menu').click(function(){

  $('#menu').css('display',"block");
});
</script> 

<!--
<script src="<?php echo $site_root; ?>assets/js/right.js"></script> --> 

<script>
	$(document).ready(function (){		
		$('#cat2').click(function(){
         $('.blok2').slideToggle();  
		 	  $('.blok').hide();        
         });
	});
	</script> 
    
    <!--
<script>

$(document).ready(function(){
$('.toggleli').on('click', function(){
  $(this).toggleClass('opened_menu');
});
});


</script> -->

<script>

$(document).ready(function(){
$('.toggleli').on('click', function(){
 	$('.toggleli').removeClass('opened_menu');
  $(this).toggleClass('opened_menu');
   
});
});

</script>








</body></html>