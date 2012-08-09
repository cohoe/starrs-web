	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Add Domain To Host</legend>
			<div class="control-group error">
				<label class="control-label">System: </label>
				<div class="controls">
					<select name="domain">
						<option selected></option>
						<?php
						foreach($systems as $sys) {
							print "<option>".htmlentities($sys->get_system_name())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Add Domain" class="btn btn-primary" />
					<a href="/libvirt/hosts/view" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
