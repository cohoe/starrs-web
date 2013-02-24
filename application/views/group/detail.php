<div class="row-fluid span7">
	<div class="row-fluid">
		<div class="well span4">
			<h2><?=htmlentities($g->get_group());?></h2>
			<dl class="dl-horizontal">
				<dt>Global Privilege</dt>
				<dd><?=htmlentities($g->get_privilege());?></dd>
				<dt>Renew Interval</dt>
				<dd><?=htmlentities($g->get_renew());?></dd>
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
		<div class="well span8">
			<h2>Provider Settings</h2>
			<?if($gset) {?>
			<dl class="dl-horizontal">
				<dt>Privilege</dt>
				<dd><?=htmlentities($gset->get_privilege());?></dd>
				<dt>Provider</dt>
				<dd><?=htmlentities($gset->get_provider());?></dd>
				<dt>Hostname</dt>
				<dd><?=htmlentities($gset->get_hostname());?></dd>
				<dt>ID</dt>
				<dd><?=htmlentities($gset->get_id());?></dd>
				<dt>Username</dt>
				<dd><?=htmlentities($gset->get_username());?></dd>
				<dt>Password</dt>
				<dd><?=htmlentities(preg_replace('[.]', '*', $gset->get_password()));?></dd>
			</dl>
				
			<?}?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="well">
			<h3>IP Ranges</h3>
			<table class="table table-bordered table-striped imp-dnstable">
				<tr><th>Name</th><th>First IP</th><th>Last IP</th><th style="width: 162px;">Actions</th></tr>
				<?
				foreach($ranges as $r) {
					$rem = "<a href=\"/grouprange/remove/".rawurlencode($g->get_group())."/".rawurlencode($r->get_name())."\"><button class=\"btn btn-mini btn-danger\">Remove</button></a>";
					print "<tr><td><a href=\"/ip/range/view/".rawurlencode($r->get_name())."\">".htmlentities($r->get_name())."</a></td><td>".htmlentities($r->get_first_ip())."</td><td>".htmlentities($r->get_last_ip())."</td><td>$rem</td></tr>";
				}
				?>
			</table>
		</div>
	</div>
	<div class="row-fluid">
		<div class="well">
			<h3>Members</h3>
			<?if($gms instanceof Exception) {
				print $gms->getMessage();
			} else {?>
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
			<?}?>
		</div>
	</div>
</div>
