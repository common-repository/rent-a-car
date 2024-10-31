<?php require_once('../../../../wp-load.php'); 
header('Content-type: text/javascript; charset=utf-8');
?>
var cr_admin ={

	new_c:function(){
		dimBox.settings.content = "<div id='e_div'></div>";
		dimBox.loadDimBox('50');
		jQuery('#e_div').load('<?php echo CR_PLUGIN_FORMS_URL.'/new_car.php'; ?>');
		dimBox.showDimmer();
	},
	
	edit_c:function(id){
		dimBox.settings.content = "<div id='e_div'></div>";
		dimBox.loadDimBox('50');
		jQuery('#e_div').load('<?php echo CR_PLUGIN_FORMS_URL.'/new_car.php?id='; ?>'+id);
		dimBox.showDimmer();
	}
};
