	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create System</legend>
			<div class="control-group error">
				<label class="control-label">System Name: </label>
				<div class="controls">
					<input type="text" name="systemName" value="<?=$name?>" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Type: </label>
				<div class="controls">
					<select name="type">
						<option selected></option>
						<?php
						foreach($sysTypes as $sysType) {
							print "<option value=\"".htmlentities($sysType->get_type())."\">".htmlentities($sysType->get_type())."</option>";	
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group error">	
				<label class="control-label">Operating System: </label>
				<div class="controls">
					<select name="osName">
						<option selected></option>
						<?php
						foreach($operatingSystems as $os) {
							print "<option value=\"".htmlentities($os)."\">".htmlentities($os)."</option>";	
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" />
				</div>
			</div>
			<div class="control-group warning">
				<label class="control-label">Asset: </label>
				<div class="controls">
					<input type="text" name="asset" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Platform: </label>
				<div class="controls">
					<select name="platform">
						<?
						foreach($platforms as $p) {
							print "<option>".htmlentities($p->get_platform_name())."</option>";
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
							print "<option>".htmlentities($dc->get_datacenter())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" <?=($user->isAdmin())?"":"readonly";?> value="<?=htmlentities($user->get_user_name());?>" />
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Group: </label>
				<div class="controls">
					<select name="group">
						<?
						foreach($groups as $g) {
							if($g->get_group() == $default_group) {
								print "<option selected>".htmlentities($g->get_group())."</option>";
							} else {
								print "<option>".htmlentities($g->get_group())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create System" class="btn btn-primary" />
					<a href="/systems/view" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
