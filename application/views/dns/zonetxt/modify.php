<form class="form-horizontal" id="modify-form">
	<fieldset>
		<div class="control-group warning">
			<label class="control-label">Hostname</label>
			<div class="controls">
				<input type="text" name="hostname" value="<?=$zt->get_hostname();?>" />&nbsp;<span id="inuse" class="label label-important imp-hide">In use!</span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Zone</label>
			<div class="controls">
				<select name="zone">
					<option><?=$zt->get_zone();?></option>
				</select>
			</div>
		</div>
		<div class="control-group error">
			<label class="control-label">Text</label>
			<div class="controls">
				<input type="text" name="text" value="<?=$zt->get_text();?>" />
			</div>
		</div>
		<div class="control-group warning">
			<label class="control-label">TTL</label>
			<div class="controls">
				<input type="text" name="ttl" value="<?=$zt->get_ttl();?>" />
			</div>
		</div>
	</fieldset>
</form>
