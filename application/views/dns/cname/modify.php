<form class="form-horizontal" id="modify-form">
	<fieldset>
		<div class="control-group">
			<label class="control-label">Alias: </label>
			<div class="controls">
				<input type="text" name="alias" value="<?=htmlentities($cRec->get_alias())?>" />
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
		<div class="control-group">
			<label class="control-label">Hostname: </label>
			<div class="controls">
				<select name="hostname">
					<?php
					foreach($aRecs as $aRec) {
						if($aRec->get_hostname() == $cRec->get_hostname()) {
							print "<option value=\"".htmlentities($aRec->get_hostname())."\" selected>".htmlentities($aRec->get_hostname())."</option>";
						}
						else {
							print "<option value=\"".htmlentities($aRec->get_hostname())."\">".htmlentities($aRec->get_hostname())."</option>";
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="control-group warning">
			<label class="control-label">TTL: </label>
			<div class="controls">
				<input type="text" name="ttl" value="<?=htmlentities($cRec->get_ttl())?>"></input>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Owner: </label>
			<div class="controls">
				<input type="text" name="owner" value="<?=htmlentities($cRec->get_owner());?>" <?=($user->isAdmin())?"":"disabled"?>></input>
			</div>
		</div>
	</fieldset>
</form>
