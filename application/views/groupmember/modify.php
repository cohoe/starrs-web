	<form method="POST" class="form-horizontal" id="modify-form">
		<fieldset>
			<input type="hidden" name="group" value="<?=$gm->get_group();?>" />
			<div class="control-group">
				<label class="control-label">User: </label>
				<div class="controls">
					<input type="text" name="user" value="<?=$gm->get_user();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Group Privilege: </label>
				<div class="controls">
					<select name="privilege">
						<option <?=($gm->get_privilege() == 'USER')?"selected":"";?>>USER</option>
						<option <?=($gm->get_privilege() == 'ADMIN')?"selected":"";?>>ADMIN</option>
						<option <?=($gm->get_privilege() == 'PROGRAM')?"selected":"";?>>PROGRAM</option>
					</select>
				</div>
			</div>
		</fieldset>
	</form>
