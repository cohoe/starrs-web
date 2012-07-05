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
			</div>
		</div>
	</fieldset>
</form>
