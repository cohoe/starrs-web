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
								print "<option value=\"{$sysType->get_type()}\" selected>{$sysType->get_type()}</option>";	
							}
							else {
								print "<option value=\"{$sysType->get_type()}\">{$sysType->get_type()}</option>";	
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
								print "<option value=\"{$os}\" selected>{$os}</option>";	
							}
							else {
								print "<option value=\"{$os}\">{$os}</option>";	
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$sys->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" <?=($isAdmin)?"":"disabled";?> value="<?=$sys->get_owner();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/system/view/<?=$sys->get_system_name();?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
