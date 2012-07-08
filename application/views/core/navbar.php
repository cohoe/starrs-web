<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="/">IMPULSE</a>
			<div class="nav-collapse pull-right">
				<ul class="nav">
					<li><a href="#" onclick="setViewUser('<?=htmlentities($userName);?>')"><?=htmlentities($displayName)." (".htmlentities($userLevel).")"?></a></li>
					<?php if(isset($users)) {?>
					<li><form class="navbar-form">
						<select class="btn dropdown-toggle" style="width: auto" name="user" id="viewuser" onchange="setViewUser()">
							<option value="all">All</option>
							<?php foreach($users as $user) {
								if($user == $userName) {
									echo "<option value=\"".htmlentities($user)."\" selected>".htmlentities($user)."</option>";
								} else {
									echo "<option value=\"".htmlentities($user)."\">".htmlentities($user)."</option>";
								}
							}?>
						</select>
					</form></li>
					<?}?>
				</ul>
			</div>
			<div class="nav-collapse">
				<ul class="nav">
					<li <?=($header=='Systems')?'class="active"':null;?>><a href="/systems/view/">Systems</a></li>
					<li class="dropdown <?=($header=='DNS')?'active':null;?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">DNS <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/dns/records">Records</a></li>
							<li><a href="/dns/zones/">Zones</a></li>
							<li><a href="#">Keys</a></li>
						</ul>
					</li>
					<li <?=($header=='DHCP')?'class="active"':null;?>><a href="#">DHCP</a></li>
					<li <?=($header=='IP')?'class="active"':null;?>><a href="#">IP</a></li>
					<li <?=($header=='Management')?'class="active"':null;?>><a href="#">Management</a></li>
					<li <?=($header=='Network')?'class="active"':null;?>><a href="#">Network</a></li>
					<li <?=($header=='Statistics')?'class="active"':null;?>><a href="#">Statistics</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>
