	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Address</legend>
			<?if($intAddr->get_dynamic() == 'f') {?>
			<div class="control-group">
				<label class="control-label">Range: </label>
				<div class="controls">
					<select name="range">
						<?php
						foreach($ranges as $range) {
							if($range->get_name() == $intAddr->get_range()) {
								print "<option value=\"".htmlentities($range->get_name())."\" selected>".htmlentities($range->get_name())." (".htmlentities($range->get_datacenter())."::".htmlentities($range->get_zone()).")</option>";
							}
							else {
								print "<option value=\"".htmlentities($range->get_name())."\">".htmlentities($range->get_name())." (".htmlentities($range->get_datacenter())."::".htmlentities($range->get_zone()).")</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group ">
				<label class="control-label">Address: </label>
				<div class="controls">
					<input type="text" name="address" value="<?=htmlentities($intAddr->get_address());?>" />
				</div>
			</div>
			<hr />
			<?} else {?>
					<input type="hidden" name="address" value="<?=htmlentities($intAddr->get_address());?>" />
			<?}?>
			<div class="control-group">
				<label class="control-label">Interface: </label>
				<div class="controls">
					<select name="mac">
						<?php
						foreach($ints as $int) {
							if($int->get_mac() != $currentInt->get_mac()) {
								print "<option value=\"".htmlentities($int->get_mac())."\">".htmlentities($int->get_mac())." (".htmlentities($int->get_system_name()).")</option>";

							}
						}
						print "<option value=\"".htmlentities($currentInt->get_mac())."\" selected>".htmlentities($currentInt->get_mac())." (".htmlentities($currentInt->get_system_name()).")</option>";
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Primary: </label>
				<div class="controls">
					<select name="isprimary">
						<?=$intAddr->get_isprimary();?>
						<option value='t' <?=($intAddr->get_isprimary()=='t')?"selected":null;?>>Yes</option>
						<option value='f' <?=($intAddr->get_isprimary()=='f')?"selected":null;?>>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Config: </label>
				<div class="controls">
					<select name="config">
						<?php
						foreach($configs as $conf) {
							if($intAddr->get_config() == $conf->get_config()) {
								print "<option value=".htmlentities($conf->get_config())." selected>".htmlentities($conf->get_config())."</option>";
							}
							else {
								print "<option value=".htmlentities($conf->get_config()).">".htmlentities($conf->get_config())."</option>";
							}
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
							if($class->get_class() == $intAddr->get_class()) {
								print "<option value=".htmlentities($class->get_class())." selected>".htmlentities($class->get_class())."</option>";
							}
							else {							
								print "<option value=".htmlentities($class->get_class()).">".htmlentities($class->get_class())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Renew Date: </label>
				<div class="controls">
					<input type="text" name="renew_date" value="<?=htmlentities($intAddr->get_renew_date());?>" <?($user->isAdmin())?"":"readonly";?> />
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=htmlentities($intAddr->get_comment());?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Modify Address" class="btn btn-primary" />
					<a href="/address/view/<?=rawurlencode($intAddr->get_address());?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
