	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Interface</legend>
			<div class="control-group error">
				<label class="control-label">Interface Name: </label>
				<div class="controls">
					<input type="text" name="name" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">MAC: </label>
				<div class="controls">
					<input type="text" name="mac" />
					<?if($random) {?>
					<a href="#" class="btn" id="random-mac">Random</a>
					<div id="mac-warning" class="alert hidden" style="margin-top: 1em; margin-bottom: 0em;">Heads Up! You should only use a random MAC address when you do not have access to the system's actual MAC address.</div>
					<?}?>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Interface" class="btn btn-primary" />
					<a href="/interfaces/view/<?=rawurlencode($systemName);?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
