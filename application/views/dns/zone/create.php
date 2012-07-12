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
					<input type="text" name="owner" <?=($isAdmin)?"":"readonly";?> value="<?=htmlentities($owner);?>" />
				</div>
			</div>
			<legend>Start of Authority (SOA)</legend>
			<div class="control-group error">	
				<label class="control-label">Nameserver: </label>
				<div class="controls">
					<input type="text" name="nameserver" />
				</div>
			</div>
			<div class="control-group error">	
				<label class="control-label">TTL: </label>
				<div class="controls">
					<input type="text" name="ttl" />
				</div>
			</div>
			<div class="control-group error">	
				<label class="control-label">Responsible Person: </label>
				<div class="controls">
					<input type="text" name="contact" />
				</div>
			</div>
			<div class="control-group error">	
				<label class="control-label">Serial: </label>
				<div class="controls">
					<input type="text" name="serial" />
				</div>
			</div>
			<div class="control-group error">	
				<label class="control-label">Refresh: </label>
				<div class="controls">
					<input type="text" name="refresh" />
				</div>
			</div>
			<div class="control-group error">	
				<label class="control-label">Retry: </label>
				<div class="controls">
					<input type="text" name="retry" />
				</div>
			</div>
			<div class="control-group error">	
				<label class="control-label">Expire: </label>
				<div class="controls">
					<input type="text" name="expire" />
				</div>
			</div>
			<div class="control-group error">	
				<label class="control-label">Minimum: </label>
				<div class="controls">
					<input type="text" name="minimum" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Zone" class="btn btn-primary" />
					<a href="/dns/zone"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
