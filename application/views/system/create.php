	<form method="POST" class="form-horizontal well span9" id="createForm">
		<fieldset>
			<legend>Create System</legend>
			<div class="control-group error">
				<label class="control-label">System Name: </label>
				<div class="controls">
					<input type="text" name="systemName" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Type: </label>
				<div class="controls">
					<select name="type">
						<option selected></option>
						<?php
						foreach($sysTypes as $sysType) {
							print "<option value=\"{$sysType->get_type()}\">{$sysType->get_type()}</option>";	
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
							print "<option value=\"{$os}\">{$os}</option>";	
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
			<div class="control-group">	
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" <?=($isAdmin)?"":"disabled";?> value="<?=$owner;?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create System" class="btn btn-primary" />
					<a href="/systems/view"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
