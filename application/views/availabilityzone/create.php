	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Availability Zone</legend>
			<div class="control-group">
				<label class="control-label">Datacenter Name: </label>
				<div class="controls">
					<input type="text" name="datacenter" value="<?=$dc->get_datacenter();?>" readonly />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Zone: </label>
				<div class="controls">
					<input type="text" name="zone" />
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
					<input type="submit" name="submit" value="Create Availability Zone" class="btn btn-primary" />
					<a href="/datacenters/view/<?=rawurlencode($dc->get_datacenter());?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
