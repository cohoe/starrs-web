<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="/">STARRS</a>
			<div class="nav-collapse pull-right">
				<ul class="nav">
					<!--
					<li>
						<div class="btn-group">
							<div id="simpleui" class="btn btn-mini">Simple</div>
							<div id="advancedui" class="btn btn-mini">Advanced</div>
						</div>
					</li>-->
					<li><a href="#" onclick="setViewUser('<?=htmlentities($userName);?>')"><?=htmlentities($displayName)." (".htmlentities($userLevel).")"?></a></li>
					<?php if(isset($users)) {?>
					<li><form class="navbar-form">
						<select class="btn dropdown-toggle" style="width: auto" name="user" id="viewuser" onchange="setViewUser()">
							<option value="all">All</option>
							<option selected><?=$userName;?></option>
							<?php foreach($users as $user) {
								if($user == $userName) {
									#echo "<option value=\"".htmlentities($user)."\" selected>".htmlentities($user)."</option>";
								} else {
									echo "<option value=\"".htmlentities($user)."\">".htmlentities($user)."</option>";
								}
							}?>
						</select>
					</form></li>
					<?}?>
					<li><div id="uitoggle" class="btn btn-mini">Simple</div></li>
				</ul>
			</div>
			<div class="nav-collapse">
				<ul class="nav">
					<li class="dropdown <?=($header=='Systems')?'active':null;?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Systems <b class="caret"></b></a>
						<ul class="dropdown-menu">
					   <?php if($u->get_view_mode() == "Advanced") {?>
							<li <?=($sub=='Datacenters')?'class="active"':null;?>><a href="/datacenters/">Datacenters</a></li>
							<li <?=($sub=='Availability Zones')?'class="active"':null;?>><a href="/availabilityzones/view">Availability Zones</a></li>
							<li <?=($sub=='Platforms')?'class="active"':null;?>><a href="/platforms/view/">Platforms</a></li>
							<li class="divider"></li>
						<?}?>
							<li <?=($sub=='Systems')?'class="active"':null;?>><a href="/systems/view/">My Systems (<?=$viewUser?>)</a></li>
							<li <?=($sub=='Renew')?'class="active"':null;?>><a href="/addresses/viewrenew/">Renewal</a></li>
							<li <?=($sub=='Quick Create')?'class="active"':null;?>><a href="/system/quickcreate/">Quick Create</a></li>
						</ul>
					</li>
					<?php
					   if($u->get_view_mode() == "Advanced") {?>
					<li class="dropdown <?=($header=='DNS')?'active':null;?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">DNS <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li <?=($sub=='Records')?'class="active"':null;?>><a href="/dns/records">Records</a></li>
							<li <?=($sub=='Zones')?'class="active"':null;?>><a href="/dns/zones/">Zones</a></li>
							<li <?=($sub=='Keys')?'class="active"':null;?>><a href="/dns/keys/">Keys</a></li>
						</ul>
					</li>
					<li class="dropdown <?=($header=='IP')?'active':null;?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">IP <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li <?=($sub=='Subnets')?'class="active"':null;?>><a href="/ip/subnets">Subnets</a></li>
							<li <?=($sub=='Ranges')?'class="active"':null;?>><a href="/ip/ranges">Ranges</a></li>
						</ul>
					</li>
					<li class="dropdown <?=($header=='DHCP')?'active':null;?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">DHCP <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li <?=($sub=='Classes')?'class="active"':null;?>><a href="/dhcp/classes/view">Classes</a></li>
							<li <?=($sub=='Global Options')?'class="active"':null;?>><a href="/dhcp/globaloptions/view">Global Options</a></li>
							<li <?=($sub=='dhcpd')?'class="active"':null;?>><a href="/dhcp/dhcpd/view">ISC-DHCPD</a></li>
						</ul>
					</li>
					<li class="dropdown <?=($header=='Management')?'active':null;?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Management <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li <?=($sub=='Configuration')?'class="active"':null;?>><a href="/configuration/view">Configuration</a></li>
							<li <?=($sub=='Groups')?'class="active"':null;?>><a href="/groups/view/">Groups</a></li>
							<li <?=($sub=='Users')?'class="active"':null;?>><a href="/users/view/">Users</a></li>
						</ul>
					</li>
					<li class="dropdown <?=($header=='Network')?'active':null;?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Network <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li <?=($sub=='SNMP')?'class="active"':null;?>><a href="/network/snmp/">SNMP</a></li>
							<li <?=($sub=='CAM')?'class="active"':null;?>><a href="/network/cam/">CAM Tables</a></li>
							<li <?=($sub=='VLANs')?'class="active"':null;?>><a href="/network/vlans/">VLANs</a></li>
							<li <?=($sub=='Switchports')?'class="active"':null;?>><a href="/network/switchports/">Switchports</a></li>
						</ul>
					</li>
					<?}?>
					<li <?=($header=='Search')?'class="active"':null;?>><a href="/search">Search</a></li>
					<li class="dropdown <?=($header=='Help')?'active':null;?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Help <b class="caret"></b></a>
						<ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a href="#">Systems</a>
                                <ul class="dropdown-menu">
                                    <li <?=($sub=='Datacenters')?'class="active"':null;?>><a href="/help/systems/datacenters">Datacenters</a></li>
                                    <li <?=($sub=='Availability Zones')?'class="active"':null;?>><a href="/help/systems/availabilityzones">Availability Zones</a></li>
                                    <li <?=($sub=='Platforms')?'class="active"':null;?>><a href="/help/systems/platforms">Platforms</a></li>
                                    <li <?=($sub=='Systems')?'class="active"':null;?>><a href="/help/systems/systems">Systems</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#">DNS</a>
                                <ul class="dropdown-menu">
                                    <li <?=($sub=='Records')?'class="active"':null;?>><a href="/help/dns/records">Records</a></li>
                                    <li <?=($sub=='Zones')?'class="active"':null;?>><a href="/help/dns/zones">Zones</a></li>
                                    <li <?=($sub=='Keys')?'class="active"':null;?>><a href="/help/dns/keys">Keys</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#">IP</a>
                                <ul class="dropdown-menu">
                                    <li <?=($sub=='Subnets')?'class="active"':null;?>><a href="/help/ip/subnets">Subnets</a></li>
                                    <li <?=($sub=='Ranges')?'class="active"':null;?>><a href="/help/ip/ranges">Ranges</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#">DHCP</a>
                                <ul class="dropdown-menu">
                                    <li <?=($sub=='Classes')?'class="active"':null;?>><a href="/help/dhcp/classes">Classes</a></li>
                                    <li <?=($sub=='Global Options')?'class="active"':null;?>><a href="/help/dhcp/globaloptions">Global Options</a></li>
                                    <li <?=($sub=='ISC-DHCPD')?'class="active"':null;?>><a href="/help/dhcp/isc-dhcpd">ISC-DHCPD</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#">Management</a>
                                <ul class="dropdown-menu">
                                    <li <?=($sub=='Configuration')?'class="active"':null;?>><a href="/help/management/configuration">Configuration</a></li>
                                    <li <?=($sub=='Groups')?'class="active"':null;?>><a href="/help/management/groups">Groups</a></li>
                                    <li <?=($sub=='Users')?'class="active"':null;?>><a href="/help/management/users">Users</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#">Network</a>
                                <ul class="dropdown-menu">
                                    <li <?=($sub=='SNMP')?'class="active"':null;?>><a href="/help/network/snmp">SNMP</a></li>
                                    <li <?=($sub=='CAM Tables')?'class="active"':null;?>><a href="/help/network/camtables">CAM Tables</a></li>
                                    <li <?=($sub=='VLANs')?'class="active"':null;?>><a href="/help/network/vlans">VLANs</a></li>
                                    <li <?=($sub=='Switchports')?'class="active"':null;?>><a href="/help/network/switchports">Switchports</a></li>
                                </ul>
                            </li>
                            <li <?=($sub=='Search')?'class="active"':null;?>><a href="/help/search/">Search</a></li>
						</ul>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>
