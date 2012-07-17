	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Group</legend>
			<div class="control-group">
				<label class="control-label">Group Name: </label>
				<div class="controls">
					<input type="text" name="group" value="<?=$g->get_group();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Global Privilege: </label>
				<div class="controls">
					<select name="privilege">
						<option <?=($g->get_privilege() == 'USER')?"selected":"";?> >USER</option>
						<option <?=($g->get_privilege() == 'ADMIN')?"selected":"";?> >ADMIN</option>
						<option <?=($g->get_privilege() == 'PROGRAM')?"selected":"";?> >PROGRAM</option>
					</select>
				</div>
			</div>
			<div class="control-group warning">
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$g->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Modify Group" class="btn btn-primary" />
					<a href="/group/view/<?=rawurlencode($g->get_group());?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
