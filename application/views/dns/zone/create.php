	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Zone</legend>
			<div class="control-group error">
				<label class="control-label">Zone: </label>
				<div class="controls">
					<input type="text" name="zone" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Key: </label>
				<div class="controls">
					<select name="key">
						<option selected></option>
						<?
						foreach($keys as $k) {
							print "<option>".htmlentities($k->get_keyname())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Forward: </label>
				<div class="controls">
					<select name="forward">
						<option value=1>Yes</option>
						<option value=0>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Shared: </label>
				<div class="controls">
					<select name="shared">
						<option value=1>Yes</option>
						<option value=0>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">DDNS: </label>
				<div class="controls">
					<select name="ddns">
						<option value=0>No</option>
						<option value=1>Yes</option>
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
					<input type="text" name="owner" <?=($user->isAdmin())?"":"readonly";?> value="<?=htmlentities($user->get_user_name());?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Zone" class="btn btn-primary" />
					<a href="/dns/zone" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
