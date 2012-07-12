	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create Subnet</legend>
			<div class="control-group error">
				<label class="control-label">Name: </label>
				<div class="controls">
					<input type="text" name="name" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">CIDR Subnet: </label>
				<div class="controls">
					<input type="text" name="subnet" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Zone: </label>
				<div class="controls">
					<select name="zone">
						<?php
						foreach($zones as $z) {
							print "<option>".htmlentities($z->get_zone())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">DHCP Enable: </label>
				<div class="controls">
					<select name="dhcp_enable">
						<option value=1>Yes</option>
						<option value=0>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Autogen: </label>
				<div class="controls">
					<select name="autogen">
						<option value=1>Yes</option>
						<option value=0>No</option>
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
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" <?=($isAdmin)?"":"readonly";?> value="<?=htmlentities($owner);?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create Subnet" class="btn btn-primary" />
					<a href="/ip/subnets/view"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
