<?php
/*
///////////////////////////////////////////////
this section handles uploading images, adding
the image data to the database, deleting images,
and deleting image data from the database.
\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
*/
//	this function handles the file upload,
//	resize/crop, and adds the image data to the db
function cr_handle_upload() {
	//	upload the image
	$upload = wp_handle_upload($_FILES['car_img'], 0);
	
	//	extract the $upload array
	extract($upload);
	
	//	the URL of the directory the file was loaded in
	$upload_dir_url = str_replace(basename(''.$file), '', ''.$url);
	//	if the uploaded file is NOT an image
	if(strpos($type, 'image') === FALSE) {
		@unlink($file); // delete the file
		echo '<div class="error" id="message"><p>Sorry, but the file you uploaded does not seem to be a valid image. Please try again.</p></div>';
		return;
	}
	


	
	//	use the timestamp as the array key and id
	$time = date('YmdHis');
	
	//	add the image data to the array
	$cr_cars[$time] = array(
		'id' => $time,
		'file' => $file,
		'file_url' => $url
	);
	return $url;
}

function cr_delete_upload($file_id){
}
?>