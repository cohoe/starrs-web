<form class="form-horizontal" id="modify-form">
	<fieldset>
		<div class="control-group">
			<label class="control-label">Zone: </label>
			<div class="controls">
				<select name="zone">
					<?php
					foreach($zones as $zone) {
						if($nRec->get_zone() == $zone->get_zone()) {
							print "<option value=\"{$zone->get_zone()}\" selected>{$zone->get_zone()}</option>";
						}
						else {
							print "<option value=\"{$zone->get_zone()}\">{$zone->get_zone()}</option>";
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Nameserver: </label>
			<div class="controls">
				<input type="text" name="nameserver" value="<?=$nRec->get_nameserver()?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Address: </label>
			<div class="controls">
				<input type="text" name="address" value="<?=$nRec->get_address()?>" />
			</div>
		</div>
		<div class="control-group warning">
			<label class="control-label">TTL: </label>
			<div class="controls">
				<input type="text" name="ttl" value="<?=$nRec->get_ttl()?>"></input>
			</div>
		</div>
	</fieldset>
</form>
