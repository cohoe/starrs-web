<div class="item_container">
	<form method="POST" class="input_form">
		<label for="mac">Interface: </label><input type="text" name="mac" value="<?echo htmlentities($addr->get_mac());?>" disabled="disabled" class="input_form_input" /><br />
		<label for="range">Range: </label><select name="range" class="input_form_input">
			<? foreach ($ranges as $range) {
				if($addr->get_range() == $range->get_name()) {
					echo "<option value=\"".htmlentities($range->get_name())."\" selected=\"selected\">".htmlentities($range->get_name())."</option>";
				}
				else {
					echo "<option value=\"".htmlentities($range->get_name())."\">".htmlentities($range->get_name())."</option>";
				}
			} ?>
		</select></br>
		<div style="float: right; width: 100%; text-align: center;">-OR-</div>
		</br>
		<label for="address">Address: </label><input type="text" name="address" value="<?echo htmlentities($addr->get_address());?>" class="input_form_input" /><br />
		<label for="config">Configuration: </label><select name="config" class="input_form_input">
			<? foreach ($configs as $config) {
				if($addr->get_config() == $config->get_config()) {
					echo "<option value=\"".htmlentities($config->get_config())."\" selected=\"selected\" >".htmlentities($config->get_config())."</option>";
				}
				else {
					echo "<option value=\"".htmlentities($config->get_config())."\">".htmlentities($config->get_config())."</option>";
				}
			} ?>
		</select><br />
		<label for="class">Class: </label><select name="class" class="input_form_input">
			<? foreach ($classes as $class) {
				if($addr->get_class() == $class->get_class()) {
					echo "<option value=\"".htmlentities($class->get_class())."\" selected=\"selected\">".htmlentities($class->get_class())."</option>";
				}
				else {
					echo "<option value=\"".htmlentities($class->get_class())."\">".htmlentities($class->get_class())."</option>";
				}
			} ?>
		</select><br />
		
		
		<label for="isprimary">Primary Address?: </label>
		<input type="radio" name="isprimary" value="t" class="input_form_radio" <?echo ($addr->get_isprimary() == 't' ) ? "checked":"";?>/>Yes
		<input type="radio" name="isprimary" value="f" class="input_form_radio" <?echo ($addr->get_isprimary() == 'f')? "checked":"";?>/>No
		<label for="comment">Comment: </label><input type="text" name="comment" value="<?echo htmlentities($addr->get_comment());?>" class="input_form_input" /><br />
		<label for="submit">&nbsp;</label><input type="submit" name="submit" value="Save" class="input_form_submit"/>
	</form>
</div>