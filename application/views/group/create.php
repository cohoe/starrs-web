	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Group</legend>
			<div class="control-group error">
				<label class="control-label">Group Name: </label>
				<div class="controls">
					<input type="text" name="group" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Global Privilege: </label>
				<div class="controls">
					<select name="privilege">
						<option>USER</option>
						<option>ADMIN</option>
						<option>PROGRAM</option>
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
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Group" class="btn btn-primary" />
					<a href="/groups/view"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
