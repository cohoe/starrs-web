	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Datacenter</legend>
			<div class="control-group error">
				<label class="control-label">Datacenter Name: </label>
				<div class="controls">
					<input type="text" name="name" />
				</div>
			</div>
			<div class="control-group warning">
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Datacenter" class="btn btn-primary" />
					<a href="/datacenters/view" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
