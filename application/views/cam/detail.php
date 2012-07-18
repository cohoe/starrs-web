<div class="span3 offset3"></div>
<div class="span7 well">
	<h2><a href="/system/view/<?=rawurlencode($sys->get_system_name());?>"><?=htmlentities($sys->get_system_name());?></a>
	<small><?=($cam)?$cam[0]['timestamp']:"No CAM data";?></small></h2>
	<table class="table table-bordered table-striped imp-dnstable">
		<tr><th>MAC Address</th><th>Port Name</th><th>VLAN</th></tr>
		<?
		foreach($cam as $c) {
			print "<tr><td><a href=\"/interface/view/".rawurlencode($c['mac'])."\">{$c['mac']}</a></td><td>{$c['ifname']}</td><td>{$c['vlan']}</td></tr>";
		}
		?>
	</table>
</div>
