	<form method="POST" class="form-horizontal well span9" id="search-form">
		<fieldset>
			<legend>Search</legend>
			<div class="control-group">
				<label class="control-label">Datacenter: </label>
				<div class="controls">
					<select name="datacenter">
						<option></option>
						<?php
						foreach($dcs as $dc) {
							print "<option>".htmlentities($dc->get_datacenter())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Availability Zone: </label>
				<div class="controls">
					<select name="availabilityzone">
						<option></option>
						<?php
						foreach($azs as $az) {
							print "<option>".htmlentities($az->get_zone())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">System Name: </label>
				<div class="controls">
					<input type="text" name="systemName" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Asset: </label>
				<div class="controls">
					<input type="text" name="asset" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Group: </label>
				<div class="controls">
					<select name="group">
						<option></option>
						<?php
						foreach($gs as $g) {
							print "<option>".htmlentities($g->get_group())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Platform: </label>
				<div class="controls">
					<select name="platform_name">
						<option></option>
						<?php
						foreach($platforms as $p) {
							print "<option>".htmlentities($p->get_platform_name())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">MAC Address: </label>
				<div class="controls">
					<input type="text" name="mac" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">IP Address: </label>
				<div class="controls">
					<input type="text" name="ipaddress" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Range: </label>
				<div class="controls">
					<select name="range">
						<option></option>
						<?php
						foreach($rs as $r) {
							print "<option>".htmlentities($r->get_name())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">DNS Hostname: </label>
				<div class="controls">
					<input type="text" name="hostname" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">DNS Zone: </label>
				<div class="controls">
					<select name="zone">
						<option></option>
						<?php
						foreach($zs as $z) {
							print "<option>".htmlentities($z->get_zone())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Last Modifier: </label>
				<div class="controls">
					<input type="text" name="lastmodifier" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Search" class="btn btn-primary" />
				</div>
			</div>
		</fieldset>
	</form>
