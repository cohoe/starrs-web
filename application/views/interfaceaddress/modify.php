	<form method="POST" class="form-horizontal well span9" id="modify-form">
		<fieldset>
			<legend>Modify Address</legend>
			<div class="control-group">
				<label class="control-label">Range: </label>
				<div class="controls">
					<select name="range">
						<?php
						foreach($ranges as $range) {
							if($range->get_name() == $intAddr->get_range()) {
								print "<option value=\"{$range->get_name()}\" selected>{$range->get_name()}</option>";
							}
							else {
								print "<option value=\"{$range->get_name()}\">{$range->get_name()}</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group ">
				<label class="control-label">Address: </label>
				<div class="controls">
					<input type="text" name="address" value="<?=$intAddr->get_address();?>" />
				</div>
			</div>
			<hr />
			<div class="control-group">
				<label class="control-label">Interface: </label>
				<div class="controls">
					<select name="mac">
						<?php
						foreach($ints as $int) {
							if($int->get_mac() == $intAddr->get_mac()) {
								print "<option value=\"{$int->get_mac()}\" selected>{$int->get_mac()} ({$int->get_system_name()})</option>";
							}
							else {
								print "<option value=\"{$int->get_mac()}\">{$int->get_mac()} ({$int->get_system_name()})</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Primary: </label>
				<div class="controls">
					<select name="isprimary">
						<?=$intAddr->get_isprimary();?>
						<option value='t' <?=($intAddr->get_isprimary()=='t')?"selected":null;?>>Yes</option>
						<option value='f' <?=($intAddr->get_isprimary()=='f')?"selected":null;?>>No</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Config: </label>
				<div class="controls">
					<select name="config">
						<?php
						foreach($configs as $conf) {
							if($intAddr->get_config() == $conf->get_config()) {
								print "<option value={$conf->get_config()} selected>{$conf->get_config()}</option>";
							}
							else {
								print "<option value={$conf->get_config()}>{$conf->get_config()}</option>";
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
						foreach($classes as $class) {
							if($class->get_class() == $intAddr->get_class()) {
								print "<option value={$class->get_class()} selected>{$class->get_class()}</option>";
							}
							else {							
								print "<option value={$class->get_class()}>{$class->get_class()}</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group warning">	
				<label class="control-label">Comment: </label>
				<div class="controls">
					<input type="text" name="comment" value="<?=$intAddr->get_comment();?>" />
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Modify Address" class="btn btn-primary" />
					<a href="/address/view/<?=$intAddr->get_address();?>"><button class="btn">Cancel</button></a>
				</div>
			</div>
		</fieldset>
	</form>
