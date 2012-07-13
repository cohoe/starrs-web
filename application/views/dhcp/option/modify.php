<form class="form-horizontal" id="modify-form">
	<fieldset>
		<div class="control-group">
			<label class="control-label">Option: </label>
			<div class="controls">
				<input type="text" name="option" value="<?=$opt->get_option();?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Value: </label>
			<div class="controls">
				<input type="text" name="value" value="<?=$opt->get_value();?>" />
			</div>
		</div>
	</fieldset>
</form>
