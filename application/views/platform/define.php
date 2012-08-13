	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Define Platform</legend>
			<div class="control-group error">
				<label class="control-label">XML Definition: </label>
				<div class="controls">
					<!--<input type="field" name="definition" />-->
					<textarea style="width: 80%" rows="20" name="definition"></textarea>
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Define" class="btn btn-primary" />
					<a href="/platform/view/<?=rawurlencode($p->get_platform_name());?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
