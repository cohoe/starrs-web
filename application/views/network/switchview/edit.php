<div class="item_container">
	<form method="POST" class="input_form">
	    <label for="community">SNMP RO Community: </label><input type="text" name="ro_community" value="<?echo $settings['ro_community'];?>" class="input_form_input" /><br />
        <label for="community">SNMP RW Community: </label><input type="text" name="rw_community" value="<?echo $settings['rw_community'];?>" class="input_form_input" /><br />
		<label for="enable">Enable?: </label>
		<input type="radio" name="enable" value="t" class="input_form_radio" <?echo ($settings['enable']=='t')?"checked":""?> />Yes
		<input type="radio" name="enable" value="f" class="input_form_radio" <?echo ($settings['enable']=='f')?"checked":""?> />No
        <br />
		<label for="submit">&nbsp;</label><input type="submit" name="submit" value="Save" class="input_form_submit"/>
	</form>
</div>