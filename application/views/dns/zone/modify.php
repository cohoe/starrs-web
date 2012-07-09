	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Zone</legend>
			<div class="control-group ">
				<label class="control-label">Zone: </label>
				<div class="controls">
					<input type="text" name="zone" value="<?=$z->get_zone();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Key: </label>
				<div class="controls">
					<select name="keyname">
						<?
						foreach($keys as $k) {
							if($k->get_keyname() == $z->get_keyname()) {
								print "<option selected>".htmlentities($k->get_keyname())."</option>";
							}
							else {
								print "<option>".htmlentities($k->get_keyname())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Forward: </label>
				<div class="controls">
					<select name="forward">
						<option value=1 <?=($z->get_forward()=='t')?"selected":'';?>>Yes</option>
						<option value=0 <?=($z->get_forward()=='f')?"selected":'';?>>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Shared: </label>
				<div class="controls">
					<select name="shared">
						<option value=1 <?=($z->get_shared()=='t')?"selected":'';?>>Yes</option>
						<option value=0 <?=($z->get_shared()=='f')?"selected":'';?>>No</option>
					</select>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$z->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" <?=($isAdmin)?"":"readonly";?> value="<?=$z->get_owner();?>" />
				</div>
			</div>
			<legend>Start of Authority (SOA)</legend>
			<div class="control-group ">	
				<label class="control-label">Nameserver: </label>
				<div class="controls">
					<input type="text" name="nameserver" value="<?=$soa->get_nameserver();?>" />
				</div>
			</div>
			<div class="control-group ">	
				<label class="control-label">TTL: </label>
				<div class="controls">
					<input type="text" name="ttl" value="<?=$soa->get_ttl();?>" />
				</div>
			</div>
			<div class="control-group ">	
				<label class="control-label">Responsible Person: </label>
				<div class="controls">
					<input type="text" name="contact" value="<?=$soa->get_contact();?>" />
				</div>
			</div>
			<div class="control-group ">	
				<label class="control-label">Serial: </label>
				<div class="controls">
					<input type="text" name="serial" value="<?=$soa->get_serial();?>" />
				</div>
			</div>
			<div class="control-group ">	
				<label class="control-label">Refresh: </label>
				<div class="controls">
					<input type="text" name="refresh" value="<?=$soa->get_refresh();?>" />
				</div>
			</div>
			<div class="control-group ">	
				<label class="control-label">Retry: </label>
				<div class="controls">
					<input type="text" name="retry" value="<?=$soa->get_retry();?>" />
				</div>
			</div>
			<div class="control-group ">	
				<label class="control-label">Expire: </label>
				<div class="controls">
					<input type="text" name="expire" value="<?=$soa->get_expire();?>" />
				</div>
			</div>
			<div class="control-group ">	
				<label class="control-label">Minimum: </label>
				<div class="controls">
					<input type="text" name="minimum" value="<?=$soa->get_minimum();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/dns/zone/view/<?=rawurlencode($z->get_zone());?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
