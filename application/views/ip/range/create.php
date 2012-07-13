	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Range</legend>
			<div class="control-group error">
				<label class="control-label">Name: </label>
				<div class="controls">
					<input type="text" name="name" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">First IP: </label>
				<div class="controls">
					<input type="text" name="firstip" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">Last IP: </label>
				<div class="controls">
					<input type="text" name="lastip" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Use: </label>
				<div class="controls">
					<select name="use">
						<?php
						foreach($uses as $use) {
							print "<option>".htmlentities($use)."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">DHCP Class: </label>
				<div class="controls">
					<select name="class">
						<option></option>
						<?php
						foreach($classes as $c) {
							print "<option>".htmlentities($c->get_class())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Availability Zone: </label>
				<div class="controls">
					<select name="zone">
						<?php
						foreach($azs as $az) {
							print "<option>".htmlentities($az->get_zone())."</option>";
						}
						?>
					</select>
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
					<input type="submit" name="submit" value="Create Range" class="btn btn-primary" />
					<a href="/ip/subnet/view/<?=rawurlencode($snet->get_subnet());?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
			<input type="hidden" name="datacenter" value="<?=$snet->get_datacenter();?>" />
		</fieldset>
	</form>
