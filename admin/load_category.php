<?php 
include('session.php');
if(isset($_REQUEST['category_id']) && $_REQUEST['category_id']!="")
{
	$category_id = $_REQUEST['category_id'];
	$sqlm = "SELECT * FROM sub_categories WHERE category_id='$category_id' AND status = 1";
?>  
	<select name="sub_category_id" id="sub_category_id" class="form-control" onchange="getsubsubcat(this.value)">
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
				<option value="" style="color:red;">&nbsp;Category Not Available</option>
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
	<select name="sub_category_id" id="sub_category_id" class="form-control">
		<option value="">--Select--</option>
	</select>
<?php
}
?>