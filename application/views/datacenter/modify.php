	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Datacenter</legend>
			<div class="control-group">
				<label class="control-label">Datacenter Name: </label>
				<div class="controls">
					<input type="text" name="name" value="<?=$dc->get_datacenter();?>" />
				</div>
			</div>
			<div class="control-group warning">
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$dc->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/datacenter/view/<?=rawurlencode($dc->get_datacenter());?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
