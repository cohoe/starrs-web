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
             <li><a href="#" onclick="setViewUser('<?=$userName;?>')"><?=$displayName." (".$userLevel.")"?></a></li>
		<li><form class="navbar-form">
			<select class="btn dropdown-toggle" style="width: auto" name="user" id="viewuser" onchange="setViewUser()">
			<option value="all">All</option>"
		<?php foreach($users as $user) {
			if($user == $userName) {
			echo "<option value=\"$user\" selected>$user</option>";
			} else {
			echo "<option value=\"$user\">$user</option>";
			}
		}?>
</select>
		</form></li>
		</ul>
          </div>
          <div class="nav-collapse">
            <ul class="nav">
		    <li <?=($header=='Systems')?'class="active"':null;?>><a href="/systems/view/<?=$viewUser;?>">Systems</a></li>
		    <li <?=($header=='DNS')?'class="active"':null;?>><a href="/dns/records/view/<?=$viewUser;?>">DNS</a></li>
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
