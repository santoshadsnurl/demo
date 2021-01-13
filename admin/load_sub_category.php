<?php 

include('session.php');

if(isset($_REQUEST['sub_category_id']) && $_REQUEST['sub_category_id']!="")

{

	$sub_category_id = $_REQUEST['sub_category_id'];

	$sqlm = "SELECT * FROM sub_sub_categories WHERE sub_category_id='$sub_category_id' AND status = 1";

?>  

	<select name="sub_sub_category_id" id="sub_sub_category_id" class="form-control">

		<option value="">--Select--</option>

		<?php

		if($rsm=$conn->query($sqlm))

		{

			$totalm = $rsm->num_rows;

			if($totalm > 0)

			{

				while($rs_mc_cnt2=$rsm->fetch_array(MYSQLI_ASSOC))

				{

				?>

					<option value="<?php echo $rs_mc_cnt2['id'];?>">&nbsp;&nbsp;<?php echo $rs_mc_cnt2['title'];?></option>

				<?php

				}

			}

			else

			{

			?>

				<option value="" style="color:red;">&nbsp;Sub Sub Category Not Available</option>

			<?php

			}

		}

		?>

	</select>

<?php

}

else

{

?>

	<select name="sub_sub_category_id" id="sub_sub_category_id" class="form-control">

		<option value="">--Select--</option>

	</select>

<?php

}

?>