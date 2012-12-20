<div class="span7 well">
	<h2>Groups</h2>
	<br />
	<table class="table table-striped table-bordered imp-dnstable">
		<tr><th>Group</th><th style="width: 162px">Actions</th></tr>
		<?
		foreach($groups as $g) {
			#print "<tr><td>".htmlentities($c->get_option())."</td><td>".
			#	 htmlentities($c->get_value())."</td><td>
			#	 <a href=\"/configuration/view/".rawurlencode($c->get_option()).
			#	 "\"><button class=\"btn btn-mini btn-info\">Detail</button></a>
			#	 <a href=\"/configuration/modify/".rawurlencode($c->get_option()).
			#	 "\"><button class=\"btn btn-mini btn-warning\">Modify</button></a>
			#	 <a href=\"/configuration/remove/".rawurlencode($c->get_option()).
			#	 "\"><button class=\"btn btn-mini btn-danger\">Remove</button></a>
			#	 </td></tr>";
			print "<tr><td>{$g->get_group()}</td><td><a href=\"/groupmember/remove/".rawurlencode($g->get_group())."/".rawurlencode($user)."\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
		}
		?>
	</table>
	<h2>Systems</h2>
	<br />
	<table class="table table-striped table-bordered imp-dnstable">
		<tr><th>System</th><th style="width: 162px">Actions</th></tr>
		<?
		foreach($systems as $sys) {
			print "<tr><td><a href=\"/system/view/".rawurlencode($sys->get_system_name())."\">{$sys->get_system_name()}<a/></td><td><a href=\"/system/remove/".rawurlencode($sys->get_system_name())."\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
		}?>
	</table>
</div>
