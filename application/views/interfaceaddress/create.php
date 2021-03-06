	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Address</legend>
			<br />
			<div class="controls docs-input-sizes">
			<p class="help-block">You only need to specify either an IP address or a range. If a range is selected, an IP address will be automatically entered for you. If you enter an IP address, it's range will be selected automatically. The rest of the fields typically do not need to be altered.</p>
			</div>
			<br />
			<div class="control-group error">
				<label class="control-label">Range: </label>
				<div class="controls">
					<select name="range">
						<option selected></option>
						<?php
						foreach($ranges as $range) {
							print "<option value=\"".htmlentities($range->get_name())."\">".htmlentities($range->get_name())." (".htmlentities($range->get_datacenter())."::".htmlentities($range->get_zone()).")</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Address: </label>
				<div class="controls">
					<input type="text" name="address" />
				</div>
			</div>
			<hr />
			<div class="control-group">
				<label class="control-label">Interface: </label>
				<div class="controls">
					<select name="mac">
						<?php
						foreach($ints as $int) {
							if($int->get_mac() == $mac) {
								print "<option value=\"".htmlentities($int->get_mac())."\" selected>".htmlentities($int->get_mac())." (".htmlentities($int->get_system_name()).")</option>";
							}
							else {
								print "<option value=\"".htmlentities($int->get_mac())."\">".htmlentities($int->get_mac())." (".htmlentities($int->get_system_name()).")</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Primary: </label>
				<div class="controls">
					<select name="isprimary">
						<option value='t'>Yes</option>
						<option value='f'>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Config: </label>
				<div class="controls">
					<select name="config">
						<?php
						foreach($configs as $conf) {
							print "<option value=".htmlentities($conf->get_config()).">".htmlentities($conf->get_config())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">DHCP Class: </label>
				<div class="controls">
					<select name="class">
						<?php
						foreach($classes as $class) {
							print "<option value=".htmlentities($class->get_class()).">".htmlentities($class->get_class())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Renew Date: </label>
				<div class="controls">
					<input type="text" name="renew_date" value="<?=$date;?>" <?($user->isAdmin())?"":"readonly";?> />
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Address" class="btn btn-primary" />
					<a href="/addresses/view/<?=rawurlencode($mac);?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
