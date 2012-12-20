<form class="form-horizontal" id="modify-form">
	<fieldset>
		<div class="control-group">
			<label class="control-label">Old Username: </label>
			<div class="controls">
			<input type="text" name="oldusername" readonly value="<?=$user;?>"></input>
			</div>
		</div>
		<div class="control-group error">
			<label class="control-label">New Username: </label>
			<div class="controls">
				<input type="text" name="newusername"></input>
			</div>
		</div>
	</fieldset>
</form>
