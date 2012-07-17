<div class="span3 offset3"></div>
<div class="row-fluid span7">
	<div class="row-fluid">
		<div class="well">
			<h2><?=htmlentities($g->get_group());?></h2>
			<dl class="dl-horizontal">
				<dt>Global Privilege</dt>
				<dd><?=htmlentities($g->get_privilege());?></dd>
				<dt>Date Created</dt>
				<dd><?=htmlentities($g->get_date_created());?></dd>
				<dt>Date Modified</dt>
				<dd><?=htmlentities($g->get_date_modified());?></dd>
				<dt>Last Modifier</dt>
				<dd><?=htmlentities($g->get_last_modifier());?></dd>
				<dt>Comment</dt>
				<dd><?=htmlentities($g->get_comment());?>&nbsp;</dd>
			</dl>
		</div>
	</div>
	<div class="row-fluid">
		<div class="well">
			<h3>Members</h3>
			<table class="table table-bordered table-striped imp-dnstable">
				<tr><th>Username</th><th>Group Privilege</th><th style="width: 162px;">Actions</th></tr>
				<?
				foreach($gms as $gm) {
					$det = "<a href=\"/groupmember/view/".rawurlencode($gm->get_group())."/".rawurlencode($gm->get_user())."\"><button class=\"btn btn-mini btn-info\">Detail</button></a>";
					$mod= "<a href=\"/groupmember/modify/".rawurlencode($gm->get_group())."/".rawurlencode($gm->get_user())."\"><button class=\"btn btn-mini btn-warning\">Modify</button></a>";
					$rem = "<a href=\"/groupmember/remove/".rawurlencode($gm->get_group())."/".rawurlencode($gm->get_user())."\"><button class=\"btn btn-mini btn-danger\">Remove</button></a>";
					print "<tr><td>".htmlentities($gm->get_user())."</td><td>".htmlentities($gm->get_privilege())."</td><td>$det $mod $rem</tr>";
				}
				?>
			</table>
		</div>
	</div>
</div>
