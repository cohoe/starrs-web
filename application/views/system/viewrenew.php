<div class="span7 well">
	<h2>Systems</h2>
	<br />
	<table class="table table-striped table-bordered imp-dnstable">
		<tr><th>System Name</th><th>Addresses</th><th style="width: 76px">Renew Date</th><th style="width: 50px">Renew</th></th></tr>
		<?
		foreach($systems as $sys) {
			$addrString = "";
			foreach($sysIntAddrs[$sys->get_system_name()] as $intAddr) {
				$addrString .= "<a href=\"/address/view/".rawurlencode($intAddr->get_address())."\">".$intAddr->get_address()."</a>, ";
			}
			print "<tr><td>".htmlentities($sys->get_system_name())."</td><td>$addrString</td><td>".htmlentities($sys->get_renew_date())."</td><td><a id=\"action-renew\" class=\"btn btn-mini btn-info\" href=\"/system/renew/".rawurlencode($sys->get_system_name())."\">Renew</a></td></tr>";
		}
		?>
	</table>
</div>
