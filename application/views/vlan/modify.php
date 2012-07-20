	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify VLAN</legend>
			<div class="control-group">
				<label class="control-label">Datacenter: </label>
				<div class="controls">
					<select name="datacenter">
					<?
					foreach($dcs as $dc) {
						if($dc->get_datacenter() == $v->get_datacenter()) {
							print "<option selected>".htmlentities($dc->get_datacenter())."</option>";
						} else {
							print "<option>".htmlentities($dc->get_datacenter())."</option>";
						}
					}
					?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Number: </label>
				<div class="controls">
					<input type="text" name="vlan" value="<?=$v->get_vlan();?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Name: </label>
				<div class="controls">
					<input type="text" name="name" value="<?=$v->get_name();?>" />
				</div>
			</div>
			<div class="control-group warning">
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$v->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Save" class="btn btn-primary" />
					<a href="/network/vlan/view/<?=rawurlencode($v->get_datacenter());?>/<?=rawurlencode($v->get_vlan());?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
