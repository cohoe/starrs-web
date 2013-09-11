<div class="span7 well">
	<h2>Systems</h2>
	<br />
	<table class="table table-striped table-bordered imp-dnstable">
		<tr><th>System Name</th><th>Addresses</th><th style="width: 76px">Renew Date</th><th>Actions</th></tr>
		<?
		foreach($intAddrs as $intAddr) {
			print "<tr><td><a href=\"/system/view/".rawurlencode($intAddr->get_system_name())."\">".htmlentities($intAddr->get_system_name()).
			"</a></td><td><a href=\"/address/view/".rawurlencode($intAddr->get_address())."\">".htmlentities($intAddr->get_address())."</a></td><td>".htmlentities($intAddr->get_renew_date()).
			"</td><td><div class=\"btn-group\"><a class=\"btn btn-mini btn-info renew\" href=\"/address/renew/".rawurlencode($intAddr->get_address())."\">Renew</a><a class=\"btn btn-mini btn-danger\" href=\"/address/remove/".rawurlencode($intAddr->get_address())."\">Remove</a></div></td></tr>";
		}
		?>
	</table>
</div>
