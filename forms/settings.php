<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <ul>
        <li><label for="fname">First Name<span> *</span>: </label>
        <input id="fname" size="40" name="fname" value="" />
		</li>   
 
        <li><label for="lname">Last Name<span> *</span>: </label>
        <input id="lname" size="40" name="lname" value="" />
		</li>
		<li><label for="lname">Email<span> *</span>: </label>
        <input id="email"  size="40" name="email" value="" />
		</li>
		<li>
			<input class='button-primary' type='submit' name='settings' value='<?php _e('Save Options'); ?>' id='submitbutton' />
		</li>
    </ul>
</form>