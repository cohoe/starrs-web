<form class="form-horizontal" id="create-form">
	<fieldset>
		<div class="control-group error">
			<label class="control-label">Alias: </label>
			<div class="controls">
				<input type="text" name="alias" />&nbsp;<span id="inuse" class="label label-important imp-hide">In use!</span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Zone: </label>
			<div class="controls">
				<select name="zone">
					<?php
					foreach($zones as $zone) {
						print "<option value=\"".htmlentities($zone->get_zone())."\">".htmlentities($zone->get_zone())."</option>";
					}
					?>
				</select>
			</div>
		</div>
		<div class="control-group warning">
			<label class="control-label">TTL: </label>
			<div class="controls">
				<input type="text" name="ttl"></input>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Owner: </label>
			<div class="controls">
				<input type="text" name="owner" value="<?=htmlentities($user->get_user_name());?>" <?=($user->isAdmin())?"":"readonly"?>></input>
			</div>
		</div>
		<input type="hidden" name="address" value="<?=$address;?>" />
	</fieldset>
</form>
