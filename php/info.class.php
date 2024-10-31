<?php

class cr_info{
	
	function get_cr_settings(){
		return get_option('cr_settings');
	}
	
	function get_cr_sales(){
		return get_option('cr_sales');
	}
	
	function get_cr_cars(){
		return get_option('cr_cars');
	}
	
	function update_cr_settings($cr_settings){
		update_option('cr_settings', $cr_settings);
	}
	
	function update_cr_sales($cr_sales){
		update_option('cr_sales', $cr_sales);
	}
	
	function update_cr_cars($cr_cars){
		update_option('cr_cars', $cr_cars);
	}
	
}