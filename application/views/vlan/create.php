	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create VLAN</legend>
			<div class="control-group error">
				<label class="control-label">Number: </label>
				<div class="controls">
					<input type="text" name="vlan" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Name: </label>
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
					<input type="submit" name="submit" value="Create VLAN" class="btn btn-primary" />
					<a href="/network/vlans/view" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
