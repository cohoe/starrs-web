<div class="span7 well">
	<h2><a href="/system/view/<?=rawurlencode($sys->get_system_name());?>"><?=htmlentities($sys->get_system_name());?></a>
	<small><?=($ifs)?$ifs[0]->get_date():"No CAM data";?></small></h2>
	<table class="table table-bordered table-striped imp-dnstable">
		<tr><th>Name</th><th>Admin State</th><th>Operational State</th><th>Alias</th></tr>
		<?
		$up = "<span class=\"label label-success\">Up</span>";
		$down = "<span class=\"label label-inverse\">Down</span>";
		$disabled= "<span class=\"label label-important\">Disabled</span>";
		foreach($ifs as $if) {
			print "<tr><td>{$if->get_name()}</td><td>".(($if->get_admin_state()=='t')?$up:$disabled)."</td><td>".(($if->get_oper_state()=='t')?$up:$down)."</td><td>{$if->get_alias()}</td></tr>";
		}
		?>
	</table>
</div>
