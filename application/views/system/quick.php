	<form method="POST" class="form-horizontal well span9" id="create-form">
		<fieldset>
			<legend>Create System Quick</legend>
			<div class="control-group error">
				<label class="control-label">System Name: </label>
				<div class="controls">
					<input type="text" name="system_name" />
				</div>
			</div>
			<div class="control-group error">
				<label class="control-label">MAC Address: </label>
				<div class="controls">
					<input type="text" name="mac" />
					<?if($random) {?>
					<a href="#" class="btn" id="random-mac">Random</a>
					<div id="mac-warning" class="alert hidden" style="margin-top: 1em; margin-bottom: 0em;">Heads Up! You should only use a random MAC address when you do not have access to the system's actual MAC address.</div>
					<?}?>
				</div>
			</div>
			<div class="controls docs-input-sizes">
               <p class="help-block">You only need to specify either an IP address or a range. If a range is selected, an IP address will be automatically entered for you. If you enter an IP address, it's range will be selected automatically. The rest of the fields typically do not need to be altered.</p>
               </div>
               <br />
               <div class="control-group error">
                    <label class="control-label">Range: </label>
                    <div class="controls">
                         <select name="range">
                              <option selected></option>
                              <?php
                              foreach($ranges as $range) {
                                   print "<option value=\"".htmlentities($range->get_name())."\">".htmlentities($range->get_name())." (".htmlentities($range->get_zone()).")</option>";
                              }
                              ?>
                         </select>
                    </div>
               </div>
               <div class="control-group error">
                    <label class="control-label">Address: </label>
                    <div class="controls">
                         <input type="text" name="address" />
                    </div>
               </div>
			<div class="control-group">	
				<label class="control-label">Config: </label>
				<div class="controls">
					<select name="config">
						<?php
						foreach($configs as $c) {
							print "<option>".htmlentities($c->get_config())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Create DNS: </label>
				<div class="controls">
				<select name="quickdns">
					<option <?=($dns=='yes'?"selected":"")?>>Yes</option>
					<option <?=($dns=='no'?"selected":"")?>>No</option>
				</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Zone: </label>
				<div class="controls">
					<select name="zone" <?=($dns=='no'?"readonly":"")?>>
						<?php
						foreach($zones as $z) {
							print "<option>".htmlentities($z->get_zone())."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Owner: </label>
				<div class="controls">
					<input type="text" name="owner" <?=($user->isAdmin())?"":"readonly";?> value="<?=htmlentities($user->get_user_name());?>" />
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label">Group: </label>
				<div class="controls">
					<select name="group">
						<?
						foreach($groups as $g) {
							if($g->get_group() == $default_group) {
								print "<option selected>".htmlentities($g->get_group())."</option>";
							} else {
								print "<option>".htmlentities($g->get_group())."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">	
				<div class="form-actions">
					<input type="submit" name="submit" value="Create System" class="btn btn-primary" />
					<a href="/systems/view" class="btn">Cancel</a>
				</div>
			</div>
		</fieldset>
	</form>
