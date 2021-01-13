<?php include 'include/header.php';?>
<div class="body-content"> 
  
  <!-- /.body-content -->
  <div class="container">
    <section class="feedbackpage">
      <div class="row">
        <div class="col-xs-12">
          <h4 class="text-uppercase">Create review</h4>
        </div>
        <form action="">
          <div class="col-xs-9">
            <div class="feedspe rowarea"> <img src="assets/images/mobile.png" alt="mobile icon" class="img-responsive">
              <h4 class="specl">Redmi Note 8 (Neptune Blue, 4GB RAM, 64GB Storage)</h4>
            </div>
            <div class="feedspe rowarea">
              <h4>Overall rating</h4>
              <div class="rating"> <span class="fa fa-star" id="star1" onclick="add(this,1)"></span> <span class="fa fa-star" id="star2" onclick="add(this,2)"></span> <span class="fa fa-star" id="star3" onclick="add(this,3)"></span> <span class="fa fa-star" id="star4" onclick="add(this,4)"></span> <span class="fa fa-star" id="star5" onclick="add(this,5)"></span> </div>
            </div>
            <div class="feedspe rowarea">
              <h4>Add a photo or video</h4>
              <p>Shoppers find images and videos more helpful then text alone.</p>
              <label for="img">Select image:</label>
              <input type="file" id="img" name="img" accept="image/*">
            </div>
            <div class="feedspe rowarea nobor">
              <h4>Add a headline</h4>
              <input type="text" placeholder="What's more important to know" class="form-control">
            </div>
            <div class="feedspe rowarea nobor">
              <h4>Write your review</h4>
              <input type="text" placeholder="What did you like or dislike? what did you use this product for?" class="form-control form-control-spcl ">
            </div>
            
            
            <button class="btn btn-warning btn-blues">submit review</button>
          </div>
          
          
          
          
          
          
          
        </form>
      </div>
    </section>
  </div>
</div>
<script>
  function add(ths,sno){
  for (var i=1;i<=5;i++){
  var cur=document.getElementById("star"+i)
  cur.className="fa fa-star"
  }
  for (var i=1;i<=sno;i++){
  var cur=document.getElementById("star"+i)
  if(cur.className=="fa fa-star")
  {
  cur.className="fa fa-star checked"
  }
  }
  }
  </script>
<?php include 'include/footer.php';?>
