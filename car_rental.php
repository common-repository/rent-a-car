<?php
/*
Plugin Name: Rent A Car
Description: Car Rental and management plugin
Version: 1.0
Author: Paul Kevin
Author URI: http://riswolde.com/
*/

define('CR_PLUGIN_URL', WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));
define('CR_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.dirname(plugin_basename(__FILE__)));

define('CR_PLUGIN_PHP_DIR', CR_PLUGIN_DIR.'/php');
define('CR_PLUGIN_FORMS_DIR', CR_PLUGIN_DIR.'/forms');

define('CR_PLUGIN_FORMS_URL', CR_PLUGIN_URL.'/forms');

add_action('admin_menu', 'cr_create_admin_menu');
add_action('admin_init', 'car_rental_register_settings');
add_action("plugins_loaded", "cr_init_views");
add_action('init', 'cr_styles_scripts');

function cr_init_views(){
	register_sidebar_widget(__('Car Rental Form'), 'widgetform');
	add_shortcode('car_rental', 'orderform');
}

if ( function_exists( 'register_theme_directory') )
	register_theme_directory( CR_PLUGIN_DIR . '/car_rental_theme' );

function cr_styles_scripts() {
	
	if(!is_admin()){
		wp_register_style('cr_datepicker', CR_PLUGIN_URL .'/css/datepicker.css', false, '1.0', 'screen');
		wp_register_style('cr_layout', CR_PLUGIN_URL .'/css/layout.css', false, '1.0', 'screen');
		
		wp_enqueue_script('cr_datepicker_js', CR_PLUGIN_URL.'/js/datepicker.js', array('jquery'), '', false);
		wp_enqueue_script('cr_eye_js', CR_PLUGIN_URL.'/js/eye.js', array('jquery'), '', false);
		wp_enqueue_script('cr_utils_js', CR_PLUGIN_URL.'/js/utils.js', array('jquery'), '', false);
		wp_enqueue_script('cr_layout_js', CR_PLUGIN_URL.'/js/layout.js?ver=1.0.2', array('jquery'), '', false);
		
		wp_enqueue_script('cr_datepicker_js');
		wp_enqueue_script('cr_eye_js');
		wp_enqueue_script('cr_utils_js');
		wp_enqueue_script('cr_layout_js');
		
        wp_enqueue_style('cr_datepicker');
		wp_enqueue_style('cr_layout');
		
	}else{
		wp_register_style('cr_admin', CR_PLUGIN_URL .'/css/cr_admin.css', false, '1.0', 'screen');
		wp_register_style('dimbox_css', CR_PLUGIN_URL .'/css/dimbox.css', false, '1.0', 'screen');
		wp_enqueue_script('dimbox_js', CR_PLUGIN_URL.'/js/dimbox.js', array('jquery'), '', false);
		wp_enqueue_script('tabber_js', CR_PLUGIN_URL.'/js/tabber-minimized.js', array('jquery'), '', false);
		wp_register_style('tabber_css', CR_PLUGIN_URL .'/css/tabber.css', false, '1.0', 'screen');
		wp_enqueue_script('cr_admin', CR_PLUGIN_URL.'/js/cr_admin.php', array('jquery'), '', false);
		
		
		wp_enqueue_script('dimbox_js');
		wp_enqueue_script('cr_admin');
        wp_enqueue_style('dimbox_css');
		wp_enqueue_script('tabber_js');
		wp_enqueue_style('tabber_css');
		wp_enqueue_style('cr_admin');
		
	}
}


function load($dir){
	$controllers = array();
	
	if ( !is_dir( $dir ) )
  		return;
  	if ( ! $dh = opendir( $dir ) )
  		return;
  	while ( ( $plugin = readdir( $dh ) ) !== false ) {
  		if ( substr( $plugin, -4 ) == '.php' )
  			$controllers[] = $dir . '/' . $plugin;
  	}
  	
  	closedir( $dh );
  	sort( $controllers );
  	
  	foreach ($controllers as $file)
     	 include( $file );
}

load(CR_PLUGIN_PHP_DIR);

global $cr_info;
if(!isset($cr_info)){
	$cr_info = new cr_info();
}


//Create admin menu
function cr_create_admin_menu() {
	add_object_page('Car Rental', 'Car Rental', 'manage_options', 'car-rental-sales', '', CR_PLUGIN_URL . '/images/menu_logo.png');
	
	add_submenu_page('car-rental-sales', 'Car Rental Sales', 'Sales', 'manage_options', 'car-rental-sales', 'car_rental_sales');
	add_submenu_page('car-rental-sales', 'Car Rental Cars', 'Cars', 'manage_options', 'car-rental-cars', 'car_rental_cars');
	add_submenu_page('car-rental-sales', 'Car Rental Settings', 'Settings', 'manage_options', 'car-rental-settings', 'car_rental_settings');
	
}

function car_rental_register_settings() {
	register_setting('car_rental_sales', 'car_rental_sales', 'car_rental_sales_validate');
	register_setting('car_rental_settings', 'car_rental_settings', 'car_rental_settings_validate');
}

function car_rental_sales(){
	global $cr_info;
	$cr_sales = $cr_info->get_cr_sales();
	?>
	<div class="wrap">
		<h2><div class="cr_hd"><div class="cr_sales_img" id="cr_hd_img">&nbsp;</div><div class="cr_sales_h2">Sales</div></div></h2>
		<?php if(is_array($cr_sales)) {?>
		<table width="100%" border="0" class="widefat">
		  <thead>
			<tr>
				<th width="6%" scope="col">ID</th>
				<th width="12%" scope="col">REF NO</th>
				<th width="15%" scope="col">CAR</th>
				<th width="18%" scope="col">FROM</th>
				<th width="18%" scope="col">TO</th>
				<th width="22%" scope="col">AMOUNT</th>
				<th width="9%" scope="col">PAID</th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach((array)$cr_sales as $car_sales => $sales) : ?>
			  <tr>
				<td align="left" valign="top"><?php echo $sales['id']; ?></td>
				<td align="left" valign="top"><?php echo $sales['ref']; ?></td>
				<td align="left" valign="top"><?php echo $sales['car']; ?></td>
				<td align="left" valign="top"><?php echo $sales['from']; ?></td>
				<td align="left" valign="top"><?php echo $sales['to']; ?></td>
				<td align="left" valign="top"><?php echo $sales['amount']; ?></td>
				<td align="left" valign="top"><?php echo $sales['paid']; ?></td>
			  </tr>
			<?php endforeach; ?>
		  </tbody>
		</table>
		<?php } else{
			echo '<h4>No Sales Recorded</h4>';
		}?>
	</div>
	<?php
}

function car_rental_cars(){
	global $cr_info;
	
	//	handle image upload, if necessary
	if($_REQUEST['action'] == 'wp_handle_upload'){
		$imageurl = cr_handle_upload();
		$desc = $_REQUEST['car_desc'];
		$price = $_REQUEST['price'];
		$name = $_REQUEST['carname'];
		$time = date('YmdHis');
		$cr_cars[$time] = array(
			'id' => $time,
			'name' => $name,
			'description' => $desc,
			'price' => $price,
			'image' => $imageurl
		);
		$cr_info->update_cr_cars($cr_cars);
	}
	if($_REQUEST['delete']){
		cr_delete_upload($_REQUEST['delete']);
	}
	$cr_cars = $cr_info->get_cr_cars();
	$tim_url = CR_PLUGIN_URL . '/libs/timthumb.php?src='; 
	$tim_end = '&w=100&h=67&zc=1';
	
	?>
	<div class="wrap">
		<h2><div class="cr_hd"><div class="cr_car_img" id="cr_hd_img">&nbsp;</div><div class="cr_sales_h2">Cars</div></div></h2>
		<div class="cr_action"><span class='button-secondary'  onclick="cr_admin.new_c()">Add New Car</span></div>
		<?php if(!empty($cr_cars)) { ?>
			<table width="100%" border="0" class="widefat">
				<thead>
				  <tr>
					<th width="14%" align="left" scope="col">IMAGE</th>
					<th width="14%" align="left" scope="col">NAME</th>
					<th width="47%" align="left" scope="col">DESCRIPTION</th>
					<th width="13%" align="left" scope="col">PRICE PER DAY</th>
					<th width="12%" align="left" scope="col">ACTIONS</th>
				  </tr>
			   </thead>
			   <tbody>
				<?php foreach((array)$cr_cars as $cars => $car) : ?>
				  <tr>
					<td align="left"><img src="<?php echo $tim_url.$car['image'].$tim_end; ?>" /></td>
					<td align="left"><?php echo $car['name']; ?></td>
					<td align="left"><?php echo $car['description']; ?></td>
					<td align="left"><?php echo $car['price']; ?></td>
					<td align="left" style="vertical-align:middle">
						<a onclick="cr_admin.edit_c('<?php echo $car['id']; ?>')" href="#" class="button-primary">Edit</a>
						<a href="?page=car-rental-cars&amp;delete=<?php echo $car['id']; ?>" class="button">Delete</a>
					</td>
				  </tr>
				<?php endforeach; ?>
			   </tbody>
			</table>
		<?php } else{
			echo 'No cars found';
			}
		?>
	</div>
	<?php
	
}

function car_rental_settings(){
	global $cr_info;
	$cr_settings = $cr_info->get_cr_settings();
	?>
	<div class="wrap">
		<div class="cr_settings_holder curved">
			<h2><div class="cr_hd"><div class="cr_settings_img" id="cr_hd_img">&nbsp;</div><div class="cr_sales_h2">Settings</div></div></h2>
			<div class="tabber">

				 <div class="tabbertab">
				  <h2>Settings</h2>
				  <p><?php include CR_PLUGIN_FORMS_DIR.'/settings.php'; ?></p>
				 </div>


				 <div class="tabbertab">
				  <h2>Payment Options</h2>
				  <p><?php include CR_PLUGIN_FORMS_DIR.'/payment.php'; ?></p>
				 </div>

			</div>
		</div>
	</div>
	<?php
}
?>