<form class="form-horizontal">
	<fieldset>
		<div class="control-group">
			<label class="control-label">Record Type: </label>
			<div class="controls">
				<select name="rectype">
					<?php
					foreach($types as $type) {
						print "<option value=\"".htmlentities($type)."\">".htmlentities($type)."</option>";
					}
					?>
				</select>
				<input type="hidden" name="address" value="<?=$address;?>" />
			</div>
		</div>
	</fieldset>
</form>
