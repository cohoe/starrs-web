	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Platform</legend>
			<div class="control-group">
				<label class="control-label">Platform Name: </label>
				<div class="controls">
					<input type="text" name="platform_name" value="<?=$p->get_platform_name();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Architecture: </label>
				<div class="controls">
					<select name="architecture">
						<?
						foreach($architectures as $arch) {
							if($p->get_architecture() == $arch) {
								print "<option selected>".htmlentities($arch)."</option>";
							} else {
								print "<option>".htmlentities($arch)."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Disk: </label>
				<div class="controls">
					<input type="text" name="disk" value="<?=$p->get_disk();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">CPU: </label>
				<div class="controls">
					<input type="text" name="cpu" value="<?=$p->get_cpu();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Memory (GB): </label>
				<div class="controls">
					<input type="text" name="memory" value="<?=$p->get_memory();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/platform/view/<?=rawurlencode($p->get_platform_name());?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
