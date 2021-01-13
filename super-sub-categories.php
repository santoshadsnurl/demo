<?php 

include('config/function.php'); 

if(isset($_REQUEST['alias']) && $_REQUEST['alias']!="")
{
	$alias = $_REQUEST['alias'];
	$sub_sub_category_id_categories = $newobject->getdata($conn,"sub_sub_categories","id","alias",$alias);
	$sub_category_id_list = $newobject->getdata($conn,"sub_sub_categories","sub_category_id","alias",$alias);
	$sub_category_title = $newobject->getdata($conn,"sub_categories","title","id",$sub_category_id_list);
	$category_id_list = $newobject->getdata($conn,"sub_sub_categories","category_id","alias",$alias);
	$category_title = $newobject->getdata($conn,"categories","title","id",$category_id_list);
	$sortby = "";
	$total_page = "";
	$addsubqry = "";
	$filter_category_id = "";
	$priceqry = "";
	$filter_category_ids = array();
	$price = array();
	$price_ids = array("","0 - 499","500 - 999","1000 - 1499","1500 - 1999","2000 - 5000");
	$orderby = " ORDER BY id DESC";
	$pageaction = $site_root."super-sub-categories/".$alias.'/';
	if(isset($_REQUEST['sortby']) && $_REQUEST['sortby']!="")
	{
		$sortby = $_REQUEST['sortby'];
		if($sortby == "lowtohigh")
		{
			$orderby = " ORDER BY price ASC ";
		}
		else if($sortby == "hightolow")
		{
			$orderby = " ORDER BY price DESC ";
		}
		else if($sortby == "newest")
		{
			$orderby = " ORDER BY id DESC ";
		}
		else if($sortby == "oldest")
		{
			$orderby = " ORDER BY id ASC ";
		}
		else if($sortby == "bestselling")
		{
			$orderby = " ORDER BY best_selling ASC ";
		}
		else if($sortby == "titlea")
		{
			$orderby = " ORDER BY title ASC ";
		}
		else if($sortby == "titled")
		{
			$orderby = " ORDER BY title DESC ";
		}
		else
		{
			$orderby = "";
		}
	}
	if(isset($_REQUEST['filter_category_id']) && $_REQUEST['filter_category_id']!="")
	{
		$filter_category_ids = $_REQUEST['filter_category_id'];
		for($i = 0; $i < count($filter_category_ids); $i++)
		{
			if($i==0)
			{
				$filter_category_id .= "'".$filter_category_ids[$i]."'";
			}
			else
			{
				$filter_category_id .= ','."'".$filter_category_ids[$i]."'";
			}
		}
		$addsubqry .= " AND category_id IN ($filter_category_id) ";
	}
	if(isset($_REQUEST['size']) && $_REQUEST['size']!="")
	{
		$sizes = $_REQUEST['size'];
		$ctr = 0;
		$var = "";
		foreach($sizes as $size)
		{
			if($ctr == 0)
			{
				$var .= " CONCAT(',', product_size, ',') LIKE '%,$size,%'";
			}
			else
			{
				$var .= " OR CONCAT(',', product_size, ',') LIKE '%,$size,%'";
			}
			$ctr++;
		}
		if($var!="")
		{
			$addsubqry .= " AND ($var )";
		}
	}
	if(isset($_REQUEST['color']) && $_REQUEST['color']!="")
	{
		$colors = $_REQUEST['color'];
		$ctr = 0;
		$var = "";
		foreach($colors as $color)
		{
			if($ctr == 0)
			{
				$var .= " CONCAT(',', product_color, ',') LIKE '%,$color,%'";
			}
			else
			{
				$var .= " OR CONCAT(',', product_color, ',') LIKE '%,$color,%'";
			}
			$ctr++;
		}
		if($var!="")
		{
			$addsubqry .= " AND ($var )";
		}
	}
	if(isset($_REQUEST['material']) && $_REQUEST['material']!="")
	{
		$materials = $_REQUEST['material'];
		$ctr = 0;
		$var = "";
		foreach($materials as $material)
		{
			if($ctr == 0)
			{
				$var .= " CONCAT(',', product_material, ',') LIKE '%,$material,%'";
			}
			else
			{
				$var .= " OR CONCAT(',', product_material, ',') LIKE '%,$material,%'";
			}
			$ctr++;
		}
		if($var!="")
		{
			$addsubqry .= " AND ($var )";
		}
	}
	if(isset($_REQUEST['department']) && $_REQUEST['department']!="")
	{
		$departments = $_REQUEST['department'];
		$ctr = 0;
		$var = "";
		foreach($departments as $department)
		{
			if($ctr == 0)
			{
				$var .= " CONCAT(',', product_department, ',') LIKE '%,$department,%'";
			}
			else
			{
				$var .= " OR CONCAT(product_department) LIKE '%,$department,%'";
			}
			$ctr++;
		}
		if($var!="")
		{
			$addsubqry .= " AND ($var )";
		}
	}
	if(isset($_REQUEST['style']) && $_REQUEST['style']!="")
	{
		$styles = $_REQUEST['style'];
		$ctr = 0;
		$var = "";
		foreach($styles as $style)
		{
			if($ctr == 0)
			{
				$var .= " CONCAT(',', product_style, ',') LIKE '%,$style,%'";
			}
			else
			{
				$var .= " OR CONCAT(product_style) LIKE '%,$style,%'";
			}
			$ctr++;
		}
		if($var!="")
		{
			$addsubqry .= " AND ($var )";
		}
	}
	if(isset($_REQUEST['fitment_type']) && $_REQUEST['fitment_type']!="")
	{
		$fitment_types = $_REQUEST['fitment_type'];
		$ctr = 0;
		$var = "";
		foreach($fitment_types as $fitment_type)
		{
			if($ctr == 0)
			{
				$var .= " CONCAT(',', product_fitment_type, ',') LIKE '%,$fitment_type,%'";
			}
			else
			{
				$var .= " OR CONCAT(product_fitment_type) LIKE '%,$fitment_type,%'";
			}
			$ctr++;
		}
		if($var!="")
		{
			$addsubqry .= " AND ($var )";
		}
	}
	if(isset($_REQUEST['price']) && $_REQUEST['price']!="")
	{
		$price = $_REQUEST['price'];
		$cntprice = count($price);
		for($a=0;$a<$cntprice;$a++)
		{
			if($price[$a]==1)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` <='499'";
				}
				else
				{
					$priceqry .= " or `price` <='499'";
				}
			}
			if($price[$a]==2)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` between 500 and 999";
				}
				else
				{
					$priceqry .= " or (`price` between 500 and 999)";
				}
			}
			if($price[$a]==3)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` between 1000 and 1499";
				}
				else
				{
					$priceqry .= " or (`price` between 1000 and 1499)";
				}
			}
			if($price[$a]==4)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` between 1500 and 1999";
				}
				else
				{
					$priceqry .= " or (`price` between 1500 and 1999)";
				}
			}
			if($price[$a]==5)
			{
				if($priceqry=="")
				{
					$priceqry .= " `price` >='2000' ";
				}
				else
				{
					$priceqry .= " or (`price` >='2000')";
				}
			}		
		}
		$priceqry =  " AND ( ".$priceqry.")";
	}
	/* pagination stat here */
	$pageno = 1;
	$pageshow = 15;
	if(isset($_REQUEST['pageno']) && ($_REQUEST['pageno']>0)) 
	{
		$pageno = $_REQUEST['pageno']; 
	}
	if(isset($_REQUEST['prodperpage']) && ($_REQUEST['prodperpage']>0)) 
	{
		$pageshow = $_REQUEST['prodperpage']; 
	}
	$query = "SELECT * FROM products WHERE sub_sub_category_id = '$sub_sub_category_id_categories' $addsubqry $priceqry AND status = '1' $orderby";
	$sql_query = $conn->query($query);
	if($TotalCnt = $sql_query->num_rows)
	{
		$total_page = ceil($TotalCnt/$pageshow); 
	}
	else
	{
		$total_page=0;
	}
	if(!isset($pageno) or $pageno==1)
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
		$next='<li><a href="javascript:ShowPage('.$nx.')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
	}
	else
	{
		$next="";
	}
	if($pageno>1)
	{
		$pr=($pageno-1);
		$pre='<li><a href="javascript:ShowPage('.$pr.')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
	}
	else
	{
		$pre="";
	}
	$limitvar = "LIMIT $st,$pageshow";
	$query_listing = "SELECT * FROM products WHERE sub_sub_category_id = '$sub_sub_category_id_categories' $addsubqry $priceqry AND status = '1' $orderby $limitvar";
	$categories_listing = $conn->query($query_listing);
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
		if($i==$pageno)
		{
			$page.='<li class="active"><a href="javascript:ShowPage('.$i.')">'.$i.'<span class="sr-only">(current)</span></a></li>';
		}
		else
		{
			$page.='<li><a href="javascript:ShowPage('.$i.')">'.$i.'<span class="sr-only">(current)</span></a></li>';		
		}
	}
}
else
{
	echo "<script>document.location.href='".$site_root."'</script>";
	exit;
}

include 'include/header.php';

?>
<script type="text/javascript" language="javascript">
function ShowPage(pageno)
{
	document.pageinfo.pageno.value=pageno;
	document.getElementById("pageinfo").action="<?php echo $pageaction;?>"+pageno+"/";
	document.forms["pageinfo"].submit();
}
</script>
<form name="pageinfo" id="pageinfo" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
	<input type="hidden" name="pageno" id="pageno" value="<?php echo $pageno; ?>" />
</form>
<div class="container"> 
  <!--container-->
  <div class="row"> 
    <!-- row-->
	<form name="sortbyfrm" id="sortbyfrm" method="post" action="">
    <div class="col-md-3 col-sm-6">
      <div class="sidebar"> 
        <!-- sidebar-->
        <div class="filter">
          <div class="filter-head">
            <h4 class="cate-heading"> Filters </h4>
            <a class="flear-all" href="javascript:void(0)"> CLEAR ALL </a> </div>
        </div>
		<?php
		$sub_sub_categories_list = $newobject->getconrecords($conn,"sub_sub_categories","sub_category_id = '$sub_sub_category_id_categories'");
		if($sub_sub_categories_list->num_rows>0)
		{
			?>
			<div class="side-box">
			<h4 class="cate-heading"> Sub Category </h4>
			<?php
			while($sub_sub_categories_list_result = $sub_sub_categories_list->fetch_array(MYSQLI_ASSOC))
			{
				$sub_category_id_categoriess = $sub_sub_categories_list_result['id'];
				?>
				<label class="checkbox"><a href="<?php echo $site_root; ?>super-sub-categories/<?php echo $sub_sub_categories_list_result['alias']; ?>/"><?php echo $sub_sub_categories_list_result['title'];?></a>
				(<?php echo $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_category_id_categoriess'"); ?>)
				</label>
				<?php
			}
			?>
			</div>
			<?php
		}
		?>
        <!--<div class="side-box">
          <h4 class="cate-heading"> CATEGORIES</h4>
            <?php
			if($categories_filte->num_rows>0)
			{
				while($categories_filte_result = $categories_filte->fetch_array(MYSQLI_ASSOC))
				{
					if(in_array($categories_filte_result['id'],$filter_category_ids))
					{ 
						$class ="active "; $checked = "checked "; }	else { $class =""; $checked =""; 
					}
					$ccc_id = $categories_filte_result['id'];
					$total_count = $newobject->getnumcondrows($conn,"products","category_id='$ccc_id'");
					?>
					<label class="checkbox"> <?php echo $categories_filte_result['title']; ?> <input name="filter_category_id[]" id="filter_category_id" type="checkbox" <?php echo $checked; ?> value="<?php echo $categories_filte_result['id']; ?>" onchange="javascript:document.getElementById('sortbyfrm').submit();" > <span class="checkmark ctg"></span>(<?php echo $total_count; ?>)</label>
					<?php
				}
			}
			?>
        </div>-->
        <div class="side-box">
          <h4 class="cate-heading"> PRICE</h4>
			<?php
			$arrlength = count($price_ids);
			for($x = 1; $x < $arrlength; $x++)
			{
				if(in_array($x,$price)) { $checked = "checked "; }	else { $checked =""; }
				?>
				<label class="checkbox"><input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="price[]" value="<?php echo $x; ?>" <?php echo $checked; ?> > Rs. <?php echo $price_ids[$x];?> <span class="checkmark ctg"></span> 
				(<?php $ddval = str_replace("-","AND",$price_ids[$x]); echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND price between $ddval "); ?>)
				</label>
				<?php
			}
			?>
        </div>
		<div class="side-box">
        <h4 class="cate-heading">SIZES</h4>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="size[]" <?php if(in_array("S",$sizes)){ echo "checked";}?> value="S">S
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_size, ',') LIKE '%,S,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="size[]" <?php if(in_array("M",$sizes)){ echo "checked";}?> value="M">M
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_size, ',') LIKE '%,M,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="size[]" <?php if(in_array("L",$sizes)){ echo "checked";}?> value="L">L
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_size, ',') LIKE '%,L,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="size[]" <?php if(in_array("XL",$sizes)){ echo "checked";}?> value="XL">XL
			  <span class="checkmark ctg"></span> (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_size, ',') LIKE '%,XL,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="size[]" <?php if(in_array("XXL",$sizes)){ echo "checked";}?> value="XXL">XXL
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_size, ',') LIKE '%,XXL,%' "); ?>)
			</label>
      </div>
	  <div class="side-box">
        <h4 class="cate-heading">COLORS</h4>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="color[]" <?php if(in_array("Red",$colors)){ echo "checked";}?> value="Red">Red
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_color, ',') LIKE '%,Red,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="color[]" <?php if(in_array("Green",$colors)){ echo "checked";}?> value="Green">Green
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_color, ',') LIKE '%,Green,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="color[]" <?php if(in_array("Blue",$colors)){ echo "checked";}?> value="Blue">Blue
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_color, ',') LIKE '%,Blue,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="color[]" <?php if(in_array("Black",$colors)){ echo "checked";}?> value="Black">Black
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_color, ',') LIKE '%,Black,%' "); ?>)
			  <span class="checkmark ctg"></span> 
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="color[]" <?php if(in_array("White",$colors)){ echo "checked";}?> value="White">White
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_color, ',') LIKE '%,White,%' "); ?>)
			  <span class="checkmark ctg"></span> 
			</label>
      </div>
	  <div class="side-box">
        <h4 class="cate-heading">MATERIAL</h4>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="material[]" <?php if(in_array("Velvet",$materials)){ echo "checked";}?> value="Velvet">Velvet
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_material, ',') LIKE '%,Velvet,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="material[]" <?php if(in_array("Denim",$materials)){ echo "checked";}?> value="Denim">Denim
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_material, ',') LIKE '%,Denim,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="material[]" <?php if(in_array("Muslin",$materials)){ echo "checked";}?> value="Muslin">Muslin
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_material, ',') LIKE '%,Muslin,%' "); ?>)
			</label>
      </div>
	  <div class="side-box">
        <h4 class="cate-heading">DEPARTMENT</h4>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="department[]" <?php if(in_array("Men",$departments)){ echo "checked";}?> value="Men">Men
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_department, ',') LIKE '%,Men,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="department[]" <?php if(in_array("Women",$departments)){ echo "checked";}?> value="Women">Women
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_department, ',') LIKE '%,Women,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="department[]" <?php if(in_array("Kids",$departments)){ echo "checked";}?> value="Kids">Kids
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_department, ',') LIKE '%,Kids,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="department[]" <?php if(in_array("Unisex",$departments)){ echo "checked";}?> value="Unisex">Unisex
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_department, ',') LIKE '%,Unisex,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="department[]" <?php if(in_array("Unisex Adult",$departments)){ echo "checked";}?> value="Unisex Adult">Unisex Adult
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_department, ',') LIKE '%,Unisex Adult,%' "); ?>)
			</label>
      </div>
	  <div class="side-box">
        <h4 class="cate-heading">Style</h4>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="style[]" <?php if(in_array("Car Antenna",$styles)){ echo "checked";}?> value="Car Antenna">Car Antenna
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_style, ',') LIKE '%,Car Antenna,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="style[]" <?php if(in_array("Bike Indicstors",$styles)){ echo "checked";}?> value="Bike Indicstors">Bike Indicstors
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_style, ',') LIKE '%,Bike Indicstors,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="style[]" <?php if(in_array("Arm Sleeve",$styles)){ echo "checked";}?> value="Arm Sleeve">Arm Sleeve
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_style, ',') LIKE '%,Arm Sleeve,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="style[]" <?php if(in_array("Protector Grill",$styles)){ echo "checked";}?> value="Protector Grill">Protector Grill
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_style, ',') LIKE '%,Protector Grill,%' "); ?>)
			</label>
      </div>
	  <div class="side-box">
        <h4 class="cate-heading">FITMENT TYPE</h4>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="fitment_type[]" <?php if(in_array("Universal",$fitment_types)){ echo "checked";}?> value="Universal">Universal
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_fitment_type, ',') LIKE '%,Universal,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="fitment_type[]" <?php if(in_array("Honda",$fitment_types)){ echo "checked";}?> value="Honda">Honda
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_fitment_type, ',') LIKE '%,Honda,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="fitment_type[]" <?php if(in_array("Bajaj",$fitment_types)){ echo "checked";}?> value="Bajaj">Bajaj
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_fitment_type, ',') LIKE '%,Bajaj,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="fitment_type[]" <?php if(in_array("Hero",$fitment_types)){ echo "checked";}?> value="Hero">Hero
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_fitment_type, ',') LIKE '%,Hero,%' "); ?>)
			</label>
			<label class="checkbox">
			  <input onChange="javascript:document.getElementById('sortbyfrm').submit();" type="checkbox" name="fitment_type[]" <?php if(in_array("Royal Enfield",$fitment_types)){ echo "checked";}?> value="Royal Enfield">Royal Enfield
			  <span class="checkmark ctg"></span> 
			  (<?php echo $total_count = $newobject->getnumcondrows($conn,"products","sub_sub_category_id = '$sub_sub_category_id_categories' AND CONCAT(',', product_fitment_type, ',') LIKE '%,Royal Enfield,%' "); ?>)
			</label>
      </div>
      </div>
      <!-- sidebar end--> 
    </div>
    <div class="col-md-9 col-ms-6">
	<?php 
	if($categories_listing->num_rows>0) 
	{
		?>
      <div class="product-right">
        <div class="custom-bread">
          <ol class="breadcrumb">
            <li><a href="<?php echo $site_root; ?>">Home</a></li>
            <li><a href="javascript:void(0);"><?php echo $category_title; ?></a></li>
            <li><a href="<?php echo $site_root; ?>sub-categories/<?php echo $newobject->getdata($conn,"sub_categories","alias","id",$sub_category_id_list); ?>/"><?php echo $sub_category_title; ?></a></li>
            <li class="active"> <?php echo $newobject->getdata($conn,"sub_sub_categories","title","alias",$alias); ?></li>
          </ol>
          <span class="showing"> (Showing <?php echo $st; ?>-<?php echo $pageshow; ?> Products of <?php echo $TotalCnt; ?> product)</span> </div>
        
        <!-- new product filter start here -->
        <section class="main-sorts">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-2 col-sm-2 col-xs-12 width10">
                <div class="sort_by">
                  <label>Sort By</label>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="sort_options">
                <select name="sortby" id="sortby" onchange="javascript:document.getElementById('sortbyfrm').submit();">
				  <option value="bestselling" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "bestselling") { echo "SELECTED"; } ?> >Best Selling</option>
				  <option value="lowtohigh" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "lowtohigh") { echo "SELECTED"; } ?> >Price - Low to High</option>
				  <option value="hightolow" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "hightolow") { echo "SELECTED"; } ?> >Price - High to Low</option>
				  <option value="newest" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "newest") { echo "SELECTED"; } ?> >Newest First</option>
				  <option value="oldest" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "oldest") { echo "SELECTED"; } ?> >Oldest First</option>
				  <option value="titlea" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "titlea") { echo "SELECTED"; } ?> >A - Z</option>
				  <option value="titled" <?php if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == "titled") { echo "SELECTED"; } ?> >Z - A</option>
				</select>
                </div>
              </div>
            </div>
          </div>
        </section>
		</form>
        <!-- new product filter start here -->
        
        <div class="products-section">
          <div class="row">
			<?php 
			while($categories_listing_result = $categories_listing->fetch_array(MYSQLI_ASSOC))
			{
				?>
            <div class="col-md-3 col-ms-4">
              <div class="product product-sec-item">
                <div class="product-image">
       <a href="<?php echo $site_root; ?>detail/<?php echo $categories_listing_result['alias']; ?>/"><img src="<?php echo $site_root; ?>uploads/products/<?php echo $categories_listing_result['image']; ?>" alt="#"></a> 
                </div>
                <div class="product-info text-left"> 
                  <h3 class="name"><a href="<?php echo $site_root; ?>detail/<?php echo $categories_listing_result['alias']; ?>/"><?php echo $categories_listing_result['title']; ?></a></h3>
                  <div class="product-price"> <span class="price"> ₹<?php echo $categories_listing_result['sale_price']; ?> </span> <span class="price-before-discount"> ₹ <?php echo $categories_listing_result['price']; ?></span> <span class="dis-off"> <?php echo number_format((100 - ($categories_listing_result['sale_price'] * (100/$categories_listing_result['price']))),0); ?>% Off </span> </div>
                  <div class="cat_ratings"> <a href="javascript:void(0)" class="exrates"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <span>100 Customer Ratings</span> </a>
                    <div class="custo_ratings">
                      <div class="thrats"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <span>4.5 Out Of 5</span>
                        <p>1,637 customer ratings</p>
                      </div>
                      <div class="ratings_progress">
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">5 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%"></div>
                          </div>
                          <div class="b_star col-xs-2">50%</div>
                        </div>
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">4 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:20%"></div>
                          </div>
                          <div class="b_star col-xs-2">20%</div>
                        </div>
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">3 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:10%"></div>
                          </div>
                          <div class="b_star col-xs-2">10%</div>
                        </div>
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">2 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width:5%"></div>
                          </div>
                          <div class="b_star col-xs-2">5%</div>
                        </div>
                        <div class="kits_ratings row">
                          <div class="a_star col-xs-3">1 Star</div>
                          <div class="progress col-xs-7">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width:15%"></div>
                          </div>
                          <div class="b_star col-xs-2">15%</div>
                        </div>
                        <hr class="hrsh">
                        <div class="showes_all"> <a href="javascript:void(0)">See all customer reviews <i class="fa fa-angle-right"></i></a> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<?php
			}
			?>
          </div>
        </div>
        <div class="custom-pagination">
          <div class="show-page"> Page <span>1</span> of <span> <?php echo $TotalCnt; ?> </span> </div>
          <ul class="pagination">
            <?php if($total_page>1) { echo $pre;?>&nbsp;<?php echo $page;?>&nbsp;<?php echo $next; } ?>
		  </div>
      </div>
		<?php
		}
		else
		{
			?>
			<div class="alert alert-danger" style="text-align:center; margin-top:50px;"><strong>There is no product in this category we are adding !</strong></div>
			<?php
		}
		?>
    </div>
  </div>
  <!--row end--> 
  
</div>
<!--container end-->
<?php include 'include/footer.php';?>