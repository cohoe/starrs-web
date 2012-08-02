	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify System</legend>
			<div class="control-group">
				<label class="control-label">System Name: </label>
				<div class="controls">
					<input type="text" name="systemName" value="<?=$sys->get_system_name();?>"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Type: </label>
				<div class="controls">
					<select name="type">
						<?php
						foreach($sysTypes as $sysType) {
							if($sysType->get_type() == $sys->get_type()) {
								print "<option value=\"".htmlentities($sysType->get_type())."\" selected>".htmlentities($sysType->get_type())."</option>";	
							}
							else {
								print "<option value=\"".htmlentities($sysType->get_type())."\">".htmlentities($sysType->get_type())."</option>";	
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Operating System: </label>
				<div class="controls">
					<select name="osName">
						<?php
						foreach($operatingSystems as $os) {
							if($os == $sys->get_os_name()) {
								print "<option value=\"".htmlentities($os)."\" selected>".htmlentities($os)."</option>";	
							}
							else {
								print "<option value=\"".htmlentities($os)."\">".htmlentities($os)."</option>";	
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=htmlentities($sys->get_comment());?>" />
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Asset: </label>
				<div class="controls">
					<input type="text" name="asset" value="<?=htmlentities($sys->get_asset());?>" />
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Platform: </label>
				<div class="controls">
					<select name="platform">
						<?
						foreach($platforms as $p) {
							if($p->get_platform_name() == $sys->get_platform()) {
								print "<option selected>".htmlentities($p->get_platform_name())."</option>";
							}
							else {
								print "<option>".htmlentities($p->get_platform_name())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Datacenter: </label>
				<div class="controls">
					<select name="datacenter">
						<?
						foreach($dcs as $dc) {
							if($dc->get_datacenter() == $sys->get_datacenter()) {
								print "<option selected>".htmlentities($dc->get_datacenter())."</option>";
							}
							else {
								print "<option>".htmlentities($dc->get_datacenter())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" <?=($isAdmin)?"":"readonly";?> value="<?=htmlentities($sys->get_owner());?>" />
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Group: </label>
				<div class="controls">
					<select name="group">
						<option></option>
						<?
						foreach($groups as $g) {
							if($g->get_group() == $sys->get_group()) {
								print "<option selected >".htmlentities($g->get_group())."</option>";
							}
							else {
								print "<option>".htmlentities($g->get_group())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/system/view/<?=rawurlencode($sys->get_system_name());?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
