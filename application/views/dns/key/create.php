	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Key</legend>
			<div class="control-group error">
				<label class="control-label">Key Name: </label>
				<div class="controls">
					<input type="text" name="keyname" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Key: </label>
				<div class="controls">
					<input type="text" name="key" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Encryption Algorithm: </label>
				<div class="controls">
					<input type="text" name="enctype" />
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
					<input type="submit" name="submit" value="Create Key" class="btn btn-primary" />
					<a href="/dns/keys" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
