<?php
$alertpay_supported_currency = array('AUD', 'BGN', 'CAD', 'CHF', 'CZK', 'DKK', 'EKK', 'EUR', 'GBP', 'HKD', 'HUF', 'INR', 'LTL', 'MYR', 'MKD', 'NOK', 'NZD', 'PLN', 'RON', 'SEK', 'SGD', 'USD', 'ZAR');
?>
<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div id="alertpay" class="tabdiv">
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e("AlertPay ID","dp-lang");?></th>
			<td>
				<input size="50" type="text" value="<?php if(isset($cr_settings['alertpay_id'])) {echo $cr_settings['alertpay_id'];}?>" name="alertpay_id">
			</td>
		</tr>
		<?php
			$alertpay_currency_code = $cr_settings['alertpay_currency'];
				if (in_array($cr_settings['dp_shop_currency'], $alertpay_supported_currency)) {
					?>
					<input type="hidden" name="dp_alertpay_currency" value="<?php echo $cr_settings['dp_shop_currency']; ?>" />
					<?php
					$alertpay_currency_code = $cr_settings['dp_shop_currency'];
				}
				else {
				?>
				<tr><th scope="row"><?php _e("AlertPay Currency Code","dp-lang");?></th>
					<td>
						<select name="dp_alertpay_currency">
							<?php
							foreach ($alertpay_supported_currency as $a_code) {
								$a_selected = '';
								if ($alertpay_currency_code === $a_code) {
									$a_selected = 'selected="selected"';
								}
								?>
								<option value="<?php echo $a_code;?>" <?php echo $a_selected;?>><?php echo $a_code; ?></option>
								<?php
							}
							?>
						</select>
					</td>
				<?php
				}
			
			?>
		<tr><td colspan="2">
			<input class='button-primary' type='submit' name='payment' value='<?php _e('Save Options'); ?>' id='submitbutton' />
		</td></tr>
		
	</table>
</div>
</form>