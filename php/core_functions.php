<?php
class car_rental{
	public static function edit_car_form($id){
		global $cr_info;
		$cr_cars = $cr_info->get_cr_cars();
		$car = $cr_cars[$id];
		return $car;
	}
}
?>