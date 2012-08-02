	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Class</legend>
			<div class="control-group">
				<label class="control-label">Class Name: </label>
				<div class="controls">
					<input type="text" name="class" value="<?=$c->get_class();?>" />
				</div>
			</div>
			<div class="control-group warning">
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$c->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/dhcp/class/view/<?=rawurlencode($c->get_class());?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
