	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify SOA</legend>
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
					<a href="/dns/soa/view/<?=rawurlencode($soa->get_zone());?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
