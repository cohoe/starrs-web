	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Group Provider Settings</legend>
			<div class="control-group">
				<label class="control-label">Group Name: </label>
				<div class="controls">
					<input type="text" name="group" readonly value="<?=htmlentities($g->get_group())?>"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">User Privilege: </label>
				<div class="controls">
					<select name="privilege">
						<option>USER</option>
						<option>ADMIN</option>
						<option>PROGRAM</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Provider: </label>
				<div class="controls">
					<select name="provider">
						<option>ldap</option>
						<option>local</option>
						<option>vcloud</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Hostname: </label>
				<div class="controls">
					<input type="text" name="hostname" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">ID: </label>
				<div class="controls">
					<input type="text" name="id" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Username: </label>
				<div class="controls">
					<input type="text" name="username" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Password: </label>
				<div class="controls">
					<input type="text" name="password" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Settings" class="btn btn-primary" />
					<a href="/group/view/<?=rawurlencode($g->get_group())?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
