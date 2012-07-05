	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Interface</legend>
			<div class="control-group">
				<label class="control-label">System Name: </label>
				<div class="controls">
					<select name="systemName">
						<?php
						foreach($systems as $sys) {
							if($sys->get_system_name() == $int->get_system_name()) {
								print "<option value=\"".htmlentities($sys->get_system_name())."\" selected>".htmlentities($sys->get_system_name())."</option>";
							}
							else {
								print "<option value=\"".htmlentities($sys->get_system_name())."\">".htmlentities($sys->get_system_name())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Interface Name: </label>
				<div class="controls">
					<input type="text" name="name" value="<?=htmlentities($int->get_name());?>"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">MAC: </label>
				<div class="controls">
					<input type="text" name="mac" value="<?=htmlentities($int->get_mac());?>"/>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=htmlentities($int->get_comment());?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/interface/view/<?=rawurlencode($int->get_mac());?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
