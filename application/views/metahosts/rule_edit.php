<div class="item_container">
	<form method="POST" class="input_form">
		<label for="name">Metahost: </label>
		<select name="name" class="input_form_input">
			<? foreach ($mHosts as $mHost) {
				if($mHostName == $fwRule->get_metahost_name()) {
					echo "<option value=\"".$mHost->get_name()."\" selected>".$mHost->get_name()."</option>";
				}
				else {
					echo "<option value=\"".$mHost->get_name()."\">".$mHost->get_name()."</option>";
				}
			}?>
		</select>
		<label for="port">Port: </label><input type="text" name="port" class="input_form_input" value="<?echo $fwRule->get_port()?>" /><br />
		<label for="transport">Transport: </label>
		<select name="transport" class="input_form_input">
			<? foreach ($transports as $transport) {
				if($transport == $fwRule->get_transport()) {
					echo "<option value=\"$transport\" selected>$transport</option>";
				}
				else {
					echo "<option value=\"$transport\">$transport</option>";
				}
			} ?>
		</select><br />
		<label for="comment">Comment: </label><input type="text" name="comment" value="<?echo $fwRule->get_comment();?>" class="input_form_input" /><br /><br />
		<label for="text">Deny?: </label>
			<input type="radio" name="deny" value="t" class="input_form_radio" <?echo ($fwRule->get_deny() == 't')?"checked":""?> />Yes
			<input type="radio" name="deny" value="f" class="input_form_radio" <?echo ($fwRule->get_deny() == 'f')?"checked":""?> />No<br />
		<? if(isset($admin)) {?>
			<label for="owner">Owner: </label><input type="text" name="owner" value="<?echo $fwRule->get_owner();?>" class="input_form_input" /><br />
		<?} else {?>
			<input type="text" name="owner" value="<?echo $fwRule->get_owner();?>" class="input_form_input" hidden /><br />
		<?}?>
		<label for="submit">&nbsp;</label><input type="submit" name="submit" value="Save" class="input_form_submit"/>
	</form>
</div>