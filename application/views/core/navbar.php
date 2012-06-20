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
             <li><a href="#"><?=$displayName." (".$userLevel.")"?></a></li>
		<li><form class="navbar-form">
			<select class="btn dropdown-toggle" name="user" id="viewuser" onchange="setViewUser()">
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
              <li class="active"><a href="/systems/view/<?=$viewUser;?>">Systems</a></li>
              <li><a href="#contact">DNS</a></li>
              <li><a href="#contact">DHCP</a></li>
              <li><a href="#contact">IP</a></li>
              <li><a href="#contact">Management</a></li>
              <li><a href="#contact">Network</a></li>
              <li><a href="#contact">Statistics</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
