<form class="form-horizontal" id="modify-form">
	<fieldset>
		<div class="control-group">
			<label class="control-label">Hostname: </label>
			<div class="controls">
				<select name="hostname">
					<?php
					foreach($aRecs as $aRec) {
						if($aRec->get_hostname() == $tRec->get_hostname()) {
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
			<label class="control-label">Address: </label>
			<div class="controls">
				<select name="address">
					<?php
					foreach($intAddrs as $intAddr) {
						if($intAddr->get_address() == $tRec->get_address()) {
							print "<option value=\"".htmlentities($intAddr->get_address())."\" selected>".htmlentities($intAddr->get_address())."</option>";
						}
						else {
							print "<option value=\"".htmlentities($intAddr->get_address())."\">".htmlentities($intAddr->get_address())."</option>";
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Text: </label>
			<div class="controls">
				<input type="text" name="text" value="<?=htmlentities($tRec->get_text())?>"></input>
			</div>
		</div>
		<div class="control-group warning">
			<label class="control-label">TTL: </label>
			<div class="controls">
				<input type="text" name="ttl" value="<?=htmlentities($tRec->get_ttl())?>"></input>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Owner: </label>
			<div class="controls">
				<input type="text" name="owner" value="<?=htmlentities($tRec->get_owner());?>" <?=($user->isAdmin())?"":"readonly"?>></input>
			</div>
		</div>
	</fieldset>
</form>
