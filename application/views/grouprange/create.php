	<form method="POST" class="form-horizontal" id="create-form">
		<fieldset>
			<input type="hidden" name="group" value="<?=$g->get_group();?>" />
			<div class="control-group">
				<label class="control-label">Range: </label>
				<div class="controls">
					<select name="range">
						<?
						foreach($rs as $r) {
							print "<option>".$r->get_name()."</option>";
						}
						?>
					</select>
				</div>
			</div>
		</fieldset>
	</form>
