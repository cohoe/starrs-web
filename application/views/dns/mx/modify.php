<form class="form-horizontal" id="modify-form">
	<fieldset>
		<div class="control-group">
			<label class="control-label">Zone: </label>
			<div class="controls">
				<select name="zone">
					<?php
					foreach($zones as $zone) {
						print "<option value=\"{$zone->get_zone()}\">{$zone->get_zone()}</option>";
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
						if($aRec->get_hostname() == $mRec->get_hostname()) {
							print "<option value=\"{$aRec->get_hostname()}\" selected>{$aRec->get_hostname()}</option>";
						}
						else {
							print "<option value=\"{$aRec->get_hostname()}\">{$aRec->get_hostname()}</option>";
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Preference: </label>
			<div class="controls">
				<input type="text" name="preference" value="<?=$mRec->get_preference()?>" />
			</div>
		</div>
		<div class="control-group warning">
			<label class="control-label">TTL: </label>
			<div class="controls">
				<input type="text" name="ttl" value="<?=$mRec->get_ttl()?>"></input>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Owner: </label>
			<div class="controls">
				<input type="text" name="owner" value="<?=$mRec->get_owner();?>" <?=($user->isAdmin())?"":"disabled"?>></input>
			</div>
		</div>
	</fieldset>
</form>
