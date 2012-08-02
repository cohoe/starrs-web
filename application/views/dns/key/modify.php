	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Key</legend>
			<div class="control-group">
				<label class="control-label">Key Name: </label>
				<div class="controls">
					<input type="text" name="keyname" value="<?=$key->get_keyname();?>"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Key: </label>
				<div class="controls">
					<input type="text" name="key" value="<?=$key->get_key();?>"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Encryption Algorithm: </label>
				<div class="controls">
					<input type="text" name="enctype" value="<?=$key->get_enctype();?>"/>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$key->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" <?=($isAdmin)?"":"readonly";?> value="<?=$key->get_owner();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/dns/key/view/<?=rawurlencode($key->get_keyname());?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
