<form class="form-horizontal" id="create-form">
	<fieldset>
		<div class="control-group warning">
			<label class="control-label">Hostname</label>
			<div class="controls">
				<input type="text" name="hostname" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Zone</label>
			<div class="controls">
				<select name="zone">
					<option><?=$zone;?></option>
				</select>
			</div>
		</div>
		<div class="control-group error">
			<label class="control-label">Text</label>
			<div class="controls">
				<input type="text" name="text" />
			</div>
		</div>
		<div class="control-group warning">
			<label class="control-label">TTL</label>
			<div class="controls">
				<input type="text" name="ttl" />
			</div>
		</div>
	</fieldset>
</form>
