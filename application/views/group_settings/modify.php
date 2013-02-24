	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Group Provider Settings</legend>
			<div class="control-group">
				<label class="control-label">Group Name: </label>
				<div class="controls">
					<input type="text" name="group" value="<?=$g->get_group();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">User Privilege: </label>
				<div class="controls">
					<select name="privilege">
						<option <?=($gset->get_privilege() == 'USER')?"selected":"";?> >USER</option>
						<option <?=($gset->get_privilege() == 'ADMIN')?"selected":"";?> >ADMIN</option>
						<option <?=($gset->get_privilege() == 'PROGRAM')?"selected":"";?> >PROGRAM</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Provider: </label>
				<div class="controls">
					<select name="provider">
						<option <?=($gset->get_provider() == 'vcloud')?"selected":"";?> >vcloud</option>
						<option <?=($gset->get_provider() == 'ldap')?"selected":"";?> >ldap</option>
						<option <?=($gset->get_provider() == 'local')?"selected":"";?> >local</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Hostname: </label>
				<div class="controls">
					<input type="text" name="hostname" value="<?=$gset->get_hostname();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">ID: </label>
				<div class="controls">
					<input type="text" name="id" value="<?=$gset->get_id();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Username: </label>
				<div class="controls">
					<input type="text" name="username" value="<?=$gset->get_username();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Password: </label>
				<div class="controls">
					<input type="text" name="password" value="<?=$gset->get_password();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Modify Group" class="btn btn-primary" />
					<a href="/group/view/<?=rawurlencode($g->get_group());?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
