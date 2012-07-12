	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Class</legend>
			<div class="control-group error">
				<label class="control-label">Class Name: </label>
				<div class="controls">
					<input type="text" name="class" />
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
					<input type="submit" name="submit" value="Create Class" class="btn btn-primary" />
					<a href="/dhcp/classes/view"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
