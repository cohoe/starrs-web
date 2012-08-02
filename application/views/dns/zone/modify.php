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
						<option value='t' <?=($z->get_forward()=='t')?"selected":'';?>>Yes</option>
						<option value='f' <?=($z->get_forward()=='f')?"selected":'';?>>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Shared: </label>
				<div class="controls">
					<select name="shared">
						<option value='t' <?=($z->get_shared()=='t')?"selected":'';?>>Yes</option>
						<option value='f' <?=($z->get_shared()=='f')?"selected":'';?>>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">DDNS: </label>
				<div class="controls">
					<select name="ddns">
						<option value='t' <?=($z->get_ddns()=='t')?"selected":'';?>>Yes</option>
						<option value='f' <?=($z->get_ddns()=='f')?"selected":'';?>>No</option>
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
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/dns/zone/view/<?=rawurlencode($z->get_zone());?>" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
