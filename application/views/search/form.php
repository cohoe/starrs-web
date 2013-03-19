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
							print "<option value=\"{$az->get_zone()}\">".htmlentities($az->get_zone())." (".$az->get_datacenter().")</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Location: </label>
				<div class="controls">
					<input type="text" name="location" />
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
				<label class="control-label">Subnet: </label>
				<div class="controls">
					<select name="subnet">
						<option></option>
						<?php
						foreach($snets as $snet) {
							print "<option>".htmlentities($snet->get_subnet())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">IP Address: </label>
				<div class="controls">
					<input type="text" name="ipaddress" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Config: </label>
				<div class="controls">
					<select name="config">
						<option></option>
						<?php
						foreach($configs as $c) {
							print "<option>".htmlentities($c->get_config())."</option>";
						}
						?>
					</select>
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
	<form method="POST" class="form-horizontal well span3" id="field-form">
		<fieldset>
			<legend>Fields</legend>
			Select the fields that you wish to have displayed from the search results.
			<div class="control-group">
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="datacenter" checked> Datacenter 
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="availability_zone" > Availablity Zone 
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="system_name" checked> System Name
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="location" > Location 
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="asset" > Asset 
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="group" > Group 
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="platform" > Platform 
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="mac" checked> MAC 
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="address" checked> Address
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="system_owner" checked> System Owner
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="system_last_modifier" > System Last Modifier
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="range" checked> Range
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="hostname" > Hostname
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="cname_alias" > CNAME
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="srv_alias" > SRV
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="zone" > DNS Zone
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="dns_owner" > DNS Owner
        			</label>
        			<label class="checkbox">
            			<input name="fields" type="checkbox" value="dns_last_modifier" > DNS Last Modifier
        			</label>
				<br />
					<ul class="unstyled inline">
					<li><a id="f-all" href="#">Select all</a></li>
					<li><a id="f-none" href="#">Select none</a></li>
					<li><a id="f-def" href="#">Select default</a></li>
					</ul>
    			</div>
		</fieldset>
	</form>
