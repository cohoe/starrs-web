<form class="form-horizontal" id="modify-form">
	<fieldset>
		<div class="control-group">
			<label class="control-label">Address: </label>
			<div class="controls">
				<select name="address">
					<?php
					foreach($intAddrs as $intAddr) {
						if($za->get_address() == $intAddr->get_address()) {
							print "<option selected value=\"{$intAddr->get_address()}\">".htmlentities($intAddr->get_address().' ('.$intAddr->get_system_name().')')."</option>";
						}
						else {
							print "<option value=\"{$intAddr->get_address()}\">".htmlentities($intAddr->get_address().' ('.$intAddr->get_system_name().')')."</option>";
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Zone</label>
			<div class="controls">
				<select name="zone">
					<option><?=$zone;?></option>
				</select>
			</div>
		</div>
		<div class="control-group warning">
			<label class="control-label">TTL</label>
			<div class="controls">
				<input type="text" name="ttl" value="<?=$za->get_ttl();?>" />
			</div>
	</fieldset>
</form>
