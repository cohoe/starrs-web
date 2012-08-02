	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Platform</legend>
			<div class="control-group error">
				<label class="control-label">Platform Name: </label>
				<div class="controls">
					<input type="text" name="platform_name" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Architecture: </label>
				<div class="controls">
					<select name="architecture">
						<?
						foreach($architectures as $arch) {
							print "<option>".htmlentities($arch)."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Disk: </label>
				<div class="controls">
					<input type="text" name="disk" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">CPU: </label>
				<div class="controls">
					<input type="text" name="cpu" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Memory (GB): </label>
				<div class="controls">
					<input type="text" name="memory" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Platform" class="btn btn-primary" />
					<a href="/platforms/view" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
