	<form method="POST" class="form-horizontal" id="modify-form">
		<fieldset>
			<div class="control-group warning">
				<label class="control-label">Read-Only Community: </label>
				<div class="controls">
					<input type="text" name="ro" value="<?=$snmp->get_ro_community();?>" />
				</div>
			</div>
			<div class="control-group warning">
				<label class="control-label">Read-Write Community: </label>
				<div class="controls">
					<input type="text" name="rw" value="<?=$snmp->get_rw_community();?>" />
				</div>
			</div>
		</fieldset>
	</form>
