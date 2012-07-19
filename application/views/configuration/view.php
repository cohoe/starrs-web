<div class="span7 well">
	<h2>Site Configuration</h2>
	<br />
	<table class="table table-striped table-bordered imp-dnstable">
		<tr><th>Option</th><th>Value</th><th style="width: 162px">Actions</th></tr>
		<?
		foreach($confs as $c) {
			print "<tr><td>".htmlentities($c->get_option())."</td><td>".
				 htmlentities($c->get_value())."</td><td>
				 <a href=\"/configuration/view/".rawurlencode($c->get_option()).
				 "\"><button class=\"btn btn-mini btn-info\">Detail</button></a>
				 <a href=\"/configuration/modify/".rawurlencode($c->get_option()).
				 "\"><button class=\"btn btn-mini btn-warning\">Modify</button></a>
				 <a href=\"/configuration/remove/".rawurlencode($c->get_option()).
				 "\"><button class=\"btn btn-mini btn-danger\">Remove</button></a>
				 </td></tr>";
		}
		?>
	</table>
</div>
