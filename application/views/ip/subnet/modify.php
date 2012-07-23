	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Subnet</legend>
			<div class="control-group">
				<label class="control-label">Name: </label>
				<div class="controls">
					<input type="text" name="name" value="<?=$snet->get_name();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">CIDR Subnet: </label>
				<div class="controls">
					<input type="text" name="subnet" value="<?=$snet->get_subnet();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Zone: </label>
				<div class="controls">
					<select name="zone">
						<?php
						foreach($zones as $z) {
							if($z->get_zone() == $snet->get_zone()) {
								print "<option selected>".htmlentities($z->get_zone())."</option>";
							}
							else {
								print "<option>".htmlentities($z->get_zone())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Datacenter: </label>
				<div class="controls">
					<select name="datacenter">
						<?php
						foreach($dcs as $dc) {
							if($dc->get_datacenter() == $snet->get_datacenter()) {
								print "<option selected>".htmlentities($dc->get_datacenter())."</option>";
							}
							else {
								print "<option>".htmlentities($dc->get_datacenter())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">VLAN: </label>
				<div class="controls">
					<select name="vlan">
						<?php
						foreach($vlans as $v) {
							if($v->get_vlan() == $snet->get_vlan()) {
								print "<option selected>".htmlentities($v->get_vlan())."</option>";
							}
							else {
								print "<option>".htmlentities($v->get_vlan())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">DHCP Enable: </label>
				<div class="controls">
					<select name="dhcp_enable">
						<option value=1 <?($snet->get_dhcp_enable()=='t')?"selected":'';?>>Yes</option>
						<option value=0 <?($snet->get_dhcp_enable()=='f')?"selected":'';?>>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Autogen: </label>
				<div class="controls">
					<select name="autogen">
						<option value=t <?($snet->get_autogen()=='t')?"selected":'';?>>Yes</option>
						<option value=f <?($snet->get_autogen()=='f')?"selected":'';?>>No</option>
					</select>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$snet->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" value="<?=$snet->get_owner();?>" <?=(!$isAdmin)?"readonly":'';?> />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/ip/subnet/view/<?=rawurlencode($snet->get_subnet())?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
