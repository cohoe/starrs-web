	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Range</legend>
			<div class="control-group">
				<label class="control-label">Name: </label>
				<div class="controls">
					<input type="text" name="name" value="<?=$r->get_name();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">First IP: </label>
				<div class="controls">
					<input type="text" name="firstip" value="<?=$r->get_first_ip();?>"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Last IP: </label>
				<div class="controls">
					<input type="text" name="lastip" value="<?=$r->get_last_ip();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Use: </label>
				<div class="controls">
					<select name="use">
						<?php
						foreach($uses as $use) {
							if($use == $r->get_use()) {
								print "<option selected>".htmlentities($use)."</option>";
							}
							else {
								print "<option>".htmlentities($use)."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">DHCP Class: </label>
				<div class="controls">
					<select name="class">
						<?php
						foreach($classes as $c) {
							if($r->get_class() == $c->get_class()) {
								print "<option selected>".htmlentities($c->get_class())."</option>";
							}
							else {
								print "<option>".htmlentities($c->get_class())."</option>";
							}
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
							if($az->get_zone() == $r->get_zone()) {
								print "<option selected>".htmlentities($az->get_zone())."</option>";
							}
							else {
								print "<option>".htmlentities($az->get_zone())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$r->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/ip/range/view/<?=rawurlencode($r->get_name());?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
			<input type="hidden" name="datacenter" value="<?=$r->get_datacenter();?>" />
		</fieldset>
	</form>
