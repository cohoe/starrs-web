	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Availability Zone</legend>
			<div class="control-group">
				<label class="control-label">Datacenter Name: </label>
				<div class="controls">
					<select name="datacenter">
					<?php
					foreach($dcs as $dc) {
						if($dc->get_datacenter() == $az->get_datacenter()) {
							print "<option selected>".htmlentities($dc->get_datacenter())."</option>";
						}
						else {
							print "<option>".htmlentities($dc->get_datacenter())."</option>";
						}
					}
					?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Zone: </label>
				<div class="controls">
					<input type="text" name="zone" value="<?=$az->get_zone();?>" />
				</div>
			</div>
			<div class="control-group warning">
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$az->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/datacenter/view/<?=rawurlencode($az->get_datacenter());?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
