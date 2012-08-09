	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Host</legend>
			<div class="control-group error">
				<label class="control-label">System: </label>
				<div class="controls">
					<select name="system_name">
						<option selected></option>
						<?php
						foreach($systems as $sys) {
							print "<option>".htmlentities($sys->get_system_name())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group error">	
				<label class="control-label">URI: </label>
				<div class="controls">
					<input type="text" name="uri" />
				</div>
			</div>
			<div class="control-group warning">
				<label class="control-label">Password: </label>
				<div class="controls">
					<input type="password" name="password" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Host" class="btn btn-primary" />
					<a href="/libvirt/hosts/view" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
