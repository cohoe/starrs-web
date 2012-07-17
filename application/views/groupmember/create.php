	<form method="POST" class="form-horizontal" id="create-form">
		<fieldset>
			<input type="hidden" name="group" value="<?=$g->get_group();?>" />
			<div class="control-group error">
				<label class="control-label">User: </label>
				<div class="controls">
					<input type="text" name="user" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Group Privilege: </label>
				<div class="controls">
					<select name="privilege">
						<option>USER</option>
						<option>ADMIN</option>
						<option>PROGRAM</option>
					</select>
				</div>
			</div>
		</fieldset>
	</form>
