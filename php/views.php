<?php

function orderform(){
	?>
		<form action="">
			<table width="100%" border="0" id="cr_rental">
			  <tr>
				<td width="23%" align="left" valign="top">DATE AND TIME </td>
				<td width="31%" align="left" valign="top">
					Pick Up date 
					<input type="text" id="rent_from" class="date"/>
				</td>
				<td width="46%" align="left" valign="top">
					Return Date
					<input type="text" id="rent_to"  class="date" />
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top">Vehicle:</td>
				<td colspan="2" align="left" valign="top">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left" valign="top">Charge Per Day:</td>
				<td colspan="2" align="left" valign="top">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left" valign="top">Total Cost:</td>
				<td colspan="2" align="left" valign="top">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left" valign="top">&nbsp;</td>
				<td colspan="2" align="left" valign="top"><button>Continue</button></td>
			  </tr>
			</table>
			<script type="text/javascript">
				var currdate = new Date().getTime();
				function getDatePicker(inputid){
					jQuery('#'+inputid).DatePicker({
						format:'m/d/Y',
						date: jQuery('#'+inputid).val(),
						current: jQuery('#'+inputid).val(),
						starts: 1,
						position: 'r',
						onBeforeShow: function(){
							jQuery('#'+inputid).DatePickerSetDate(currdate, true);
						},
						onChange: function(formated, dates){
							jQuery('#'+inputid).val(formated);
							jQuery('#'+inputid).DatePickerHide();
						}
					});
				}
				getDatePicker('rent_from');
				getDatePicker('rent_to');
			</script>
		</form>
	<?php
}

function widgetform(){
	?>
	<table width="100%" border="0">
		  <tr>
			<td width="10%" valign="top">Pick Up Date:</td>
			<td width="90%" valign="top"><input type="text" id="rent_from_w" class="date"/></td>
		  </tr>
		  <tr>
			<td valign="top">Return Date:</td>
			<td valign="top"><input type="text" id="rent_to_w"  class="date" /></td>
		  </tr>
		  <tr>
			<td valign="top">Vehicle:</td>
			<td valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td valign="top">Charge Per Day:</td>
			<td valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td valign="top">Total Cost:</td>
			<td valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td valign="top">&nbsp;</td>
			<td valign="top"><button>Continue</button></td>
		  </tr>
	</table>
	<script type="text/javascript">
		var currdate = new Date().getTime();
		function getDatePicker(inputid){
			jQuery('#'+inputid).DatePicker({
				format:'m/d/Y',
				date: jQuery('#'+inputid).val(),
				current: jQuery('#'+inputid).val(),
				starts: 1,
				position: 'r',
				onBeforeShow: function(){
					jQuery('#'+inputid).DatePickerSetDate(currdate, true);
				},
				onChange: function(formated, dates){
					jQuery('#'+inputid).val(formated);
					jQuery('#'+inputid).DatePickerHide();
				}
			});
		}
		getDatePicker('rent_from_w');
		getDatePicker('rent_to_w');
	</script>
	<?php
}
?>