<?php require_once('../../../../wp-load.php'); ?>
<?php
if(isset($_REQUEST['id'])){
	$car = car_rental::edit_car_form($_REQUEST['id']);
}
?>

<form  enctype="multipart/form-data" method="POST" action="<?php echo admin_url( 'admin.php?page=car-rental-cars' ); ?>">
	<input type="hidden" name="action" id="action" value="wp_handle_upload" />
	<table width="100%" border="0">
		<?php
		if(isset($car)){
			$tim_url = CR_PLUGIN_URL . '/libs/timthumb.php?src='; 
			$tim_end = '&w=200&h=150&zc=1';
		?>
			<tr>
				<th width="100%" colspan="2" scope="row"><img src="<?php echo $tim_url.$car['image'].$tim_end; ?>" ></th>
			</tr>
		<?php }?>
		<tr>
			<th width="28%" scope="row"><?php if(isset($car)){ echo 'Change ';}?>Image</th>
			<td width="72%"><input type="file" name="car_img" /></td>
		</tr>
		<tr>
			<th scope="row">Name</th>
			<td><input type="text" name="carname" value="<?php echo $car['name'];?>"/></td>
		</tr>
		<tr>
			<th scope="row">Price Per hour</th>
			<td><input type="text" name="price" value="<?php echo $car['price']; ?>"/></td>
		</tr>
		<tr>
			<th scope="row">Description</th>
			<td><textarea name="car_desc" style="width:300px; height:200px"><?php echo $car['description']; ?></textarea></td>
		</tr>
		<tr>
			<th scope="row">&nbsp;</th><td><input type="submit" value="Save" /></td>
		</tr>
	</table>
</form>